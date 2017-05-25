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
        $points = 0;
        $numberOfTasks = 0;

        foreach($tasks as $task){
            if($task->getStatus() == "Finished"){
                $points = $points + 50;
            }
            $numberOfTasks++;
        }

        return $this->render(
            'userpage.html.twig',array(
                'username' => $username = $this->getUser()->getUsername(),
                'tasks' => $tasks, 'points' => $points,
                'numberOfTasks' => $numberOfTasks
            ));
        $user->getTasks();
    }

//    /**
//     * @Route("/home", name="homepage")
//     */
//    public function showPoints(Request $request)
//    {
//        $repository = $this->getDoctrine()->getRepository('AppBundle:Task');
//        $tasks = $repository->findByAuthor($this->getUser()->getUsername());
//        $points = 0;
//        foreach($tasks as $key => $value){
//            $points += 50;
//        }
//
//        return $this->render('userpage.html.twig', array('points' => $points));
//    }

    /**
     * @Route("/",name="index")
     */
    public function indexPage(Request $request)
    {
        return $this->render('./security/login.html.twig');
    }
}

