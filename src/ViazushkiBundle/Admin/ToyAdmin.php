<?php

namespace ViazushkiBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ToyAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Default', ['class' => 'col-md-8'])
                ->add('name', 'text')
                ->add('description', 'textarea')
                ->add('author', 'text')
                ->add('mainImage', 'sonata_type_model', [
                    'class' => 'ViazushkiBundle\Entity\Image',
                    'required' => false,
                    'expanded' => true,
                ])
            ->end()
            ->with('Settings', ['class' => 'col-md-4'])
                ->add('category', 'sonata_type_model',
                    [
                        'class' => 'ViazushkiBundle\Entity\Category',
                        'required' => false,
                    ]
                )
                ->add('tags', 'sonata_type_model',
                    [
                        'required' => false,
                        'multiple' => true,
                        'expanded' => true,
                    ]
                )
            ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('name')
            ->add('author');
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('name')
            ->add('author')
            ->add('tags')
            ->add('category')
            ->add('mainImage')
        ;
    }
}
