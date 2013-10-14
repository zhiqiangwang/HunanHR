<?php
namespace HR\Bundle\UserBundle\FormType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array('label' => '用户名'))
            ->add('email', 'email', array('label' => '电子邮件地址'))
            ->add('plainPassword', 'password', array('label' => '设置密码'))
            ->add('screenName', 'text', array('label' => '昵称'))
            ->add('save', 'submit', array('label' => '注册'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'HR\Bundle\UserBundle\Entity\User',
            'validation_groups' => array('Registration')
        ));
    }

    public function getName()
    {
        return 'registration';
    }
}