<?php
namespace HR\Bundle\UserBundle\FormType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Security\Core\Validator\Constraints\UserPassword;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('currentPassword', 'password', array(
                'label'       => '当前密码',
                'mapped'      => false,
                'constraints' => new UserPassword(array('message' => '当前密码不正确')),
            ))
            ->add('plainPassword', 'repeated', array(
                'type'            => 'password',
                'first_options'   => array('label' => '新密码'),
                'second_options'  => array('label' => '重新输入密码'),
                'invalid_message' => '两次输入密码不匹配'
            ))
            ->add('save', 'submit', array('label' => '提交'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'HR\Bundle\UserBundle\Entity\User',
            'validation_groups' => array('Default', 'ChangePassword')
        ));
    }

    public function getName()
    {
        return 'change_password';
    }
}