<?php
namespace HR\SkillBundle\FormType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class SkillFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text', array('label' => '技能'))
            ->add('summary', 'textarea', array(
                'label'    => '描述',
                'required' => false,
                'attr'     => array(
                    'rows' => 8,
                    'cols' => 60
                )
            ))
            ->add('save', 'submit', array('label' => '保存'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HR\SkillBundle\Entity\Skill'
        ));
    }

    public function getName()
    {
        return 'skill';
    }
}