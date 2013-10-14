<?php
namespace HR\Bundle\UserBundle\FormType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class ResettingFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('plainPassword', 'repeated', array(
                'type'            => 'password',
                'first_options'   => array('label' => '新密码'),
                'second_options'  => array('label' => '重新输入新密码'),
                'invalid_message' => '两次输入密码不一致',
            ))
            ->add('reset', 'submit', array('label' => '重置密码'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'HR\Bundle\UserBundle\Entity\User',
            'validation_groups' => array('Resetting')
        ));
    }

    public function getName()
    {
        return 'resetting';
    }
}