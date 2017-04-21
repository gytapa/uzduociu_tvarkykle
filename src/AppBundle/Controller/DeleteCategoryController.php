<?php

namespace AppBundle\Controller;
use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use AppBundle\Entity\Task;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DeleteCategoryController extends Controller
{
    /**
     * @Route("/deletecat/{id}")
     */
    public function adminAction($id)
    {
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:Category');
        $em = $this->getDoctrine()->getManager();
        $category = $repository->find($id);
        $em->remove($category);
        $em->flush();
        return new Response('<html><body>Category removed. ID: '.$id.'</body></html>');
    }
}