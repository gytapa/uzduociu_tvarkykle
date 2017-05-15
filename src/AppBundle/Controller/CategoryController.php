<?php
/**
 * Created by PhpStorm.
 * User: gytis
 * Date: 17.4.21
 * Time: 11.49
 */

namespace AppBundle\Controller;
use AppBundle\Form\DateType;
use AppBundle\Form\CategoryType;
use AppBundle\Entity\User;
use AppBundle\Entity\Task;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Category;


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
     * @Route("/editcat/{id}",name="editCat")
     *
     */
    public function editAction(Request $request, $id)
    {
        if ($id > 0) {
            $repository = $this->getDoctrine()
                ->getRepository('AppBundle:Category');
            $em = $this->getDoctrine()->getManager();
            $task = $repository->find($id);

            $form = $this->createForm(CategoryType::class, $task);

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
            $categoryToAdd = new Category();
            $form = $this->createForm(CategoryType::class, $categoryToAdd);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                // $form->getData() holds the submitted values
                // but, the original `$task` variable has also been updated
                $em = $this->getDoctrine()->getManager();
                $category = $form->getData();

                $categoryToAdd = new Category();
                $categoryToAdd->setName($category->getName());
                $categoryToAdd->setCreationDate($category->getCreationDate());


                // ... perform some action, such as saving the task to the database
                // for example, if Task is a Doctrine entity, save it!
                // $em = $this->getDoctrine()->getManager();
                // $em->persist($task);
                // $em->flush();
                $em = $this->getDoctrine()->getManager();
                $em->persist($categoryToAdd);
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
     * @Route("/deletecat/{id}",name="deleteCat")
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