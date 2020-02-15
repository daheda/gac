<?php 

namespace Gac\Controller;
    use Gac\Services\Uploader as UploaderService,
        Gac\Services\ImportTickestAppels as ImportService,
        Gac\Services\Report as ReportService;

class MainController 
{
    private $view;
    public function init($view)
    {
        $this->view = $view;
    }

    public function Index()
    {
        $this->view->render('home');
    }

    public function Import()
    {
        if (!isset($_SERVER['CONTENT_LENGTH'])) {
			throw new \Exception("Empty file!");
        }
        try {
            $filename = \md5(time());
            $contentLenght = $_SERVER['CONTENT_LENGTH'];
            $uploader = new UploaderService($filename, $contentLenght);
            $uploader->setDestination(\Config::TMP_PATH);
            if( $uploadedPath = $uploader->upload() ) {
                $import = new ImportService($uploadedPath);
                if($import->process()) {
                    \unlink($uploadedPath);
                    echo \implode("\n", [
                        "Import términé",
                        "Total importé: {$import->getNumberImported()}" ,
                        "Total erruer: {$import->getNumberError()}"
                    ]);
                    return true;
                }else {
                    \unlink($uploadedPath);
                }
                
            }
            echo "OOps! Unexpected error. Sorry";
            return false;
        } catch(\Exception $e) {
            throw $e;
        }
        
    }

    public function reportA()
    {
        $report = new ReportService();
        $data = $report->getTotalCallAfterOneDate();
        echo \implode("\n", $data);
    }

    public function reportB()
    {
        $report = new ReportService();
        $data = $report->getTopN();
        echo \implode("\n", $data);
    }

    public function reportC()
    {
        $report = new ReportService();
        $data = $report->getTotalSms();
        echo \implode("\n", $data);
    }

}