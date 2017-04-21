<?php
// src/AppBundle/Controller/DefaultController.php
// ...

namespace AppBundle\Controller;
use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use AppBundle\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EditCategoryController extends Controller
{
    /**
     * @Route("/editcat/{id}")
     *
     */
    public function editAction(Request $request, $id)
    {
        if ($id > 0 ) {
            //return new Response('<html><body>Admin page!</body></html>');
            $repository = $this->getDoctrine()
                ->getRepository('AppBundle:Category');
            $em = $this->getDoctrine()->getManager();
            $task = $repository->find($id);

            $form = $this->createFormBuilder($task)
                ->add('name', TextType::class)
                ->add('creationDate', DateType::class)
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
                return $this->redirectToRoute('category');
            }

            return $this->render('taskmanipulation.html.twig', array(
                'form' => $form->createView(),
            ));
        }
        else
        {
            $taskToAdd = new Category();
            $form = $this->createFormBuilder()
                ->add('name', TextType::class)
                ->add('creationDate', DateType::class)
                ->add('save', SubmitType::class, array('label' => 'Apply Changes'))
                ->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // $form->getData() holds the submitted values
                // but, the original `$task` variable has also been updated
                $em = $this->getDoctrine()->getManager();
                $task = $form->getData();
                $taskToAdd = new Category();
                $taskToAdd->setName($task['name']);
                $taskToAdd->setCreationDate($task['creationDate']);


                // ... perform some action, such as saving the task to the database
                // for example, if Task is a Doctrine entity, save it!
                // $em = $this->getDoctrine()->getManager();
                // $em->persist($task);
                // $em->flush();
                $em = $this->getDoctrine()->getManager();
                $em->persist($taskToAdd);
                $em->flush();

                return $this->redirectToRoute('category');
            }

            return $this->render('taskmanipulation.html.twig', array(
                'form' => $form->createView(),
            ));
        }
        ///home/gytis/uzduociu_tvarkykle/taskmanager/app/Resources/views/taskmanipulation.html.twig
    }

}