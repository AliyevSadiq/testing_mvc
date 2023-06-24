<?php


interface RepositoryInterface
{
    public function save(array $data);

    public function get(int $id);

}