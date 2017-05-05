<?php
/**
 * Created by PhpStorm.
 * User: gytis
 * Date: 17.4.20
 * Time: 18.53
 */

namespace AppBundle\Controller;
use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use AppBundle\Entity\Task;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class HomeController extends Controller
{
    /**
     * @Route("/home", name="homepage")
     */
    public function succesfulLogin(Request $request)
    {

        $repository = $this->getDoctrine()->getRepository('AppBundle:Task');
        $tasks = $repository->findByAuthor($this->getUser()->getUsername());

        return $this->render(
            'userpage.html.twig',array('username' => $username = $this->getUser()->getUsername(), 'tasks' => $tasks ));

    }

    /**
     * @Route("/")
     */
    public function indexPage(Request $request)
    {
        return $this->render('index.html.twig');
    }
}

