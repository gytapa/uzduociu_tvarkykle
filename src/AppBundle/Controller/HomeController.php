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
/*
        $task = new Task();
        $task->setStatus('Naujas');
        $task->setName("Iskept bulviu ir kotletu");
        $task->setDescription('Reikia iskept nes nepavalgius bus blogai');
        $task->setCategory("butinas");
        $task->setAuthor("admin");
        $task->setCreationDate(date_create("2017-04-17"));

        $em = $this->getDoctrine()->getManager();

        // tells Doctrine you want to (eventually) save the Product (no queries yet)
        $em->persist($task);

        // actually executes the queries (i.e. the INSERT query)
        $em->flush();*/

        $repository = $this->getDoctrine()->getRepository('AppBundle:Task');
        $tasks = $repository->findByAuthor($this->getUser()->getUsername());

        return $this->render(
            'userpage.html.twig',array('username' => $username = $this->getUser()->getUsername(), 'tasks' => $tasks ));

    }
}