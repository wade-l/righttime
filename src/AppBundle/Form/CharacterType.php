<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Entity\Character;
use AppBundle\Entity\Game;

class CharacterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $choices = $options['choices'];

        $entity = $builder->getData();

        $player = $entity->getPlayer();

        $builder->add('name');
        if ( $player != null) {
            $builder->add('player', null, array(
                'disabled' => 'true',
            ));
        } else {
            $builder->add('player');
        }

        if ( $options['games'] != null ) {
            $builder->add('game', EntityType::class, array(
                'class' => Game::class,
                'choices' => $options['games'],
            ));
        } else {
            $builder->add('game');
        }

 //           ->add('player', null, array( 'disabled' => 'true'))
 //           ->add('game',ChoiceType::class, array(
 //               'choices' => $choices,
//            ))
//            ->add('game', EntityType::class, array(
 //               'class' => Game::class
 //           ));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Character',
            'player' => null,
            'games' => null,
            'choices' => array(
                'yes' => 'yes',
                'maybe' => 'maybe',
            )
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_character';
    }


}
