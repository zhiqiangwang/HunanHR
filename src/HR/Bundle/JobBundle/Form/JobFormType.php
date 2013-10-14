<?php

namespace HR\Bundle\JobBundle\Form;

use HR\Bundle\JobBundle\Entity\Job;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class JobFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, array(
                'label' => '招聘职位'
            ))
            ->add('description', null, array(
                'label'    => '职位详情',
                'attr'     => array(
                    'rows' => 18,
                    'cols' => 60
                )
            ))
            ->add('type', 'choice', array(
                'label'   => '工作性质',
                'choices' => Job::getTypes(),
                'attr'    => array(
                    'class' => 'embed-element'
                )
            ))
            ->add('city', null, array(
                'label' => '工作地点',
                'attr'  => array(
                    'class' => 'embed-element'
                )
            ))
            ->add('location', null, array(
                'label'    => '详细地址'
            ))
            ->add('companyName', null, array(
                'label' => '公司或机构'
            ))
            ->add('companyDescription', null, array(
                'label'    => '公司或机构介绍',
                'required' => false,
                'attr'     => array(
                    'rows' => 8,
                    'cols' => 60
                )
            ))
            ->add('contactEmail', null, array(
                'label' => '简历接收Email'
            ))
            ->add('save', 'submit', array(
                'label' => '保存'
            ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HR\Bundle\JobBundle\Entity\Job'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'job';
    }
}
