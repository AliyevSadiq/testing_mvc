<?php


class MessageRepository implements RepositoryInterface
{
    private Message $model;

    public function __construct()
    {
        $this->model = new Message();
    }


    public function save(array $data)
    {
        return $this->model->create($data);
    }

    public function get(int $id)
    {
        return $this->model->find($id);
    }
}