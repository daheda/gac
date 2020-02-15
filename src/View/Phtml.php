<?php 
namespace Gac\View;

class Phtml
{
    protected $templateDir;
    protected static $_instance = null;
   
    static public function getInstance($templateDir) 
    {
        
        if ( !isset( self::$_instance ) ) 
        {
            self::$_instance = new Phtml($templateDir);   
        }
        
        return self::$_instance;
    }

    public function __construct($templateDir)
    {
        $this->templateDir = $templateDir;
    }

    public function render($template)
    {
        $file = \rtrim($this->templateDir, '/') . '/'. $template . ".php";
        if (\file_exists($file)) {
            include $file;
        } else {
            throw new \Exception("Template not found");
        }
    }
}