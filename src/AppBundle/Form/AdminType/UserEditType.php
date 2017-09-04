<?php

namespace AppBundle\Form\AdminType;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserEditType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('role', ChoiceType::class, array(
                'label' => 'Modifier le rôle :',
                'choices' => $this->getRolesForForm($options['roles']),
                'expanded' => true,
                'multiple' => true
            ))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user_edit';
    }

    public function getRolesForForm($originRoles)
    {
    $roles = array();
    $rolesAdded = array();

    // Add herited roles
    foreach ($originRoles as $roleParent => $rolesHerit) {
        $tmpRoles = array_values($rolesHerit);
        $rolesAdded = array_merge($rolesAdded, $tmpRoles);
        $roles[$roleParent] = array_combine($tmpRoles, $tmpRoles);
    }

    return $roles; 
    }
}
