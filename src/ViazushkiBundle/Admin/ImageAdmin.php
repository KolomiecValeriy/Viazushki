<?php

namespace ViazushkiBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class ImageAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('files', FileType::class,
                [
                    'required' => true,
                    'multiple' => true,
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
        ;
    }
}
