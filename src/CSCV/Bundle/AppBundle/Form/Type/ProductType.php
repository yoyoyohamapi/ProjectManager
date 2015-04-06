<?php
namespace CSCV\Bundle\AppBundle\Form\Type;

use Acme\StoreBundle\Document\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Created by CSCV.
 * User: Woo
 * Date: 15/4/5
 * Time: 下午6:53
 */
class ProductType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(Product::NAME_KEY, 'text')
            ->add(Product::PRICE_KEY, 'text');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'Acme\StoreBundle\Document\Product'
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
        return 'product';
    }
}