<?php
/**
 * Created by CSCV.
 * Desc:
 * User: Woo
 * Date: 15/5/14
 * Time: 上午10:47
 */

namespace CSCV\Bundle\StorageBundle\Form\Type;


use Doctrine\ODM\MongoDB\DocumentRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add(
                'author',
                'document',
                array(
                    'class' => 'CSCVStorageBundle:Author',
                    'property' => 'name',
                    'query_builder' => function (DocumentRepository $dr) {
                        return $dr->createQueryBuilder();
                    },
                    'multiple' => false,
                )
            );
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'CSCV\Bundle\StorageBundle\Document\Book'
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
        return 'book';
    }
}