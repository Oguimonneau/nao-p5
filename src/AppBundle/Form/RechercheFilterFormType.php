<?php
namespace AppBundle\Form;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RechercheFilterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('Taxref', EntityType::class, [
                'class'         => 'AppBundle:Taxref',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('b')

                        ->orderBy('b.nomVern', 'ASC');
                },
                'choice_label'  => 'nomVern',
                'label'         => 'Filter par Espece'
            ])
            ->add('Chercher', SubmitType::class, [
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
        return 'App_bundle_obs_filter_form_type';
    }
}