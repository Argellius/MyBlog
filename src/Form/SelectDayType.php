<?php

namespace App\Form;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class SelectDayType extends AbstractType
{
    private $ArticleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->ArticleRepository = $articleRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'PublishAt',
            EntityType::class,
            [
                'class' => Article::class,
                'query_builder' => function(ArticleRepository $ar){
                    return $ar->createQueryBuilder('u')
                    ->groupBy('u.PublishAt');
                },
                'choice_label' => function (Article $a) {
                    return $a->getPublishAt()->format('d-m-Y');
                },
                'placeholder' => 'Všechny články',
                'mapped' => false,
                'expanded' => false,
                'multiple' => false,
            ]
        );
        $builder->setMethod('POST');

        return $builder;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}







