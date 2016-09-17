<?php

/**
 * Created by PhpStorm.
 * User: root
 * Date: 15/09/16
 * Time: 14:13
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlaceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, [
            'description' => "Nom du lieu"
        ]);
        $builder->add('address', TextType::class, [
            'description' => "Adresse complète du lieu"
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Place',
            'csrf_protection' => false
        ]);
    }
}