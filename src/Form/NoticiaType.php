<?php

namespace App\Form;

use App\Entity\Noticia;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class NoticiaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titular')
            ->add('cuerpo', TextareaType::class, [
                'attr' => ['class' => 'tinymce'],
            ])
            ->add('fecha')
            ->add('imagenFile', VichImageType::class, [
                'label' => false,
                'required' => false
            ])
            ->add('equipo')
            ->add('colaborador')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Noticia::class,
        ]);
    }
}
