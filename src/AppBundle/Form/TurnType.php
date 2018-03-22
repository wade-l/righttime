<?php

namespace AppBundle\Form;

use App\Entity\Turn;
use App\Entity\Act;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TurnType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('comments')->add('character')->add('downtimePeriod')
            ->add('acts', CollectionType::class, array(
                'entry_type' => ActType::class,
                'entry_options' => array('label' => false),
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Turn'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_turn';
    }


}
