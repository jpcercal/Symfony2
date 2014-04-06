<?php

namespace Cekurte\Pages\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Page type.
 *
 * @author João Paulo Cercal <sistemas@cekurte.com>
 * @version 0.1
 */
class PageFormType extends AbstractType
{
    /**
     * {@inheritdoc}
     *
     * @author João Paulo Cercal <sistemas@cekurte.com>
     * @version 0.1
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['search'] === true) {

            $builder->add('title')->setRequired(false);
            $builder->add('abstract')->setRequired(false);
            $builder->add('description')->setRequired(false);
            $builder->add('active', null, array(
                'label' => 'Inativo'
            ))->setRequired(false);

        } else {

            $builder
                ->add('image', 'hidden', array(
                    'attr'  => array(
                        'class' => 'page' // Mesmo nome do endpoint
                    )
                ))
                ->add('title')
                ->add('abstract')
                ->add('description', 'textarea', array(
                    'attr'  => array(
                        'class' => 'ckeditor'
                    )
                ))
                ->add('date')
                ->add('active', null, array(
                    'required' => false
                ))
            ;

        }
    }

    /**
     * {@inheritdoc}
     *
     * @author João Paulo Cercal <sistemas@cekurte.com>
     * @version 0.1
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'search'     => false,
            'data_class' => 'Cekurte\Pages\CoreBundle\Entity\Page'
        ));
    }

    /**
     * {@inheritdoc}
     *
     * @author João Paulo Cercal <sistemas@cekurte.com>
     * @version 0.1
     */
    public function getName()
    {
        return 'cekurte_pages_corebundle_pageform';
    }
}
