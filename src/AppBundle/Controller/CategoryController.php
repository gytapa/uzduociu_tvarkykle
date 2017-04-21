<?php
/**
 * Created by PhpStorm.
 * User: gytis
 * Date: 17.4.21
 * Time: 11.49
 */

namespace AppBundle\Controller;
use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use AppBundle\Entity\Task;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class CategoryController extends Controller
{
    /**
     * @Route("/category", name="category")
     */
    public function succesfulLogin(Request $request)
    {
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:Category');
        $em = $this->getDoctrine()->getManager();
        $categories = $repository->findAll();
        return $this->render(
        'category.html.twig',array(
            'categories' => $categories));
    }


}