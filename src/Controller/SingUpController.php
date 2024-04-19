<?php

namespace App\Controller;
use App\Entity\Role;
use App\Entity\Utilisateur;
use App\Form\UserSignUpFormType;
use App\Repository\UtilisateurRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Doctrine\ORM\EntityManagerInterface;




class SingUpController extends AbstractController
{
    #[Route('/signUp', name: 'app_sign')]
    public function ajoutUser(Request $request, ManagerRegistry $doctrine, UserPasswordEncoderInterface $passwordEncoder): Response
{
    $user = new Utilisateur();
    $form = $this->createForm(UserSignUpFormType::class, $user);

    $form->handleRequest($request);
    
    if ($form->isSubmitted() && $form->isValid()) {
        
        // Handle image upload
        $imageFile = $form->get('imageFile')->getData();
        if ($imageFile) {
            $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

            try {
                $imageFile->move(
                    $this->getParameter('img_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                // Handle file upload error, e.g., log the error or show a user-friendly message
                // return appropriate response
            }

            $user->setImg($newFilename);
        }

        // Encode the password
        $user->setPassword(
            $passwordEncoder->encodePassword(
                $user,
                $user->getPassword()
            )
        );

        // Save user to the database
        $entityManager = $doctrine->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        // Redirect to login page
        return $this->redirectToRoute('app_login');
    }

    return $this->render('sign_up.html.twig', [
        'form' => $form->createView(),
    ]);
}



    }


   


