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
use AppBundle\Entity\Category;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

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
            'category.html.twig', array(
            'categories' => $categories));
    }

    /**
     * @Route("/editcat/{id}")
     *
     */
    public function editAction(Request $request, $id)
    {
        if ($id > 0) {
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
        } else {
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

    /**
     * @Route("/deletecat/{id}")
     */
    public function adminAction($id)
    {
        $repository = $this->getDoctrine()
            ->getRepository('AppBundle:Category');
        $em = $this->getDoctrine()->getManager();
        $task = $repository->find($id);
        $em->remove($task);
        $em->flush();
        return new Response('<html><body>Task removed. ID: ' . $id . '</body></html>');
    }
}