<?php


class Request implements BaseRequestInterface
{
    private BaseController $fc;

    public function __construct()
    {
        $this->fc = BaseController::getInstance();
    }

    public function get(string $param)
    {
        return $this->has($param) ? $this->fc->getParams()[$param] : null;
    }

    public function has(string $param): bool
    {
        return array_key_exists($param, $this->fc->getParams());
    }

    public function add(array $params): self
    {
        $this->fc->setParams(array_unique(array_merge($this->fc->getParams(), $params)));
        return $this;
    }

    public function all(): array
    {
        return $this->fc->getParams();
    }
}