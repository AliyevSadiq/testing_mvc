<?php


class MessageService
{
    public ?string $message = null;
    private MessageRepository $repository;
    private TestingMailer $mailer;

    public function __construct()
    {
        $this->repository = new MessageRepository();
        $this->mailer = new TestingMailer();
    }

    public function save(FormRequest $request)
    {
        $inserted_id = null;

        if ($request->validate()) {
            $inserted_id = $this->repository->save($request->all());
        }

        if ($inserted_id) {
            $messageData = $this->repository->get($inserted_id);
            $this->message = $messageData['message'];
            $this->mailer->send($this->message);
        }
    }
}