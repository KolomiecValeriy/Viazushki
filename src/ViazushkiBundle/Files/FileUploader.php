<?php

namespace ViazushkiBundle\Files;

use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    private $targetDir;
    private $cacheDir;
    private $mimeType;

    public function __construct($targetDir, $cacheDir)
    {
        $this->targetDir = $targetDir;
        $this->cacheDir = $cacheDir;
    }

    public function upload(UploadedFile $file)
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $this->mimeType = $file->getMimeType();

        $file->move($this->targetDir, $fileName);

        return $fileName;
    }

    public function remove($fileName)
    {
        $fileSystem = new Filesystem();
        $fileSystem->remove($this->targetDir.'/'.$fileName);

        $finder = new Finder();
        $finder->name($fileName);

        foreach ($finder->in($this->cacheDir) as $file) {
            $fileSystem->remove($file);
        }

        return true;
    }

    public function getMimeType()
    {
        return $this->mimeType;
    }
}
