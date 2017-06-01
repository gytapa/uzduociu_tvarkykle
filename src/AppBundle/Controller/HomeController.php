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
        $em = $this->getDoctrine()->getManager();
//        $repository = $em->getRepository('AppBundle:Task');

        $queryBuilder = $em->getRepository('AppBundle:Task')->createQueryBuilder('task');

       if ($request->query->getAlnum('search')){
           $queryBuilder
               ->where('task.name LIKE :name')
            ->setParameter('name', '%' . $request->query->getAlnum('search') . '%');
       }
        $repository = $queryBuilder->getQuery();

    $tasks = $repository;
//->findByAuthor($this->getUser()->getUsername());
        $points = $this->getPoints($tasks);
        $numberOfTasks = count($tasks);

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $tasks,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return $this->render(
            'userpage.html.twig',array(
                'username' => $username = $this->getUser()->getUsername(),
                'tasks' => $result, 'points' => $points,
                'numberOfTasks' => $numberOfTasks
            ));
        $user->getTasks();

        return $this->render('userpage.html.twig');
    }

    /**
     * @Route("/home/new",name="new")
     */
    public function newTasks(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Task');
        $tasks = $repository->findByAuthor($this->getUser()->getUsername());
        $points = $this->getPoints($tasks);
        $numberOfTasks = count($tasks);
        $newTask = array();


        foreach ($tasks as $task)
        {
            if($task->getStatus() == "New"){
                $newTask[] = $task;
            }
        }

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $newTask,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return $this->render(
            'userpage.html.twig',array(
            'username' => $username = $this->getUser()->getUsername(),
            'tasks' => $result, 'points' => $points,
            'numberOfTasks' => $numberOfTasks
        ));
    }

    /**
     * @Route("/home/inprogress",name="inprogress")
     */
    public function inProgressTasks(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Task');
        $tasks = $repository->findByAuthor($this->getUser()->getUsername());
        $points = $this->getPoints($tasks);
        $numberOfTasks = count($tasks);
        $newTask = array();

        foreach ($tasks as $task)
        {
            if($task->getStatus() == "In Progress"){
                $newTask[] = $task;
            }
        }

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $newTask,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return $this->render(
            'userpage.html.twig',array(
            'username' => $username = $this->getUser()->getUsername(),
            'tasks' => $result, 'points' => $points,
            'numberOfTasks' => $numberOfTasks
        ));
    }

    /**
     * @Route("/home/finished",name="finished")
     */
    public function finishedTasks(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Task');
        $tasks = $repository->findByAuthor($this->getUser()->getUsername());
        $points = $this->getPoints($tasks);
        $numberOfTasks = count($tasks);
        $newTask = array();

        foreach ($tasks as $task)
        {
            if($task->getStatus() == "Finished"){
                $newTask[] = $task;
            }
        }

        /**
         * @var $paginator \Knp\Component\Pager\Paginator
         */
        $paginator = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $newTask,
            $request->query->getInt('page', 1),
            $request->query->getInt('limit', 10)
        );

        return $this->render(
            'userpage.html.twig',array(
            'username' => $username = $this->getUser()->getUsername(),
            'tasks' => $result, 'points' => $points,
            'numberOfTasks' => $numberOfTasks
        ));
    }


    /**
     * @Route("/",name="index")
     */
    public function indexPage(Request $request)
    {
        return $this->render('./security/login.html.twig');
    }

    private function getPoints($tasks)
    {
        $points = 0;
        foreach($tasks as $task)
        {
            if($task->getStatus() == "Finished")
            {
                $points+=50;
            }
        }
        return $points;
    }
}

