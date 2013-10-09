<?php
namespace HR\Bundle\UserBundle\FormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * @author Wenming Tang <tang@babyfamily.com>
 */
class PhotoFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('file', 'file', array(
                'label'    => '选择一个图像',
                'required' => false,
                'attr'     => array(
                    'class' => 'embed-element'
                )
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'HR\Bundle\UserBundle\FormModel\Photo'
        ));
    }

    public function getName()
    {
        return 'photo';
    }
}