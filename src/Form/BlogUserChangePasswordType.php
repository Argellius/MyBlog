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


class BlogUserChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('OldPassword', PasswordType::class, array(
                'label' => 'OldPassword'
            ))
            ->add('NewPassword', RepeatedType::class, [
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
            ->add('SignUp', SubmitType::class, [
                'label' => 'Změnit',
                'attr' => ['class' => 'btn btn-success']
                ])
            
            
                        ;
    }


    public function setDefaultOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'App\Form\Model\ChangePassword',
        ));
    }
    
    public function getName()
    {
        return 'change_passwd';
    }
}
