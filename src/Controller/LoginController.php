<?php

namespace App\Controller;

use App\Form\LoginFormType;
use App\Form\NewmdpFormType;
use App\Repository\UtilisateurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use App\Form\SendEmailType;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Entity\Utilisateur;


class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(Request $request, AuthenticationUtils $authenticationUtils, UserPasswordEncoderInterface $passwordEncoder, UtilisateurRepository $userRepo, EventDispatcherInterface $eventDispatcher): Response
    {
        // Get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // Last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        // Create the login form
        $form = $this->createForm(LoginFormType::class);

        // Handle form submission
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            // Retrieve the submitted email and password
            $email = $form->get('email')->getData();
            $password = $form->get('password')->getData();

            // Find the user by email
            $user = $userRepo->findOneBy(['email' => $email]);

            // If user exists and password is valid
            if ($user && $passwordEncoder->isPasswordValid($user, $password)) {
                // Manually authenticate user
                $token = new UsernamePasswordToken($user, null, 'main', $user->getRoles());
                $this->get('security.token_storage')->setToken($token);

                // Trigger the login event
                $event = new InteractiveLoginEvent($request, $token);
                $eventDispatcher->dispatch($event);

                // Redirect based on user role
                if (in_array('Super Admin', $user->getRoles(), true)) {
                    return new RedirectResponse($this->generateUrl('app_super_admin'));
                } else {
                    return new RedirectResponse($this->generateUrl('app_home'));
                }
            } else {
                // Authentication failed, show error message
                $error = "Invalid email or password.";
            }
        }

        // Render the login form template with error if any
        return $this->render('login.html.twig', [
            'form' => $form->createView(),
            'error' => $error,
        ]);
    }
    #[Route('/forgetpassword', name: 'app_forget_password')]
    public function forgetPassword(Request $request, MailerInterface $mailer)
{
    $form = $this->createForm(SendEmailType::class);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $formData = $form->getData();

        // Vérifier si l'utilisateur existe avec l'email fourni
        $userRepository = $this->getDoctrine()->getRepository(Utilisateur::class);
        $user = $userRepository->findOneBy(['email' => $formData['email']]);

        if (!$user) {
            // Si l'utilisateur n'existe pas, affichez un message d'erreur
            $this->addFlash('error', 'Email not found.');
            return $this->redirectToRoute('app_forget_password');
        }

        // L'utilisateur existe, envoyez le lien de réinitialisation
        $transport = Transport::fromDsn('smtp://bennacefzeyneb@gmail.com:vgkvjsuzictmdcpg@smtp.gmail.com:587');
        $mailer = new Mailer($transport); 
        
        $url = $this->generateUrl('newpassword', ['email' => $formData['email']], UrlGeneratorInterface::ABSOLUTE_URL);

        $email = (new Email())
            ->from('bennacefzeyneb@gmail.com')
            ->to($formData['email']) 
            ->subject('Reset Password Request')
            ->html('<p>Please <a href="' . $url . '">click here</a> to reset your password.</p>');

        $mailer->send($email);

        $this->addFlash('success', 'Email sent successfully.');
        return $this->redirectToRoute('app_forget_password');
       
    }

    return $this->render('front/forgetpassword.html.twig', [
        'form' => $form->createView(),
    ]);
}

#[Route('/newpassword', name: 'newpassword')]
public function changePassword(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
{
    // Get email from the query parameters
    $email = $request->query->get('email');

    // Create form instance and pass the email to the form
    $form = $this->createForm(NewmdpFormType::class, null, ['email' => $email]);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        // Get form data
        $formData = $form->getData();

        // Check if the new password and confirm password match
        if ($formData['newPassword'] !== $formData['confirmPassword']) {
            // Redirect or render an error message indicating that passwords do not match
            $this->addFlash('error', 'The new password and confirm password do not match.');
            return $this->redirectToRoute('newpassword', ['email' => $email]);
        }

        // Fetch the user based on the provided email
        $userRepository = $this->getDoctrine()->getRepository(Utilisateur::class);
        $user = $userRepository->findOneBy(['email' => $email]);

        if (!$user) {
            // Handle case when user is not found
            // Redirect or render an error message
            return $this->redirectToRoute('app_login'); // Redirect to login instead of error route
        }

        // Handle form submission, update password
        $newPassword = $formData['newPassword'];

        // Encode the new password before setting it
        $encodedPassword = $passwordEncoder->encodePassword($user, $newPassword);
        $user->setPassword($encodedPassword);

        // Persist changes to the database
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        // Redirect to login interface after password change
        return $this->redirectToRoute('app_login');
    }

    // Render form template
    return $this->render('front/newpassword.html.twig', [
        'form' => $form->createView(),
    ]);
}



}
