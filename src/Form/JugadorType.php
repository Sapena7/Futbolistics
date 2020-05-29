<?php

namespace App\Form;

use App\Entity\Jugador;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class JugadorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre',TextType::class, array(
                'attr' => ['pattern' => '[a-zA-Z]*']
            ))
            ->add('goles')
            ->add('amarillas')
            ->add('rojas')
            ->add('dorsal')
            ->add('equipo')
            ->add('liga')
            ->add('posicion')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Jugador::class,
        ]);
    }
}
