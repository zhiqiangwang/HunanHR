<?php
namespace HR\Bundle\UserBundle\FormType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email', array('label' => '电子邮件地址'))
            ->add('screenName', 'text', array('label' => '昵称'))
            ->add('realName', 'text', array('label' => '真实姓名', 'required' => false))
            ->add('gender', 'choice', array(
                'label'    => '性别',
                'choices'  => array(
                    'm' => '男',
                    'f' => '女'
                ),
                'expanded' => true,
                'required' => false,
                'empty_value' =>  false,
                'attr'     => array(
                    'class' => 'embed'
                )
            ))
            ->add('birthday', 'birthday', array(
                'label'    => '生日',
                'format'   => 'yyyy-MM-dd',
                'widget'   => 'single_text',
                'required' => false,
                'attr'     => array(
                    'class'       => 'embed',
                    'placeholder' => '格式: 2013-06-02'
                )
            ))
            ->add('phoneNumber', 'text', array(
                'label'    => '手机号码',
                'required' => false
            ))
            ->add('homepage', 'url', array(
                'label'    => '个人主页',
                'required' => false
            ))
            ->add('bio', 'textarea', array(
                'label'    => '个人介绍',
                'required' => false,
                'attr'     => array(
                    'rows'  => 8,
                    'cols'  => 55,
                    'class' => 'form-control'
                )
            ));
//            ->add('skill', 'textarea', array(
//                'label'    => '职业技能',
//                'required' => false,
//                'attr'     => array(
//                    'rows'  => 15,
//                    'cols'  => 55,
//                    'class' => 'form-control'
//                )
//            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'HR\Bundle\UserBundle\Entity\User',
            'validation_groups' => array('profile')
        ));
    }

    public function getName()
    {
        return 'profile';
    }
}