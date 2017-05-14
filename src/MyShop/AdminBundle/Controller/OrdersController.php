<?php

namespace MyShop\AdminBundle\Controller;

use MyShop\DefaultBundle\Entity\Orders;
use MyShop\DefaultBundle\Entity\Customer;
use MyShop\DefaultBundle\Entity\OrdersProduct;
use MyShop\DefaultBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class OrdersController extends Controller
{
	/**
     * @Template()
    */
    public function indexAction(Request $request)
    {
        $page = $request->get("page", 0);

        //$ordersList = $this->getDoctrine()->getRepository('MyShopDefaultBundle:Orders')->findAll();
        // сделать через findBy() - сортировка + сделать пагинацию*/

//        $orders = $this->getDoctrine()->getManager()->getRepository("MyShopDefaultBundle:Orders")
//            ->findBy([], ["dateCreatedAt" => "desc"]);
        $query = $this->getDoctrine()->getManager()->createQuery("select o from MyShopDefaultBundle:Orders o WHERE o.status = 2");
        $paginator = $this->get("knp_paginator");
        $ordersList = $paginator->paginate($query, $page, 1);
//        $ordersList = $query->getResult();

        $income = $this->fullIncome($ordersList); // подсчет дохода

        return [
        'ordersList' => $ordersList,
        'income' => $income
        ];
    }

    public function filterAction(Request $request)
    {
        $page = $request->get("page", 0);
        $query = $this->getDoctrine()->getManager()->createQuery("select o from MyShopDefaultBundle:Orders o where o.confirm = 2 and o.status = 2 ");
        //$ordersList = $query->getResult();
        $paginator = $this->get("knp_paginator");
        $ordersList = $paginator->paginate($query, $page, 1);

        $income = $this->fullIncome($ordersList);

        return $this->render("@MyShopAdmin/Orders/index.html.twig", [
            "ordersList" => $ordersList,
            "income" => $income

        ]);
    }


    public function  closeFilterAction(Request $request)
    {
        $page = $request->get("page", 0);

        $query = $this->getDoctrine()->getManager()->createQuery("select o from MyShopDefaultBundle:Orders o where o.confirm = 1 and o.status = 2 ");
        $paginator = $this->get("knp_paginator");
        $ordersList = $paginator->paginate($query, $page, 1);
        //$ordersList = $query->getResult();

        $income = $this->fullIncome($ordersList);

        return $this->render("@MyShopAdmin/Orders/index.html.twig", [
            "ordersList" => $ordersList,
            "income" => $income
        ]);
    }

    public function  fullIncome($ordersList)
    {
        $income = 0;
        foreach ($ordersList as $index)
        {
            $total = $index->getTotalPrice();
            $income = $total + $income;
        }
        return $income;
    }

    public function confirmAction(Request $request, $id)
    {
        $manager = $this->getDoctrine()->getManager();
        $order = $manager->getRepository('MyShopDefaultBundle:Orders')->find($id);

        if ($request->isMethod("POST"))
        {
            $order->setConfirmStatus(Orders::STATUS_CONFIRMED);
            $manager->persist($order);
            $manager->flush();

            $this->addFlash("success", "Заказ Подтвержден!");

            return $this->redirectToRoute("myshop.admin_order_list");
        }

        return [
            'order' => $order
        ];
    }

    public function productRemoveAction(Orders $order, $idProduct)
    {
        $manager = $this->getDoctrine()->getManager();
        $orderProduct = $manager->getRepository("MyShopDefaultBundle:Orders")->findOneBy([
            'id' => $idProduct,
            'order' => $order
        ]);
        $manager->remove($orderProduct);
        $manager->flush();
        return $this->redirectToRoute("myshop.admin_order_list", ['id' => $order->getId()]);
    }
}
