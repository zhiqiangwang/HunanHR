<?php
namespace HR\Bundle\EducationBundle\FormType;

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
            ->add('schoolName', 'text', array('label' => '学校'))
            ->add('degree', 'choice', array(
                'label'       => '学历',
                'choices'     => array(
                    1 => '大专',
                    2 => '本科',
                    3 => '硕士',
                    4 => '博士',
                    5 => '其他'
                ),
                'data' => 2,
                'attr'        => array(
                    'css' => 'embed-element'
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
            ->add('save', 'submit', array('label' => '保存'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'HR\Bundle\EducationBundle\Entity\Education',
            'validation_groups' => array('education')
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