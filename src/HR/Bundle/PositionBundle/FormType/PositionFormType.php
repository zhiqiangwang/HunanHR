<?php
namespace HR\Bundle\PositionBundle\FormType;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class PositionFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('label' => '职位或头衔'))
            ->add('companyName', 'text', array('label' => '公司或机构'))
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
                'label'    => '职位描述(可选)',
                'required' => false,
                'attr'     => array(
                    'rows' => 8,
                    'cols' => 60,
                    'placeholder' => '可描述在此职位中担任的详细职责'
                )
            ))
            ->add('save', 'submit', array('label' => '保存'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'        => 'HR\Bundle\PositionBundle\Entity\Position'
        ));
    }

    public function getName()
    {
        return 'position';
    }

    private static function buildYearChoices()
    {
        $year = array_reverse(range(date('Y') - 20, date('Y')));

        return array_combine($year, $year);
    }
}