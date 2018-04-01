<?php

namespace ViazushkiBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\FormatterBundle\Form\Type\FormatterType;

class ToyAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->with('Default', ['class' => 'col-md-8'])
                ->add('name', 'text')
                ->add('Description', FormatterType::class, [
                    'event_dispatcher'     => $formMapper->getFormBuilder()->getEventDispatcher(),
                    'source_field'         => 'description',
                    'source_field_options' => ['attr' => ['rows' => 20]],
                    'format_field'         => 'contentFormatter',
                    'target_field'         => 'description',
                ])
                ->add('author', 'text')
                ->add('mainImage', 'sonata_type_model', [
                    'class' => 'ViazushkiBundle\Entity\Image',
                    'required' => false,
                    'expanded' => true,
                ])
                ->add('images', 'sonata_type_model',
                    [
                        'required' => false,
                        'multiple' => true,
                        'expanded' => true,
                    ]
                )
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
            ->addIdentifier('mainImage', 'string', [
                'template' => '@Viazushki/Admin/image_list_field.html.twig',
            ])
            ->add('author')
            ->add('tags')
            ->add('category')
            ->add('_action', 'actions', [
                'actions' => [
                    'delete' => [],
                ]
            ])
        ;
    }
}
