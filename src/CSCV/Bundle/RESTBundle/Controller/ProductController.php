<?php

namespace CSCV\Bundle\RESTBundle\Controller;

use Acme\StoreBundle\Document\Product;
use CSCV\Bundle\AppBundle\Form\Type\ProductType;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc as ApiDoc;

class ProductController extends Controller
{
    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="获得所有商品",
     *  filters={
     *      {"name"="a-filter", "dataType"="integer"},
     *      {"name"="another-filter", "dataType"="string", "pattern"="(foo|bar) ASC|DESC"}
     *  }
     * )
     */
    public function getProductsAction()
    {
        //得到所有商品
        $products = $this->get('doctrine_mongodb')
            ->getRepository('AcmeStoreBundle:Product')
            ->findAll();

        $view = View::create()
            ->setStatusCode(200)
            ->setData($products);

        return $this->get('fos_rest.view_handler')->handle($view);
    }

    /**
     *
     * @ApiDoc(
     *  resource=true,
     *  description="根据商品id获得商品",
     *  filters={
     *      {"name"="a-filter", "dataType"="integer"},
     *      {"name"="another-filter", "dataType"="string", "pattern"="(foo|bar) ASC|DESC"}
     *  },
     *  statusCodes={
     *      200="请求成功",
     *      404="查无此商品"
     *  }
     * )
     */
    public function getProductAction($id)
    {
        $product = $this->get('doctrine_mongodb')
            ->getRepository('AcmeStoreBundle:Product')
            ->find($id);

        if (!$product) {
            throw $this->createNotFoundException('No product found for id '.$id);
        }

        $view = View::create()
            ->setStatusCode(200)
            ->setData($product);

        return $this->get('fos_rest.view_handler')->handle($view);

    }

    /**
     * @ApiDoc(
     *     resource=true,
     *     description="创建商品",
     *     input="product",
     *     output="Acme\StoreBundle\Document\Product"
     * )
     * @return mixed
     */
    public function postProductAction(Request $request)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $product = new Product();
        $form = $this->createForm(new ProductType(), $product);
        $form->handleRequest($request);
        if ($form->isValid()) {
            $dm->persist($product);
            $dm->flush();
        }
        $view = View::create()
            ->setStatusCode(200)
            ->setData($product);

        return $this->get('fos_rest.view_handler')->handle($view);
    }


}
