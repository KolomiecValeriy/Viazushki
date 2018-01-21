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
            ->add('imageFile', FileType::class,
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
