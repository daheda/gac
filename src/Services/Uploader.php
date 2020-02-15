<?php 

namespace Gac\Services;

class Uploader {
    
    private $fileName;
	private $contentLength;
	private $destination;

	public function __construct($fileName, $contentLength)
	{
		$this->fileName = $fileName ; 
		$this->contentLength = $contentLength; 
	}

    public function isValid()
    {
        //@todo
        return true;
    }

    public function setDestination($destination)
    {
    	$this->destination = $destination;
    }

    public function upload()
    {
        if (!$this->isValid()) {
            throw new \Exception('No file uploaded!');
        }

        $fileReader = fopen('php://input', "r");
        $destination = \rtrim($this->destination, '/') . '/';
        $uploadedFile = $destination . $this->fileName;
        $fileWriter = fopen($uploadedFile, "w+");
        
        while(true) {
            $buffer = fgets($fileReader, 4096);
            if (strlen($buffer) == 0) {
                fclose($fileReader);
                fclose($fileWriter);
                return $uploadedFile;
            }
            fwrite($fileWriter, $buffer);
        }

        return false;
    }
}