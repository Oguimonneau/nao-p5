<?php
namespace AppBundle\Form;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class ObservationFilterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('bird', EntityType::class, [
                'class'         => 'AppBundle:Taxref',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('b')
                        ->groupBy('b.famille')
                        ->orderBy('b.famille', 'ASC');
                },
                'choice_label'  => 'famille',
                'label'         => 'Filter by family'
            ])
            ->add('recover', SubmitType::class, [
                'attr'          => [
                    'class'         => 'btn right'
                ]
            ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
    }
    public function getBlockPrefix()
    {
        return 'piupiu_bundle_obs_filter_form_type';
    }
}