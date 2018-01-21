<?php

namespace ViazushkiBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class FileAdmin extends AbstractAdmin
{
    public function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('files', FileType::class, [
                'multiple' => true,
            ])
        ;
    }

    public function configureListFields(ListMapper $list)
    {
        $list->addIdentifier('fileName');
    }
}