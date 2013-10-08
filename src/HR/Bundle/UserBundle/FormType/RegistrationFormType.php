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
            ->add('plainPassword', 'repeated', array(
                'type'            => 'password',
                'first_options'   => array('label' => '密码'),
                'second_options'  => array('label' => '重新输入密码'),
                'invalid_message' => '两次输入密码不匹配'
            ))
            ->add('screenName', 'text', array('label' => '昵称'))
            ->add('save', 'submit', array('label' => '注册'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'HR\Bundle\UserBundle\Entity\User',
            'validation_groups' => array('registration')
        ));
    }

    public function getName()
    {
        return 'registration';
    }
}