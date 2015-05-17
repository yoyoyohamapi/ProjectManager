<?php
/**
 * Created by CSCV.
 * User: Woo
 * Date: 15/4/6
 * Time: 下午10:38
 */

namespace CSCV\Bundle\AppBundle\Controller;

use CSCV\Bundle\StorageBundle\Document\Book;
use CSCV\Bundle\StorageBundle\Form\Type\BookType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class TestController extends Controller
{

    public function seaAction()
    {
        return $this->render('CSCVAppBundle:Test:sea.html.twig');
    }

    public function formAction(Request $request)
    {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $book = new Book();
        $form = $this->createForm(
            new BookType(),
            $book
        );
        $form->handleRequest($request);
        if ($form->isValid()) {
            $dm->persist($book);
            $dm->flush();
            $response = array(
                'success' => true
            );
        } else {
            //var_dump($form->getErrors());
        }

        return $this->render(
            '@CSCVApp/Test/form.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

}