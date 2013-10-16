<?php
namespace HR\UserBundle\FormType;

use HR\EducationBundle\Entity\Education;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use HR\UserBundle\Entity\User;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
//            ->add('username', 'text', array(
//                    'label'    => '用户名',
//                    'attr'     => array(
//                        'placeholder' => '字母、数字、_或减号'
//                    ))
//            )
            ->add('email', 'email', array(
                'label' => '电子邮件地址'
            ))
            ->add('screenName', 'text', array('label' => '昵称'))
            ->add('realName', 'text', array('label' => '真实姓名', 'required' => false))
            ->add('gender', 'choice', array(
                'label'       => '性别',
                'choices'     => User::getGenders(),
                'expanded'    => true,
                'required'    => false,
                'empty_value' => false,
                'attr'        => array(
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
            ->add('degree', 'choice', array(
                'label'       => '最高学历',
                'required'    => false,
                'choices'     => Education::getDegrees(),
                'empty_value' => '-',
                'attr'        => array(
                    'class' => 'embed-element'
                )
            ))
            ->add('jobTitle', 'text', array(
                'label'    => '当前职位或头衔',
                'required' => false
            ))
            ->add('companyName', 'text', array(
                'label'    => '公司或机构名称',
                'required' => false
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
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'HR\UserBundle\Entity\User',
            'validation_groups' => array('Profile')
        ));
    }

    public function getName()
    {
        return 'profile';
    }
}