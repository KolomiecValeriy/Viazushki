<?php

namespace ViazushkiBundle\Admin;


use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Vich\UploaderBundle\Form\Type\VichFileType;

class ImageAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('imageFile', VichFileType::class,
                [
                    'required' => true,
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

    public function prePersist($image)
    {
        if ($image) {
            $name = $image->getImageFile()->getClientOriginalName();
            $image->setImagePath('assets/images/'.$name);
            $image->setImageName($name);
        }
    }
}
