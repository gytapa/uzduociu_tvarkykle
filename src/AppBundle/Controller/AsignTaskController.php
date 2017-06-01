<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 17.5.31
 * Time: 20.27
 */

namespace AppBundle\Controller;
use AppBundle\Entity\Category;
use AppBundle\Form\AsignType;
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
use Symfony\Component\Validator\Constraints\Length;


class AsignTaskController extends Controller
{
    /**
     * @Route("/asign", name="asign")
     */
    public function asignTask(Request $request)
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

        $user = $this->getDoctrine()->getManager();
        $products2 = $user->getRepository('AppBundle:User')->findAll();;
        $users = array();
        foreach ($products2 as $val)
        {
            $name = $val->getUsername();
            $users["$name"] = $name;
        }
        $loggedInUser = $this->getUser()->getUsername();
        $users = array_diff($users, array($loggedInUser));

        $emptyTask = new Task();
        $form = $this->createForm(AsignType::class, $emptyTask, ["username" => $users,"categories" => $categories,"create" => "create"]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $taskas = $form->getData();
            $arrayLength = count($taskas->getAuthor());
            $authorArray = array();
            $authorArray = $taskas->getAuthor();

            foreach ($authorArray as $author) {
                $taskToAdd = new Task();
                $taskToAdd->setStatus("New");
                $taskToAdd->setName($taskas->getName());
                $taskToAdd->setDescription($taskas->getDescription());
                $taskToAdd->setCategory($taskas->getCategory());
                $taskToAdd->setAuthor($author);
                $taskToAdd->setDeadlineDate($taskas->getDeadlineDate());

                $em = $this->getDoctrine()->getManager();
                $em->persist($taskToAdd);
                $em->flush();
            }
            return $this->redirectToRoute('homepage');
        }

        return $this->render('asigntasks.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}