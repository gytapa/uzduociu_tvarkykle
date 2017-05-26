<?php
/**
 * Created by PhpStorm.
 * User: david
 * Date: 17.5.25
 * Time: 16.08
 */

namespace AppBundle\Controller;
use AppBundle\Form\UserType;
use AppBundle\Entity\User;
use AppBundle\Entity\Task;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class CalendarController extends Controller
{
    /**
     * @Route("/calendar", name="calendar")
     */
    public function showCalendar(Request $request)
    {
        $repository = $this->getDoctrine()->getRepository('AppBundle:Task');
        $tasks = $repository->findByAuthor($this->getUser()->getUsername());
        $data = '[';

        foreach($tasks as $task){
            $data .= '{"start": "'.$task->getDeadlineDate()->format('Y-m-d') . '", "title": "' . $task->getName() . '" },';
        }

        $newData = rtrim($data, ",");
        $newData .= ']';
        file_put_contents('js/tasks.json', $newData);

        return $this->render(
            'calendar.html.twig'
        );
    }
}