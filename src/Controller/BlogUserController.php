<?php

namespace App\Controller;

use App\Entity\BlogUser;
use App\Form\BlogUserType;
use App\Form\Model\ChangePassword;
use App\Form\BlogUserChangePasswordType;
use App\Repository\BlogUserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;


/**
 * @Route("/user")
 */
class BlogUserController extends AbstractController
{
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(BlogUserRepository $userRepository): Response
    {
        return $this->render('BlogUser/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**     
     * @IsGranted("IS_AUTHENTICATED_ANONYMOUSLY")
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        //Nelze se registrovat, když je uživetel přihlášen
        if ($this->getUser()) {
            return $this->redirectToRoute('main');
        }

        $user = new BlogUser();
        $form = $this->createForm(BlogUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('Password')->getData()
                )
            );

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            
            // do anything else you need here, like send an email
            // in this example, we are just redirecting to the homepage
            return $this->redirectToRoute('main');
    }

    return $this->render('BlogUser/new.html.twig', [
        'form' => $form->createView(),
    ]);
}

    /**
     * @Route("/{id}", name="user_show", methods={"GET"})
     */
    public function show(BlogUser $user): Response
    {
        return $this->render('BlogUser/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, BlogUser $user): Response
    {
        $form = $this->createForm(BlogUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('BlogUser/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     */
    public function delete(Request $request, BlogUser $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     * @Route("/{id}/changePassword", name="change_password", methods={"GET","POST"})
     */
    public function changePassword(Request $request, BlogUser $user, UserPasswordEncoderInterface $encoder): Response
    {
        $u=$this->get('security.token_storage')->getToken()->getUser();
        if(strcmp('ROLE_ADMIN',$u->getRoles()[0])!=0 && $user!=$u)return $this->redirectToRoute('main');


        $changePasswordModel = new ChangePassword();
        $form = $this->createForm(BlogUserChangePasswordType::class, $changePasswordModel);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $user = $this->getUser(); 
                $password = $encoder->encodePassword(
                        $user,
                        $form->get('NewPassword')->getData()
                );

                $user->setPassword($password);
                $em->persist($user);
                $em->flush();
            } 
        }

    return $this->render('BlogUser/changePassword.html.twig', array(
                'form' => $form->createView(),
    ));
}
}
