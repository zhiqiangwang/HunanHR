<?php
namespace HR\EducationBundle\FormType;

use HR\EducationBundle\Entity\Education;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class EducationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('schoolName', 'text', array('label' => '学校名称'))
            ->add('degree', 'choice', array(
                'label'       => '学历',
                'choices'     => Education::getDegrees(),
                'empty_value' => '选择学历',
                'attr'        => array(
                    'class' => 'embed-element'
                )
            ))
            ->add('startDate', 'choice', array(
                'label'       => '开始时间',
                'choices'     => static::buildYearChoices(),
                'empty_value' => '-'
            ))
            ->add('endDate', 'choice', array(
                'label'       => '结束时间',
                'choices'     => static::buildYearChoices(),
                'empty_value' => '-'
            ))
            ->add('summary', 'textarea', array(
                'label'    => '描述',
                'required' => false,
                'attr'     => array(
                    'rows' => 8,
                    'cols' => 60,
                    'placeholder' => '参加过的活动或获得过的荣誉等'
                )
            ))
            ->add('save', 'submit', array('label' => '保存'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'HR\EducationBundle\Entity\Education'
        ));
    }

    public function getName()
    {
        return 'education';
    }

    private static function buildYearChoices()
    {
        $year = array_reverse(range(date('Y') - 20, date('Y')));

        return array_combine($year, $year);
    }
}