<?php

namespace App\Form;

use App\Entity\Clasificacion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClasificacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('puntos')
            ->add('jugados')
            ->add('ganados')
            ->add('empatados')
            ->add('perdidos')
            ->add('golesFavor')
            ->add('golesContra')
            ->add('golesDiferencia')
            ->add('equipo')
            ->add('liga')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Clasificacion::class,
        ]);
    }
}
