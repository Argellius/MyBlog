<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ArticleRepository;
use App\Entity\Article;
use App\Form\ArticleType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(ArticleRepository $articleRepository, Request $request)
    {
        $form = $this->createFormBuilder()
        ->add('Key', TextType::class, array(
            'attr' => array(
                'class'=> 'form-control form-control-borderless',
                'placeholder' => 'Hledat...')                        
            ))
        ->add('Submit', SubmitType::class, array(
            'attr' => array('class'=> 'btn btn-info', 'style' =>'margin-left:10px;')
                ))
        ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
                return $this->render('home\index.html.twig', [
            'articles' => $articleRepository->findByContent($data['Key']),
            'form' => $form->createView(),
        ]);        
        

    }


        return $this->render('home\index.html.twig', [
            'articles' => $articleRepository->findAll(),
            'form' => $form->createView(),
        ]);        
        
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('home\contact.html.twig');        
        
    }
}
