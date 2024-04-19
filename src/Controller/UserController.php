<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Utilisateur;
use App\Form\UserUpdateFormType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;


class UserController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function home(): Response
    {
        return $this->render('front/home.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    
    #[Route('/profile', name: 'app_profile')]
    public function profile(): Response
    {
        $user = $this->getUser();
        return $this->render('front/profile.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/updateUser/{id}', name: 'app_crud_update')]
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
                // Store the new photo filename in the user entity
                $user->setImg($newFilename);
            } catch (FileException $e) {
                // Handle file upload error
                // You can log or display an error message here
            }
        } else {
            // If no new image is selected, keep the original image filename
            $user->setImg($originalImage);
        }

        // Save the updated user to the database
        $entityManager->flush();

        // Redirect based on user role
        if (in_array('Super Admin', $user->getRoles(), true)) {
            return new RedirectResponse($this->generateUrl('Admin_profile'));
        } else {
            return new RedirectResponse($this->generateUrl('app_profile'));
        }
    }

    // Render the form for updating the user
    return $this->render('front/update.html.twig', [
        'user' => $user,
        'form' => $form->createView(),
    ]);
}
}
