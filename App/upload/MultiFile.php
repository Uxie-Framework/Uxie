<?php

namespace App\upload;

class MultiFile
{
    public $Files = [];
    public $Errors = [];

    public function __construct($key)
    {
        for ($i = 0; $i < count($_FILES[$key]['name']); $i++) {
            if (is_uploaded_file($_FILES[$key]['tmp_name'][$i])) {
                $data = [
          'name'     => $_FILES[$key]['name'][$i],
          'tmp_name' => $_FILES[$key]['tmp_name'][$i],
          ];
                $this->Files[] = new File($key, $data);
            }
        }
    }

    public function Upload($newPath)
    {
        $returns = [];
        if (empty($this->getErrors())) {
            foreach ($this->Files as $File) {
                $returns[] = $File->Upload($newPath);
            }

            return $returns;
        } else {
            return false;
        }
    }

    public function Size($size)
    {
        foreach ($this->Files as $File) {
            $File->Size($size);
        }

        return $this;
    }

    public function Extension($AllowedExtensions)
    {
        foreach ($this->Files as $File) {
            $File->Extension($AllowedExtensions);
        }

        return $this;
    }

    public function Exist()
    {
        foreach ($this->Files as $File) {
            $File->Exist();
        }

        return $this;
    }

    public function Compress($quality)
    {
        foreach ($this->Files as $File) {
            $File->Compress($quality);
        }

        return $this;
    }

    public function getErrors()
    {
        foreach ($this->Files as $File) {
            $this->Errors = array_merge($this->Errors, $File->Errors);
        }
        $this->Errors = array_unique($this->Errors);
        sort($this->Errors);

        return $this->Errors;
    }
}
