<?php

namespace App\upload;

class FileInfo implements FileInfoInterface
{
    private $Name;
    private $Extension;
    private $Size;
    private $TmpName;

    public function __construct($FilePath)
    {
        $this->Name = $this->Name ? $this->Name : pathinfo($FilePath, PATHINFO_FILENAME);
        $this->Size = filesize($FilePath);
        $this->TmpName = $FilePath;
    }

    public function getName()
    {
        return $this->Name;
    }

    public function setName($newName)
    {
        $this->Name = $newName;
    }

    public function getSize($File = false)
    {
        return $this->Size;
    }

    public function getExtension($File = false)
    {
        return $this->Extension;
    }

    public function setExtension($newExtension)
    {
        $this->Extension = $newExtension;
    }

    public function getTmpName()
    {
        return $this->TmpName;
    }

    public function setTmpName($TmpName)
    {
        $this->TmpName = $TmpName;
    }

    public function Compress($quality)
    {
        $info = getimagesize($this->TmpName);

        if ($info['mime'] == 'image/jpeg') {
            $image = imagecreatefromjpeg($this->TmpName);
        } elseif ($info['mime'] == 'image/gif') {
            $image = imagecreatefromgif($this->TmpName);
        } elseif ($info['mime'] == 'image/png') {
            $image = imagecreatefrompng($this->TmpName);
        }

        imagejpeg($image, $this->TmpName, $quality);

        return $this->TmpName;
    }
}
