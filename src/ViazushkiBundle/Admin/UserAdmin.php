<?php

namespace ViazushkiBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\DependencyInjection\ContainerInterface;
use ViazushkiBundle\Entity\User;

class UserAdmin extends AbstractAdmin
{
    protected $container;

    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('username', 'text')
            ->add('email', 'text')
            ->add('plainPassword', 'text')
            ->add('roles','choice', [
                    'choices'=>[
                        'Admin' => 'ROLE_ADMIN',
                        'Manager' => 'ROLE_MANAGER',
                        'User' => 'ROLE_USER',
                    ],
                    'multiple'=>true,
                    'expanded' => true,
                ]
            )
            ->add('isActive')
        ;
    }

    protected function configureDatagridFilters(DatagridMapper $filter)
    {
        $filter
            ->add('username')
            ->add('email')
            ->add('roles')
            ->add('isActive')
        ;
    }

    protected function configureListFields(ListMapper $list)
    {
        $list
            ->addIdentifier('username')
            ->add('email')
            ->add('roles', 'array')
            ->add('isActive')
        ;
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function prePersist($user)
    {
        $user->setPassword($this->encodePassword($user, $user->getPlainPassword()));
    }

    public function preUpdate($user)
    {
        $user->setPassword($this->encodePassword($user, $user->getPlainPassword()));
    }

    private function encodePassword($user, $plainPassword)
    {
        $encoder = $this->container->get('security.encoder_factory')
            ->getEncoder($user)
        ;

        return $encoder->encodePassword($plainPassword, $user);
    }
}
