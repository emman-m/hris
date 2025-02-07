<?php

namespace App\Rules;

use CodeIgniter\Validation\Rules;

class RequiredIfRules extends Rules
{
    public function required_if($str = null, ?string $fields = null, array $data = []): bool
    {
        // Split the 'fields' string into field name and value
        [$field, $value] = explode(',', $fields);

        // Check if the field exists and if the value matches
        if (isset($data[$field]) && $data[$field] === $value) {
            // The current field must be non-empty if the condition is met
            return !empty($str);
        }

        // If the condition isn't met, no need to validate the current field as required
        return true;
    }
}
