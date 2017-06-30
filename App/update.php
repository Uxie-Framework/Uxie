<?php

namespace App;

class update
{
    private $updateFiles;
    private $files = [];
    public $success = [];

    public function __construct()
    {
        $this->updateFiles = '../update';
        $this->getDirectorys($this->updateFiles);
        $this->updateFiles();
    }

    // collecting files directorys
    private function getDirectorys($updateFiles)
    {
        $content = scandir($updateFiles);
        for ($i = 2; $i < count($content); $i++) {
            $string = str_split($content[$i]);
            if (is_file($updateFiles.'/'.$content[$i])) {
                if ($string[0] != '.') {
                    $this->files[] = $updateFiles.'/'.$content[$i];
                }
            } elseif (is_dir($updateFiles.'/'.$content[$i]) && $updateFiles.'/'.$content[$i] != $this->updateFiles.'/public') {
                if ($string[0] != '.' && !strstr($content[$i], 'config')) {
                    $this->getDirectorys($updateFiles.'/'.$content[$i]);
                }
            }
        }
    }

    // updating old files with new ones
    private function updateFiles()
    {
        foreach ($this->files as $File) {
            $this->success[] = file_put_contents('../'.$this->getRealDirectory($File), file_get_contents($File));
        }
    }

    // transforming directorys from inside to update file to main directory
    private function getRealDirectory($File)
    {
        $File = explode('/', $File);
        $updateFiles = explode('/', $this->updateFiles);
        $realDirectory = array_slice($File, count($updateFiles));
        $realDirectory = implode('/', $realDirectory);

        return $realDirectory;
    }
}
