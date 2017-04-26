<?php

namespace MyShop\DefaultBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OrdersProduct
 *
 * @ORM\Table(name="orders_product")
 * @ORM\Entity(repositoryClass="MyShop\DefaultBundle\Repository\OrdersProductRepository")
 */
class OrdersProduct
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="idProduct", type="integer")
     */
    private $idProduct;

    /**
     * @var string
     *
     * @ORM\Column(name="model", type="string", length=255)
     */
    private $model;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="count", type="integer")
     */
    private $count;

    /**
     * @var CustomerOrder
     *
     * @ORM\ManyToOne(targetEntity="MyShop\DefaultBundle\Entity\Orders", inversedBy="products")
     * @ORM\JoinColumn(name="id_order", referencedColumnName="id")
    */
    private $order;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set idProduct
     *
     * @param integer $idProduct
     *
     * @return OrdersProduct
     */
    public function setIdProduct($idProduct)
    {
        $this->idProduct = $idProduct;

        return $this;
    }

    /**
     * Get idProduct
     *
     * @return int
     */
    public function getIdProduct()
    {
        return $this->idProduct;
    }

    /**
     * Set model
     *
     * @param string $model
     *
     * @return OrdersProduct
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return OrdersProduct
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }

    /**
     * Get count
     *
     * @return integer
     */
    public function getCount()
    {
        return $this->count;
    }

    public function getSum()
    {
        return $this->price * $this->count;
    }

    public function getFullSum()
    {
        foreach ($products as $product)
        {
            $fullSum = array_sum($product->getSum());
        }
        return $fullSum;
    }

    /**
     * Set order
     *
     * @param \MyShop\DefaultBundle\Entity\Orders $order
     *
     * @return OrdersProduct
     */
    public function setOrder(\MyShop\DefaultBundle\Entity\Orders $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \MyShop\DefaultBundle\Entity\Orders
     */
    public function getOrder()
    {
        return $this->order;
    }

}
