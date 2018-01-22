<?php

namespace ViazushkiBundle\Service;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDir;
    private $mimeType;

    public function __construct($targetDir)
    {
        $this->targetDir = $targetDir;
    }

    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $this->mimeType = $file->getMimeType();

        $file->move($this->getTargetDir(), $fileName);

        return $fileName;
    }

    public function remove($fileName)
    {
        $fileSystem = new Filesystem();
        $fileSystem->remove($this->getTargetDir().'/'.$fileName);

        return true;
    }

    public function getTargetDir()
    {
        return $this->targetDir;
    }

    public function getMimeType()
    {
        return $this->mimeType;
    }
}
