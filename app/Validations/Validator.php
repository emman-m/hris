<?php

namespace App\Validations;

use CodeIgniter\HTTP\RequestInterface;
use Config\Services;

class Validator
{
    /**
     * Validation rules.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * Run the validation process.
     *
     * @param RequestInterface $request
     * @return bool
     */
    public function runValidation(RequestInterface $request): bool
    {
        // Instantiate validation service directly inside the method
        $validation = Services::validation();

        // Set the validation rules
        $validation->setRules($this->rules);

        // Validate the form data
        if (!$validation->withRequest($request)->run()) {
            return false;
        }

        return true;
    }

    /**
     * Get validation errors.
     *
     * @return array
     */
    public function getErrors(): array
    {
        // Return validation errors
        return Services::validation()->getErrors();
    }
}