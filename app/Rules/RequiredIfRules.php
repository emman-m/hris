<?php

namespace App\Rules;

use CodeIgniter\Validation\Rules;

class RequiredIfRules
{
    /**
     * Custom required_if rule.
     *
     * @param string $str
     * @param string $fields
     * @param array  $data
     * @return bool
     */
    public function required_if(string $str, string $fields, array $data): bool
    {
        // Explode the fields into an array, expecting 'field:value'
        [$field, $value] = explode(":", $fields);

        // Check if the field exists in data and has the given value
        if (isset($data[$field]) && $data[$field] == $value) {
            // If the field is the specific value, the current field is required
            return !empty($str);
        }

        // If the condition is not met, skip validation (not required)
        return true;
    }
}
