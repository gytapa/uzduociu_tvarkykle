<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 17.6.1
 * Time: 22.36
 */

namespace AppBundle\Controller;
use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use AppBundle\Entity\Task;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class AsignedTasksController extends Controller
{
    /**
     * @Route("/asigned", name="asigned")
     */
    public function showAsignedTasks(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Task');
        $tasks = $repository ->findByAuthor($this->getUser()->getUsername());

        $notConfirmedTasks = array();

        foreach($tasks as $task)
        {
            if($task->getConfirm() == 0){
                $notConfirmedTasks[] = $task;
            }
        }

//        dump($notConfirmedTasks);
//        die();
        return $this->render(
            'asignedtasks.html.twig',array(
            'username' => $username = $this->getUser()->getUsername(),
            'tasks' => $notConfirmedTasks
        ));
    }
}