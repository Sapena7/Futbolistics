<?php

namespace App\Form;

use App\Entity\Usuario;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', \Symfony\Component\Form\Extension\Core\Type\TextType::class)
            ->add('nombrecompleto', \Symfony\Component\Form\Extension\Core\Type\TextType::class, array(
                'attr' => ['pattern' => '[a-zA-Z]*']
            ))
            ->add('email', EmailType::class)
            ->add('fotoPerfilFile', VichImageType::class, [
                'label' => 'Foto perfil',
                'required' => false
            ])
            ->add('equipoFavorito')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Usuario::class,
        ]);
    }
}
