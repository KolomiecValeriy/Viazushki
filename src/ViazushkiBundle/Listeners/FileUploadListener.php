<?php

namespace ViazushkiBundle\Listeners;

use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use ViazushkiBundle\Entity\File;
use ViazushkiBundle\Service\FileUploader;

class FileUploadListener
{
    private $uploader;
    private $em;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();
        $this->em = $args->getEntityManager();

        $this->uploadFile($entity);
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->uploadFile($entity);
    }

    public function preRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        $this->removeFile($entity);
    }

    private function uploadFile($entity)
    {
        if (!$entity instanceof File) {
            return;
        }

        $files = $entity->getFiles();
        $filesCount = count($files);

        if (is_array($files)) {
            foreach ($files as $key => $file) {
                if ($file instanceof UploadedFile) {
                    $fileName = $this->uploader->upload($file);
                    $entity->setFileName($fileName);

                    if ($key != $filesCount - 1) {
                        $newFile = new File();
                        $newFile->setFileName($fileName);
                        $this->em->persist($newFile);
                        $this->em->flush();
                    }
                }
            }
        }
    }

    private function removeFile($entity)
    {
        if (!$entity instanceof File) {
            return;
        }

        $file = $entity->getFileName();

        $this->uploader->remove($file);
    }
}
