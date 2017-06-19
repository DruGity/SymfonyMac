<?php

namespace MyShop\DefaultBundle\Controller;

use MyShop\DefaultBundle\Entity\Customer;
use MyShop\DefaultBundle\Entity\Product;
use MyShop\DefaultBundle\Form\CustomerType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends Controller
{
    /**
     * @Template()
    */
    public function loginAction()
    {
        return [];
    }

    /**
     * @Template()
     */
    public function registrationAction(Request $request)
    {
        $customer = new Customer();

        $form = $this->createForm(CustomerType::class, $customer);



        $form->handleRequest($request);
        if ($request->isMethod("POST"))

        {
            $passwordHashed = $this->get('security.password_encoder')->encodePassword($customer, $customer->getPlainPassword());
            $customer->setPassword($passwordHashed);

            $manager = $this->getDoctrine()->getManager();
            $manager->persist($customer);
            $manager->flush();

            $email = $customer->getEmail();
            $name = $customer->getName();
            $cid = $customer->getId();

            $sol = $email."/".$name."/".$cid;

            $str = base64_encode($sol);

            $str = "http://" . "$_SERVER[HTTP_HOST]" . "/email/confirm/" . $str;
            $mail = $this->get("myshop_admin.sending_mail");
            $mail->sendEmail( "Спасибо за регистрацию $name!" . "<br />" . "Перейдите по ссылке, что бы авторезироваться" . " " . "-" . " " . "<a href='$str'>$str</a>", $email);

           /* $this->addFlash("success", "Спасибо за регистрацию!");*/
            return $this->redirectToRoute("myshop.go_to_email");



        }


        return [
            'form' => $form->createView(),
        ];
    }

    /**
     * @Template()
     */
    public function confirmUserAction($str)
    {
        $str = base64_decode($str);
        $str = explode('/', $str);
        $id = array_pop($str);
        (integer)$id;

        $manager = $this->getDoctrine()->getManager();
        $customer = $this->getDoctrine()->getRepository("MyShopDefaultBundle:Customer")->find($id);

        $customer->setIsActive(true);
        $manager->persist($customer);
        $manager->flush();


        return [
            'customer' => $customer
        ];

    }

    /**
     * @Template()
     */
    public function goToEmailAction()
    {

        return [];

    }



}
