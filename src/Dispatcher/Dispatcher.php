<?php 
namespace Gac\Dispatcher;

class Dispatcher
{
    public static function Dispatch()
    {
        $action = $_REQUEST['action'] ?? '';
        $controller = new \Gac\Controller\MainController();
        $view = \Gac\View\Phtml::getInstance(\Config::TEMPLATE_DIR);

        $controller->init($view);
        switch($action)
        {
            case 'import':
                $controller->Import();
            break;
            case 'report-a':
                $controller->reportA();
            break;
            case 'report-b':
                $controller->reportB();
            break;
            case 'report-c':
                $controller->reportC();
            break;

            default:
                $controller ->Index();
        }
    }
}
