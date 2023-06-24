<?php


interface BaseRequestInterface
{
    public function has(string $param): bool;


    public function get(string $param);


    public function add(array $params): self;


    public function all(): array;
}