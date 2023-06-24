<?php


abstract class AbstractController implements IController
{
    private BaseController $fc;

    public function __construct()
    {
        $this->fc = BaseController::getInstance();
    }


    protected function view(string $path, ?array $data = [])
    {
        $view = new View();
        $result = $view->render($path, $data);
        $this->fc->setBody($result);
    }
}