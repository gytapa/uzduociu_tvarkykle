<?php
// src/AppBundle/Controller/DefaultController.php
// ...

namespace AppBundle\Controller;
use AppBundle\Entity\Category;
use AppBundle\Form\TaskType;
use AppBundle\Entity\User;
use AppBundle\Entity\Task;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    /**
     * @Route("/edit/{id}",name="editTask")
     *
     */
    public function editAction(Request $request, $id)
    {
        $category = $this->getDoctrine()->getManager();
        $products = $category->getRepository('AppBundle:Category')
            ->findAll();
        $categories = array();
        foreach($products as $cat)
        {
            $name = $cat->getName();
            $categories["$name"] = $name;
        }
        if ($id > 0 ) {
            $repository = $this->getDoctrine()
                ->getRepository('AppBundle:Task');
            $em = $this->getDoctrine()->getManager();
            $task = $repository->find($id);

            /*$options = ["username" =>$this->getUser()->getUsername(),
                        "categories" => $categories,
                        "create" => true];*/
            $form = $this->createForm(TaskType::class, $task, ["username" =>$this->getUser()->getUsername(),"categories" => $categories,"create" => false]);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em->flush();
                return $this->redirectToRoute('homepage');
            }

            return $this->render('taskmanipulation.html.twig', array(
                'form' => $form->createView(),
            ));
        }
        else
        {
            $emptyTask = new Task();
            $form = $this->createForm(TaskType::class, $emptyTask, ["username" =>$this->getUser()->getUsername(),"categories" => $categories,"create" => true]);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // $form->getData() holds the submitted values
                // but, the original `$task` variable has also been updated
                $em = $this->getDoctrine()->getManager();
                $task = $form->getData();
                $taskToAdd = new Task();
                $taskToAdd->setStatus($task['status']);
                $taskToAdd->setName($task['name']);
                $taskToAdd->setDescription($task['description']);
                $taskToAdd->setCategory($task['category']);
                $taskToAdd->setAuthor($task['author']);
                $taskToAdd->setCreationDate($task['creation_date']);

                $em = $this->getDoctrine()->getManager();
                $em->persist($taskToAdd);
                $em->flush();

                return $this->redirectToRoute('homepage');
            }

            return $this->render('taskmanipulation.html.twig', array(
                'form' => $form->createView(),
            ));
        }

    }

    /**
     * @Route("/delete/{id}",name="deleteTask")
     */
    public function adminAction($id)
    {
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:Task');
        $em = $this->getDoctrine()->getManager();
        $task = $repository->find($id);
        $em->remove($task);
        $em->flush();
        return new Response('<html><body>Task removed. ID: '.$id.'</body></html>');
    }

}


/*
 * temp failai
 * controlleriu pataisymas - check
 * form builderio trukumas - check
 * validacijos (forma ir modeliai) assert - check
 * route vardai ir prasmingi routes - check
 * relations - check
 * html kodas - check
 */