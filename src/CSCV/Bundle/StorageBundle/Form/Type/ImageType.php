<?php

namespace CSCV\Bundle\StorageBundle\Form\Type;

use CSCV\Bundle\StorageBundle\Document\Disease;
use CSCV\Bundle\StorageBundle\Document\Image;
use CSCV\Bundle\StorageBundle\Document\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Created by CSCV.
 * Desc: 图像表单
 * User: Woo
 * Date: 15/4/21
 * Time: 上午11:25
 */
class ImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(Image::CROPPED_KEY, 'checkbox')
            ->add(
                Image::LOCATION_KEY,
                'choice',
                array(
                    'label' => '发病部位',
                    'choices' => Location::getHashArray(),
                    'multiple' => false,
                )
            );

    }


    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'CSCV\Bundle\StorageBundle\Document\Image'
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
        return 'image';
    }

}