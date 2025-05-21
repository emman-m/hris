<?php

namespace App\Services;

use App\Enums\UserRole;

class BulkUserService extends Service
{
    protected $user;

    public function __construct()
    {
        $this->user = model('User');
    }

    public function getContent($file)
    {
        if (!$file->isValid()) {
            withToast('error', 'Invalid file upload.');
            return redirect()->back();
        }

        // Open the file for reading
        if (($handle = fopen($file->getTempName(), 'r')) === false) {
            withToast('error', 'Unable to open the file.');
            return redirect()->back();
        }

        $userData = [];
        $rowNumber = 0;
        $processedEmails = [];

        // Read the CSV file line by line
        while (($row = fgetcsv($handle, 1000, ',')) !== false) {
            $rowNumber++;

            // Skip the header row
            if ($rowNumber == 1) {
                continue;
            }

            // Stop reading if encounter an empty row
            if (empty($row[0])) {
                break;
            }

            // Skip if role is not valid
            if (!in_array($row[0], array_column(UserRole::cases(), 'value'))) {
                log_message('warning', "Invalid role on row $rowNumber: {$row[0]}");
                continue;
            }

            // Skip if email already exists in database
            $existingUser = $this->user->where('email', $row[1])->first();
            if ($existingUser) {
                log_message('warning', "Email already exists on row $rowNumber: {$row[1]}");
                continue;
            }

            // Skip if email is duplicate in CSV
            if (in_array($row[1], $processedEmails)) {
                log_message('warning', "Duplicate email in CSV on row $rowNumber: {$row[1]}");
                continue;
            }

            $processedEmails[] = $row[1];

            // Map CSV data to database columns
            $userData[] = [
                'role' => $row[0],
                'email' => $row[1],
                'first_name' => $row[2],
                'middle_name' => $row[3],
                'last_name' => $row[4],
                'employee_id' => $row[5] ?? null,
            ];
        }

        // Close the file handle
        fclose($handle);
        return $userData;
    }
} 