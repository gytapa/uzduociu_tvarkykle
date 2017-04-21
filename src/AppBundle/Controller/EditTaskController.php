<?php
// src/AppBundle/Controller/DefaultController.php
// ...

namespace AppBundle\Controller;
use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use AppBundle\Entity\Task;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EditTaskController extends Controller
{
    /**
     * @Route("/edit/{id}")
     *
     */
    public function editAction(Request $request, $id)
    {
        if ($id > 0 ) {
            //return new Response('<html><body>Admin page!</body></html>');
            $repository = $this->getDoctrine()
                ->getRepository('AppBundle:Task');
            $em = $this->getDoctrine()->getManager();
            $task = $repository->find($id);

            $form = $this->createFormBuilder($task)
                ->add('status', TextType::class)
                ->add('name', TextType::class)
                ->add('description', TextType::class)
                ->add('category', TextType::class)
                ->add('author', TextType::class)
                ->add('creation_date', DateType::class)
                ->add('save', SubmitType::class, array('label' => 'Apply Changes'))
                ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // $form->getData() holds the submitted values
                // but, the original `$task` variable has also been updated
                $task = $form->getData();

                // ... perform some action, such as saving the task to the database
                // for example, if Task is a Doctrine entity, save it!
                // $em = $this->getDoctrine()->getManager();
                // $em->persist($task);
                // $em->flush();

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
            $form = $this->createFormBuilder()
                ->add('status', TextType::class)
                ->add('name', TextType::class)
                ->add('description', TextType::class)
                ->add('category', TextType::class)
                ->add('author', TextType::class)
                ->add('creation_date', DateType::class)
                ->add('save', SubmitType::class, array('label' => 'Apply Changes'))
                ->getForm();

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


                // ... perform some action, such as saving the task to the database
                // for example, if Task is a Doctrine entity, save it!
                // $em = $this->getDoctrine()->getManager();
                // $em->persist($task);
                // $em->flush();
                $em = $this->getDoctrine()->getManager();
                $em->persist($taskToAdd);
                $em->flush();

                return $this->redirectToRoute('homepage');
            }

            return $this->render('taskmanipulation.html.twig', array(
                'form' => $form->createView(),
            ));
        }
        ///home/gytis/uzduociu_tvarkykle/taskmanager/app/Resources/views/taskmanipulation.html.twig
    }

}