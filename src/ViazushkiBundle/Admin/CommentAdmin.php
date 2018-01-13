<?php

namespace ViazushkiBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CommentAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $form)
    {
        $form->add('message', TextareaType::class);
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('user')
            ->add('toy')
        ;
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('message')
            ->add('toy')
            ->add('user')
        ;
    }
}
