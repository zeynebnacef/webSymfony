<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UtilisateurRepository;
use App\Entity\Utilisateur;
use App\Form\UserUpdateFormType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SuperAdminController extends AbstractController
{
    #[Route('/admin', name: 'app_super_admin')]
    public function index(): Response
    {
        return $this->render('back/index.html.twig', [
            'controller_name' => 'SuperAdminController',
        ]);
    }
    #[Route('/profileAdmin', name: 'Admin_profile')]
    public function profile(): Response
    {
        $user = $this->getUser();
        return $this->render('back/profil.html.twig', [
            'user' => $user,
        ]);
    }
    #[Route('/deleteUser/{idu}', name: 'app_delete')]
    public function delete(int $idu, EntityManagerInterface $entityManager): Response
    {
        // Find the user by id
        $user = $entityManager->getRepository(Utilisateur::class)->find($idu);
    
        // Check if user exists
        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }
    
        // Delete the user from the database
        $entityManager->remove($user);
        $entityManager->flush();
    
        // Return a success response
        return new Response('User deleted successfully', Response::HTTP_OK);
    }

    #[Route('/userAffiche', name: 'app_affiche')]
public function userAffiche(Request $request, EntityManagerInterface $entityManager, Security $security): Response
{
    // Fetch all users from the repository
    $userRepository = $entityManager->getRepository(Utilisateur::class);

    // Get the search term from the request query parameters
    $searchTerm = $request->query->get('search');

    // Fetch users based on search term if provided, otherwise fetch all users
    if ($searchTerm) {
        $users = $userRepository->findByUsername($searchTerm);
    } else {
        $users = $userRepository->findAll();
    }

    // Get the logged-in user object
    $loggedInUser = $security->getUser();
    $username = '';

    // Check if the user is authenticated before accessing the username 
    if ($loggedInUser instanceof Utilisateur) {
        $username = $loggedInUser->getEmail();
    }

    // Render the user list template and pass the users and logged-in user to it
    return $this->render('back/userAffiche.html.twig', [
        'users' => $users,
        'loggedInUser' => $loggedInUser,
        'username' => $username,
    ]);
} 
#[Route('/updateAdmin/{id}', name: 'app_update')]
public function update(int $id, Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder): Response
{
    // Find the user by id
    $user = $entityManager->getRepository(Utilisateur::class)->find($id);

    // Check if user exists
    if (!$user) {
        throw $this->createNotFoundException('User not found');
    }

    // Keep the original image filename
    $originalImage = $user->getImg();

    // Create the form using UserUpdateFormType
    $form = $this->createForm(UserUpdateFormType::class, $user);

    // Handle form submission
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Handle file upload for photo
        $photoFile = $form->get('img')->getData();

        if ($photoFile) {
            // Generate a unique filename
            $newFilename = uniqid().'.'.$photoFile->guessExtension();

            try {
                $photoFile->move(
                    $this->getParameter('img_directory'),
                    $newFilename
                );
              
                $user->setImg($newFilename);
            } catch (FileException $e) {
            }
        } else {
         
            $user->setImg($originalImage);
        }

      
        $entityManager->flush();
        
            return new RedirectResponse($this->generateUrl('app_affiche'));
        
    }

    // Render the form for updating the user
    return $this->render('front/update.html.twig', [
        'user' => $user,
        'form' => $form->createView(),
    ]);
}  
}
