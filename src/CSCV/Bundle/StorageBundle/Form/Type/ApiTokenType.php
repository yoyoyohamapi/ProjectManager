<?php
/**
 * Created by CSCV.
 * Desc:
 * User: Woo
 * Date: 15/6/3
 * Time: 下午9:31
 */

namespace CSCV\Bundle\StorageBundle\Form\Type;

use CSCV\Bundle\StorageBundle\Document\ApiToken;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ApiTokenType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(ApiToken::APP_NAME_KEY, 'text')
            ->add(ApiToken::LIMIT_KEY, 'date');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'CSCV\Bundle\StorageBundle\Document\ApiToken'
            )
        );
    }


    /**
     * Returns the name of this type.
     *
     */
    public function getName()
    {
        return 'api_token';
    }
}