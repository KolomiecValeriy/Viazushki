<?php

namespace ViazushkiBundle\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

class ImageAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('imageFile', 'file',
                [
                    'required' => false,
                ]
            );
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('imageName')
            ->add('toy')
        ;
    }

}