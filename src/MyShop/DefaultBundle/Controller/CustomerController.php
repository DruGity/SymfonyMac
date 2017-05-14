<?php

namespace MyShop\DefaultBundle\Controller;

use MyShop\DefaultBundle\Entity\Customer;
use MyShop\DefaultBundle\Entity\Product;
use MyShop\DefaultBundle\Entity\TimeCustomer;
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

            $cid = $customer->getId();
            $email = $customer->getEmail();


            $str = "http://" . "$_SERVER[HTTP_HOST]" . "/email/confirm/" . $cid;
            $mail = $this->get("myshop_admin.sending_mail");
            $mail->sendEmail("Перейдите по ссылке, что бы авторезироваться" . " " . "-" . " " . "<a href='$str'>$str</a>", $email);

           /* $this->addFlash("success", "Спасибо за регистрацию!");*/
            return $this->redirectToRoute("myshop.main_page");
        }


        return [
            'form' => $form->createView()
        ];
    }

    /**
     * @Template()
     */
    public function confirmUserAction($id)
    {
        $manager = $this->getDoctrine()->getManager();
        $customer = $this->getDoctrine()->getRepository("MyShopDefaultBundle:Customer")->find($id);

        $customer->setIsActive(true);
        $manager->persist($customer);
        $manager->flush();


        return [
            'customer' => $customer
        ];

    }

}

