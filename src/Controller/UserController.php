<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\User;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use App\Entity\Role;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Form\UserFormType;

class UserController extends Controller
{
    /**
     * 
     *@Route("/register", name="register")
     * 
     */
    public function register(Request $request, EncoderFactoryInterface $encoderFactory, TokenStorageInterface $tokenStorage, \Swift_Mailer $mailer)
    {
        $user = new User();
        $form = $this->createForm(UserFormType::class, $user, ['standalone' => true]);
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            
            $encoder = $encoderFactory->getEncoder(User::class);
            
            $user->setSalt(md5($user->getUsername()));
            $password = $encoder->encodePassword(
                $user->getPassword(),
                $user->getSalt()
                );
            $user->setPassword($password);
            $user->setVerified(false);
            
            $user->addRole(
                $this->getDoctrine()->getRepository(Role::class)->findOneByLabel('ROLE_USER')
                );
            $manager = $this->getDoctrine()->getManager();
            $manager->persist($user);
            $manager->flush();
            $verificationUrl = 'http://localhost/verification/user=' . $user->getId();
            $message = (new \Swift_Message('Hello Email'))
                ->setFrom('gameshot.fun@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    '<html>' .
                    '<head></head>' .
                    '<body>' .
                    '<p>To verify your email address, click on the link below:</p>' .
                    '<a href="'. $verificationUrl .'">Verify email</a>'.
                    '</body>' .
                    '</html>',
                    'text/html');
            
            $tokenStorage->setToken( new UsernamePasswordToken($user, null, 'main', $user->getRoles()));
            $mailer->send($message);
            return $this->redirectToRoute('homepage');
        }
        return $this->render('User/Register.html.twig', ['formObj' => $form->createView()]);
    }
    
    /**
     * @Route("/login", name="login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('User/Login.html.twig',
            [
                'last_username' => $lastUsername,
                'error' => $error
            ]  
           );
    }
}

