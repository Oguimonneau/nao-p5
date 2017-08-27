<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ObservationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('taxref',     EntityType::class, array(
                'class'         => 'AppBundle\Entity\Taxref',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('a')->orderBy('a.nomVern','ASC');
                },
                'choice_label'  => 'nom_vern',
                'multiple'      =>  false,
            ))
            ->add('date', DateTimeType::class, array(
                'widget'    => 'single_text',
                'html5'      => false,
                'format'=>'dd-MM-yyyy',
                'attr'      => ['class' => 'js-datepicker']
            ))
            ->add('latitude',   HiddenType::class)
            ->add('longitude',  HiddenType::class)
            ->add('commune',    HiddenType::class)
            ->add('note',       TextareaType::class, array(
                'attr'   => ['rows'  =>  '6']
            ))
            ->add('photo',      PhotoType::class)

            ->add('Poster',     submitType::class);
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Observation'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_observation';
    }

}
