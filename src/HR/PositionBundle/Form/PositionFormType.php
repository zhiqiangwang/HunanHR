<?php

namespace HR\PositionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PositionFormType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('position', null, array(
                'label' => '招聘职位'
            ))
            ->add('location', null, array(
                'label'    => '详细工作地点'
            ))
            ->add('companyName', null, array(
                'label' => '公司或机构'
            ))
            ->add('contactEmail', null, array(
                'label' => '简历接收Email'
            ))
            ->add('description', null, array(
                'label' => '职位详情',
                'attr'  => array(
                    'rows'        => 25,
                    'cols'        => 60,
                    'placeholder' => '描述岗位职责或要求，尽量说明福利待遇。'
                )
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
            'data_class' => 'HR\PositionBundle\Entity\Position'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'position';
    }
}
