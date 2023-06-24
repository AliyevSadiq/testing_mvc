<?php

session_start();

class IndexController extends AbstractController
{

    private CsrfProtection $csrfProtection;

    public function __construct()
    {
        parent::__construct();
        $this->csrfProtection = new CsrfProtection();
    }

    public function indexAction()
    {
        $this->view('index', [
            'token' => $this->csrfProtection->generateToken()
        ]);
    }

    public function storeAction(MessageSaveRequest $request, MessageService $service)
    {
        $service->save($request);
        $this->view('index', [
            'token' => $this->csrfProtection->getToken(),
            'message' => $service->message,
            'errors' => $request->getErrors(),
        ]);
    }
}
