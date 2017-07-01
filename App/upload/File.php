<?php

namespace App\upload;

class File extends Validate
{
    public function __construct($key, $File = false)
    {
        if (!$File) {
            $File = [
                'name'     => $_FILES[$key]['name'],
                'tmp_name' => $_FILES[$key]['tmp_name'],
            ];
        }
        $FilePath = $File['tmp_name'];
        $FileName = explode('.', $File['name']);
        $this->setName($FileName[0]);
        $this->setExtension(strtolower(end($FileName)));
        parent::__construct($FilePath);
    }

    public function Upload($newPath)
    {
        $newPath = "Storage/$newPath";
        if (!is_dir($newPath)) {
            mkdir($newPath);
        }
        if (is_dir($newPath) && is_writable($newPath)) {
            if (empty($this->Errors)) {
                $path = $newPath.DIRECTORY_SEPARATOR.$this->getName().'.'.$this->getExtension();
                move_uploaded_file($this->getTmpName(), $path);

                return ['name' => $this->getName().'.'.$this->getExtension(), 'dir' => $path];
            } else {
                return false;
            }
        } else {
            $this->Errors[] = "No access to this directory $newPath";

            return false;
        }
    }
}
