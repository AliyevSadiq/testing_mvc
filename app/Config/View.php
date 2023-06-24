<?php


class View
{
    public function render($file, ?array $data = [])
    {
        foreach ($data as $key => $value) {
            $this->$key = $value;
        }

        ob_start();

        include('views/' . $file . ".php");
        return ob_get_clean();
    }
}