<?php

use App\Enums\ApproveStatus;
use App\Models\User;

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the framework's
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @see: https://codeigniter.com/user_guide/extending/common.html
 */

/**
 * Adds a toast message to the session as Flashdata using SweetAlert2.
 *
 * @param string $icon    The type of icon (e.g., 'success', 'error', 'warning', 'info').
 * @param string $text    The text content of the toast.
 * @param string $title   The title of the toast.
 *
 * @return true
 */
if (!function_exists('withToast')) {
    function withToast($icon, $text, $title = "")
    {

        // Prepare the toast data
        $toastData = [
            'class' => $icon === 'error' ? 'danger' : $icon,
            'icon' => $icon,
            'title' => $title,
            'text' => $text,
        ];

        // Set the toast data as flashdata in the session
        session()->setFlashdata('toast', $toastData);

        return true;
    }
}

/**
 * Adds a Sweet alert message to the session as Flashdata using SweetAlert2.
 *
 * @param string $icon    The type of icon (e.g., 'success', 'error', 'warning', 'info').
 * @param string $text    The text content of the toast.
 * @param string $title   The title of the toast.
 *
 * @return true
 */
if (!function_exists('withSwal')) {
    function withSwal($icon, $text, $title = "")
    {

        // Prepare the toast data
        $toastData = [
            'class' => $icon === 'error' ? 'danger' : $icon,
            'icon' => $icon,
            'title' => $title,
            'text' => $text,
        ];

        // Set the toast data as flashdata in the session
        session()->setFlashdata('swal', $toastData);

        return true;
    }
}

if (!function_exists('chunk')) {
    /**
     * Processes large datasets in chunks.
     *
     * @param string|\CodeIgniter\Database\BaseBuilder $query A table name or query builder instance.
     * @param int $chunkSize Number of records per chunk.
     * @param callable $callback Callback function to process each chunk.
     */
    function chunk($query, int $chunkSize, callable $callback)
    {
        $db = \Config\Database::connect();

        // If a table name is passed, convert it to a query builder instance
        if (is_string($query)) {
            $builder = $db->table($query);
        } elseif ($query instanceof \CodeIgniter\Database\BaseBuilder) {
            $builder = $query;
        } else {
            throw new InvalidArgumentException('The $query parameter must be a string or a query builder instance.');
        }

        $offset = 0;

        while (true) {
            // Clone the query to preserve conditions
            $chunkQuery = clone $builder;

            // Get the next chunk of data
            $results = $chunkQuery->limit($chunkSize, $offset)->get()->getResultArray();

            // If no more results, break the loop
            if (empty($results)) {
                break;
            }

            // Process the chunk using the callback
            $callback($results);

            // Increment the offset for the next chunk
            $offset += $chunkSize;
        }
    }
}

if (!function_exists('downloadCSV')) {
    /**
     * Generate and download a CSV file.
     *
     * @param string $filename Filename for the CSV download (e.g., 'users.csv').
     * @param array $headers Array of column headers for the CSV file.
     * @param array $data Array of associative arrays containing data for the CSV file.
     * @return CodeIgniter\HTTP\ResponseInterface
     */
    function downloadCSV(string $filename, array $headers, array $data)
    {
        $output = fopen('php://output', 'w');
        ob_start();

        // Add the header row
        fputcsv($output, $headers);

        // Add data rows
        foreach ($data as $row) {
            fputcsv($output, $row);
        }

        fclose($output);

        // Get the CSV content
        $csvData = ob_get_clean();

        // Create a response with headers
        $response = service('response');
        return $response
            ->setHeader('Content-Type', 'text/csv')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($csvData);
    }
}

if (!function_exists('approve_status')) {
    /**
     * Generate badge for approval status
     *
     * @param string $status ApproveStatus enum
     * @return string
     */
    function approve_status(string $status)
    {
        $badge = "";
        $badge = match ($status) {
            ApproveStatus::APPROVED->value => '<span class="badge bg-teal-lt">' . ApproveStatus::APPROVED->value . '</span>',
            ApproveStatus::DENIED->value => '<span class="badge bg-red-lt">' . ApproveStatus::DENIED->value . '</span>',
            ApproveStatus::CANCELLED->value => '<span class="badge bg-yellow-lt">' . ApproveStatus::CANCELLED->value . '</span>',
            default => '<span class="badge bg-azure-lt">' . ApproveStatus::PENDING->value . '</span>',
        };

        return $badge;
    }
}

if (!function_exists('clean_content')) {
    function clean_content($content)
    {
        return strip_tags(html_entity_decode($content));
    }
}
if (!function_exists('dateFormat')) {
    /**
     * Formats a date according to the specified format.
     *
     * @param string $value The date value to format.
     * @param string $format The date format (default: 'd/m/Y h:i:s A').
     * @return string
     */
    function dateFormat($value, $format = 'd/m/Y h:i:s A')
    {
        // Check if the input is empty or an invalid date
        if (($value === '') || ($value === null) || ($value === '0000-00-00') || ($value === '0000-00-00 00:00:00')) {
            return ''; // Return an empty string for invalid values
        }

        // Determine the correct format for DateTime creation
        $dateFormat = (strlen($value) === 10) ? 'Y-m-d' : 'Y-m-d H:i:s';
        $date = DateTime::createFromFormat($dateFormat, $value);

        // If date creation fails, return an empty string
        if ($date === false) {
            return '';
        }

        return $date->format($format);
    }
}

if (!function_exists('normalizeArray')) {
    /**
     * Normalize an array by removing empty values and trimming strings.
     *
     * @param array|string $input The array to normalize.
     * @return array
     */
    function normalizeArray($input)
    {
        // Check if input is already an array
        if (is_array($input)) {
            return $input; // Return as is if it's an array
        }

        // If not an array, wrap it in an array
        return [$input];
    }
}