<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\ArticleRepository;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Form\SelectDayType;
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
        $formSearch = $this->createFormBuilder()
            ->add('Key', TextType::class, array(
                'attr' => array(
                    'class'=> 'form-control form-control-borderless',
                    'placeholder' => 'Hledat...')                        
                ))
            ->add('Submit', SubmitType::class, array(
                'attr' => array('class'=> 'btn btn-info', 'style' =>'margin-left:10px;'),
                'label' => 'Najdi', 
                    ))
            ->getForm();
        $formSearch->handleRequest($request);

        $formSelectDay = $this->createForm(SelectDayType::class);
        $formSelectDay->handleRequest($request);


        if ($formSearch->isSubmitted() && $formSearch->isValid()) {
            $data = $formSearch->getData();
                return $this->render('home\index.html.twig', [
            'articles' => $articleRepository->findByContent($data['Key']),
            'formSearch' => $formSearch->createView(),
            'formSelectDay' => $formSelectDay->createView(),
        ]);        
        }
        
        if ($formSelectDay->isSubmitted() && $formSelectDay->isValid()) {            
            
            $data=null;
            if ( $formSelectDay->get('PublishAt')->getData() != null )
            {
                $data = $formSelectDay->get('PublishAt')->getData()->getPublishAt();

            }                

            return $this->render('home\index.html.twig', [
                'articles' => $data == null ? $articleRepository->findAll() :
                 $articleRepository->findBy(
                    ['PublishAt' => $data],
                ),
                'formSearch' => $formSearch->createView(),
                'formSelectDay' => $formSelectDay->createView(),
        ]);        
        }     

        return $this->render('home\index.html.twig', [
            'articles' => $articleRepository->findAll(),
            'formSearch' => $formSearch->createView(),
            'formSelectDay' => $formSelectDay->createView(),
        ]);        
        
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('home\contact.html.twig');        
        
    }

   /**
     * @Route("/downloadCV", name="downloadCV")
     */
    public function downloadCurriculumVitae()
    {
        $pdfPath = $this->getParameter('dirDownload').'\cv_blog.pdf';

        return $this->file($pdfPath); 
        
    }

}
