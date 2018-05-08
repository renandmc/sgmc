<?php

namespace AppBundle\Form;

use AppBundle\Entity\Usuario;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UsuarioType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipo', ChoiceType::class, array(
                'choices' => array(
                    Usuario::ADMIN => Usuario::ADMIN,
                    Usuario::PROF => Usuario::PROF,
                    Usuario::REP => Usuario::REP
                ),
                'choices_as_values' => true
            ))
            ->add('usuario', TextType::class, array('label' => 'Usuário'))
            ->add('senhaLimpa', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options' => array('label' => 'Senha'),
                'second_options' => array('label' => 'Repita a senha')
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'AppBundle\Entity\Usuario'));
    }

    public function getBlockPrefix()
    {
        return 'appbundle_usuario';
    }

}