<?php

namespace App\Controller;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;

class ToDoListController extends AbstractController
{

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
        $this->entityManager = $this->doctrine->getManager();
    }

    #[Route('/', name: 'to_do_list')]
    public function index(): Response
    {
        $tasks = $this->doctrine->getRepository(Task::class)->findBy([], ['id'=>'DESC']);

        return $this->render('to_do_list/index.html.twig', [
            'controller_name' => 'ToDoListController',
            'tasks' => $tasks
        ]);
    }

    #[Route('/create', name: 'create_task', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $title = trim($request->request->get('title'));
        if(empty($title)){
            return $this->redirectToRoute('to_do_list');
        }

        $task = new Task();
        $task->setTitle($title);

        $this->entityManager->persist($task);
        $this->entityManager->flush();

        return $this->redirectToRoute('to_do_list');
    }

    #[Route('/switch-status/{id}', name: 'switch_status')]
    public function siwtchStatus($id): Response
    {

        $task = $this->entityManager->getRepository(Task::class)->find($id);

        $task->setStatus(! $task->isStatus());
        $this->entityManager->flush();

        return $this->redirectToRoute('to_do_list');

    }

    #[Route('/delete/{id}', name: 'task_delete')]
    public function delete($id): Response
    {
        $task = $this->entityManager->getRepository(Task::class)->find($id);
        $this->entityManager->remove($task);
        $this->entityManager->flush();

        return $this->redirectToRoute('to_do_list');

    }

}
