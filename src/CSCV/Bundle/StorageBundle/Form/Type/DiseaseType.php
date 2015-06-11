<?php
/**
 * Created by CSCV.
 * Desc: Disease表单
 * User: Woo
 * Date: 15/5/15
 * Time: 下午9:22
 */

namespace CSCV\Bundle\StorageBundle\Form\Type;


use CSCV\Bundle\StorageBundle\Document\Disease;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DiseaseType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(Disease::NAME_KEY, 'text', array('label' => '疾病名称'))
            ->add(Disease::DESC_KEY, 'textarea', array('label' => '疾病简介', 'required' => false))
            ->add(Disease::SYMPTOM_KEY, 'textarea', array('label' => '典型症状', 'required' => false))
            ->add(Disease::ETIOLOGY_KEY, 'textarea', array('label' => '发病病因', 'required' => false))
            ->add(Disease::PREVENT_KEY, 'textarea', array('label' => '预防', 'required' => false))
            ->add(Disease::IDENTIFY_KEY, 'textarea', array('label' => '鉴别', 'required' => false))
            ->add(Disease::THERAPIES_KEY, 'textarea', array('label' => '治疗方法', 'required' => false))
            ->add(Disease::COMPLICATION_KEY, 'textarea', array('label' => '并发症', 'required' => false));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'CSCV\Bundle\StorageBundle\Document\Disease'
            )
        );
    }


    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     */
    public function getName()
    {
        return 'disease';
    }
}