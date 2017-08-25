<?php
/**
 * Created by PhpStorm.
 * User: jolszanski
 * Date: 25.08.17
 * Time: 14:41
 */

namespace AppBundle\Form;


use AppBundle\Entity\Volume;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;



class VolumeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
           ->add('volumeNumber')
           ->add('release_date',DateType::class)
           ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Volume::class,
        ]);
    }

}