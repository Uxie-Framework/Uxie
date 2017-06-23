<?php
namespace App;

class update
{
    private $Root;
    private $updateFiles;
    private $Files = array();
    public $Success = array();

    public function __construct($updateFiles)
    {
        $this->Root = $_SERVER["DOCUMENT_ROOT"];
        $this->updateFiles = $updateFiles;
        $this->getDirectorys($this->updateFiles);
        $this->updateFiles();
    }

    private function getDirectorys($target)
    {
        $content = scandir($target);
        for ($i=2; $i < count($content); $i++) {
            $string = str_split($content[$i]);
            if (is_file($target."/".$content[$i])) {
                if ($string[0] != ".") {
                    $this->Files[] = $target."/".$content[$i];
                }
            } elseif (is_dir($target."/".$content[$i])) {
                if ($string[0] != "." && !strstr($content[$i], "config")) {
                    $this->getDirectorys($target."/".$content[$i]);
                }
            }
        }
    }

    private function updateFiles()
    {
        foreach ($this->Files as $File) {
            $this->Success[] = file_put_contents($this->Root."/".$this->getRealDirectory($File), file_get_contents($File));
        }
    }

    private function getRealDirectory($File)
    {
        $File = explode('/', $File);
        $updateFiles = explode('/', $this->updateFiles);
        $realDirectory = array_slice($File, count($updateFiles));
        $realDirectory = implode('/', $realDirectory);
        return $realDirectory;
    }
}
