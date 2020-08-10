<?php

namespace App\Form;

use App\Entity\Article;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;


class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Title')
            ->add('Description', TextareaType::class, array(
                'attr' => array('class' => 'TextAreaStyle')
                ))
            ->add('Content', TextareaType::class, array(
                'attr' => array('class' => 'TextAreaStyle')
                ))
            ->add('UpdatedAt', null, array(
                'data' => new \DateTime(),
                'attr' => array('class' => 'hide_updatedAt')
                 ))

                
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
