<?php
namespace MyShop\DefaultBundle\Controller;
use MyShop\DefaultBundle\Entity\Customer;
use MyShop\DefaultBundle\Entity\Product;
use MyShop\DefaultBundle\Form\CustomerType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
class SearchController extends Controller
{
    /**
     * @Template()
     */
    public function indexAction(Request $request, $page = 1)
    {
        $searchKey = $request->get("searchKey", "");
        $dql = 'select p from MyShopDefaultBundle:Product p where 
              p.model like :search_key or
              p.description like :search_key';

        $query = $this->getDoctrine()->getManager()->createQuery($dql)->setParameter('search_key', "%" . $searchKey . "%")->getResult();

        $paginator = $this->get("knp_paginator");
        $productList = $paginator->paginate($query, $page, 4);

        return $this->render("@MyShopDefault/Default/showProductList.html.twig", [
            'productList' => $productList
        ]);
    }


}
