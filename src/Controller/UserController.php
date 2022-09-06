<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;

#[Route('/api', name: 'api_index')]

class UserController extends AbstractController
{
    
    //Get all users
    #[Route('/user', name: 'user_index', methods: ['GET'])]
    public function index(ManagerRegistry $doctrine): Response{

        $users = $doctrine
            ->getRepository(User::class)
            ->findAll();
  
        $data = [];
  
        foreach ($users as $user) {
           $data[] = [
               'id' => $user->getId(),
               'name' => $user->getName(),
               'email' => $user->getEmail(),
               'password' => $user->getPassword(),
           ];
        }
  
        return $this->json($data);
    }
 
    //Get user by id
    #[Route('/user/{id}', name: 'user_show', methods: ['GET'])]
    public function show(ManagerRegistry $doctrine, int $id): Response{

        $user = $doctrine->getRepository(User::class)->find($id);
  
        if (!$user) {
            return $this->json('No user found for id ' . $id, 404);
        }
  
        $data =  [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
        ];
          
        return $this->json($data);
    }
  
    //Create new user
    #[Route('/user', name: 'user_new', methods: ['POST'])]
    public function new(ManagerRegistry $doctrine, Request $request): Response{

        $entityManager = $doctrine->getManager();
  
        $user = new User();
        $user->setName($request->request->get('name'));
        $user->setEmail($request->request->get('email'));
        $user->setPassword($request->request->get('password'));
  
        $entityManager->persist($user);
        $entityManager->flush();
  
        return $this->json('Created new user successfully with id ' . $user->getId());
    }
    
    //Update user
    #[Route('/user/{id}', name: 'user_edit', methods: ['PUT'])]
    public function edit(ManagerRegistry $doctrine, Request $request, int $id): Response{

        $entityManager = $doctrine->getManager();

        $user = $entityManager->getRepository(User::class)->find($id);
  
        if (!$user) {
            return $this->json('No user found for id' . $id, 404);
        }
  
        $user->setName($request->request->get('name'));
        $user->setEmail($request->request->get('email'));
        $user->setPassword($request->request->get('password'));
        $entityManager->flush();
  
        $data =  [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'password' => $user->getPassword(),
        ];
          
        return $this->json($data);
    }
  
    //Delete user
    #[Route('/user/{id}', name: 'user_delete', methods: ['DELETE'])]
    public function delete(ManagerRegistry $doctrine, int $id): Response{

        $entityManager = $doctrine->getManager();

        $user = $entityManager->getRepository(User::class)->find($id);
  
        if (!$user) {
            return $this->json('No user found for id' . $id, 404);
        }
  
        $entityManager->remove($user);
        $entityManager->flush();
  
        return $this->json('Deleted a user successfully with id ' . $id);
    }
}