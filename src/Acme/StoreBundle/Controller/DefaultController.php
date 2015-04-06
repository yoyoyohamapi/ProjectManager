<?php

namespace Acme\StoreBundle\Controller;

use Acme\StoreBundle\Document\Product;
use CSCV\Bundle\AppBundle\Form\Type\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    //Show all documents of Products
    public function indexAction()
    {
        $products = $this->get('doctrine_mongodb')
            ->getRepository('AcmeStoreBundle:Product')
            ->findAll();

        return $this->render('AcmeStoreBundle:Default:index.html.twig', array('products' => $products));
    }

    public function newAction(Request $request)
    {
        $product = new Product();
        $form = $this->createForm(new ProductType(), $product);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $dm = $this->get('doctrine_mongodb')->getManager();
            $dm->persist($product);
            $dm->flush();
        }

        return $this->render('AcmeStoreBundle:Default:new.html.twig', array('form' => $form->createView()));
    }

    //Creating a document in MongoDB
    public function createAction(Request $request)
    {
        $serializer = $this->get('jms_serializer');
        $content = $request->getContent();
        $str = urldecode($content);
        $json_str = json_encode($str);
        echo $json_str;
        $product = $serializer->deserialize($json_str, 'Acme\StoreBundle\Document\Product', 'json');


        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->persist($product);
        $dm->flush();

        return $this->redirect($this->generateUrl('acme_store_homepage'));
    }

    //Fetching documents from MongoDB
    public function showAction($id)
    {
        $product = $this->get('doctrine_mongodb')
            ->getRepository('AcmeStoreBundle:Product')
            ->find($id);

        if (!$product) {
            throw $this->createNotFoundException('No product found for id '.$id);
        }

        return $this->render('AcmeStoreBundle:Default:show.html.twig', array('product' => $product));
    }

    public function editAction($id, Request $request)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $product = $dm->getRepository('AcmeStoreBundle:Product')->find($id);

        $form = $this->createForm(new ProductType(), $product);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $dm = $this->get('doctrine_mongodb')->getManager();
            $dm->persist($product);
            $dm->flush();

            return $this->redirectToRoute('acme_store_show', array('id' => $product->getId()));
        }

        return $this->render('AcmeStoreBundle:Default:edit.html.twig', array('form' => $form->createView()));


    }

    //Updating a document in MongoDB
    public function updateAction($id)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $product = $dm->getRepository('AcmeStoreBundle:Product')->find($id);

        if (!$product) {
            throw $this->createNotFoundException('No product found for id '.$id);
        }
        $product->setName('New product name!');
        $dm->flush();

        return $this->redirect($this->generateUrl('acme_store_homepage'));
    }

    //Deleting a document in MongoDB
    public function deleteAction($id)
    {
        $product = $this->get('doctrine_mongodb')
            ->getRepository('AcmeStoreBundle:Product')
            ->find($id);

        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->remove($product);
        $dm->flush();

        return $this->redirect($this->generateUrl('acme_store_homepage'));
    }

}
