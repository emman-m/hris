<?php

namespace App\Rules;

use CodeIgniter\Validation\Rules;
use Config\Database;
use DateTime;

class CustomRules extends Rules
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

    public function edit_unique($value, $params): bool
    {
        // Get database connection
        $db = Database::connect();

        // Parse parameters
        [$table, $field, $current_id] = explode(".", $params);

        // Check for existing records
        $query = $db->table($table)
            ->where($field, $value)
            ->where('id !=', $current_id)
            ->get();

        // Return true if no matching records found
        return $query->getNumRows() === 0;
    }

    public function min_date($inputDate, $days): bool
    {
        // Create DateTime object for the input date
        $date = \DateTime::createFromFormat('Y-m-d\TH:i', $inputDate);

        // Get the current date and time
        $currentDate = new \DateTime();

        // Add 7 days to the current date
        $sevenDaysAhead = (clone $currentDate)->modify("+{$days} days");

        // Compare the dates
        return $date >= $sevenDaysAhead;
    }

    public function date_behind(string $str, string $fields, array $data): bool
    {
        // Extract the start_date from the fields parameter
        $startDateField = $fields;

        // Check if the start_date exists in the provided data
        if (!isset($data[$startDateField])) {
            return false; // Invalid if no start_date
        }

        // Parse the start_date and end_date
        $startDate = $data[$startDateField];
        $endDate = $str;
        
        // Create DateTime objects
        $datetime1 = new DateTime($startDate);
        $datetime2 = new DateTime($endDate);

        // Check if end_date is behind start_date
        return !($datetime2 < $datetime1); // True if end_date is not behind
    }

    public function is_existing(string $value, string $params, array $data): bool
    {
        [$table, $column] = explode('.', $params);

        $db = Database::connect();
        $query = $db->table($table)->where($column, $value)->get();

        return $query->getNumRows() > 0;
    }

}
