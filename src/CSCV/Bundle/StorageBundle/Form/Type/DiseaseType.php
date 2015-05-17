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
            ->add(Disease::INDEX_KEY, 'integer')
            ->add(Disease::NAME_KEY, 'text')
            ->add(Disease::ETIOLOGY_KEY, 'textarea')
            ->add(Disease::MANIFEST_KEY, 'textarea')
            ->add(Disease::IDENTIFY_KEY, 'textarea')
            ->add(Disease::DIAGNOSE_KEY, 'textarea');
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