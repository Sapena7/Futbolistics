<?php

namespace App\Form;

use App\Entity\Partido;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartidoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('golesLocal')
            ->add('golesVisitante')
            ->add('fecha')
            ->add('equipoLocal')
            ->add('equipoVisitante')
            ->add('estadio')
            ->add('jornada')
            ->add('liga')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Partido::class,
        ]);
    }
}
