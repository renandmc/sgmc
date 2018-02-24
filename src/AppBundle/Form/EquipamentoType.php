<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipamentoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numero', 'Symfony\Component\Form\Extension\Core\Type\IntegerType')
            ->add('tipoEquipamento', 'Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('marca', 'Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('modelo', 'Symfony\Component\Form\Extension\Core\Type\TextType')
            ->add('descricao', 'Symfony\Component\Form\Extension\Core\Type\TextareaType');
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array('data_class' => 'AppBundle\Entity\Equipamento'));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_equipamento';
    }

}