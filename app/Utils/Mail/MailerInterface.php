<?php


interface MailerInterface
{
    public function send(string $message);
}