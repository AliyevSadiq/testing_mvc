<?php

session_start();

abstract class FormRequest implements BaseRequestInterface
{
    protected array $data;
    protected array $rules;
    private array $errors;

    public function __construct()
    {
        $this->data = $_POST;
        $this->rules = $this->rules();
    }

    abstract protected function rules();

    public function validate()
    {
        $this->errors = [];

        $this->checkCsrfToken();

        foreach ($this->rules as $field => $rules) {
            foreach ($rules as $rule) {
                $validationRule = $this->parseRule($rule);
                $value = $this->get($field);
                if (!$this->validateRule($validationRule, $value)) {
                    $this->setErrorMessage($field, $rule);
                    break;
                }
            }
        }

        return empty($this->errors);
    }

    private function checkCsrfToken(): bool
    {
        $csrfProtection = new CsrfProtection();

        if (array_key_exists('csrf_token', $this->data)) {
            $token = $this->data['csrf_token'];
            if (!$csrfProtection->validateToken($token)) {
                $this->errors['token'] = "Csrf token not valid";
                return false;
            }
        }
        unset($this->data['csrf_token']);
        $csrfProtection->generateToken();
        return true;
    }


    protected function parseRule($rule)
    {
        return explode(':', $rule);
    }

    public function get($field)
    {
        return $this->has($field) ? $this->data[$field] : null;
    }


    public function has($field): bool
    {
        return isset($this->data[$field]);
    }

    protected function validateRule($rule, $value)
    {
        $method = 'validate' . ucfirst($rule[0]);

        if (method_exists($this, $method)) {
            return $this->$method($value, $rule);
        }

        throw new Exception("Validation rule '$rule[0]' does not exist.");
    }

    protected function setErrorMessage($field, $rule)
    {
        $this->errors[$field] = "The field '$field' failed validation rule '$rule'";
    }

    public function add(array $params): self
    {
        $this->data = array_unique(array_merge($this->data, $params));
        return $this;
    }

    public function all(): array
    {
        return $this->data;
    }

    public function getErrorMessage(string $field)
    {
        return $this->errors[$field] ?? null;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    protected function validateRequired($value): bool
    {
        return !empty($value);
    }
}