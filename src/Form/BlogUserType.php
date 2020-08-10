<?php

namespace App\Form;

use App\Entity\BlogUser;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class BlogUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $role = ['Autor' => '1', 'Admin' => '2'];

        $builder
            ->add('Name', null, [
                'attr' => ['class' => 'form-control']
                ])
            ->add('Login', null, [
                'attr' => ['class' => 'form-control']
                ])
            ->add('Password', RepeatedType::class, [
                'type' => PasswordType::class,                
                'invalid_message' => 'Hesla se musí shodovat.',
                'required' => true,
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Zde napište své heslo',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Vaše heslo musí mít minimálně {{ limit }} znaků',                        
                        'max' => 255,
                    ]),
                ],
            ])
            ->add('Role',  ChoiceType::class, ['choices' => $role, 'attr' => ['class' => 'form-control']])           
            ->add('SignUp', SubmitType::class, [
                'label' => 'Odeslat',
                'attr' => ['class' => 'btn btn-success']
                ])
            
            
                        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BlogUser::class,
        ]);
    }
}
