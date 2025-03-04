<?php

namespace App\Services;

use App\Libraries\Policy\AuthPolicy;
use CodeIgniter\Exceptions\PageNotFoundException;
use DateTime;

class AttendanceService
{
    protected $auth;

    public function __construct()
    {
        $this->auth = new AuthPolicy();
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

        $attendanceData = [];
        $rowNumber = 0;

        // Read the CSV file line by line
        while (($row = fgetcsv($handle, 70000, ',')) !== false) {
            $rowNumber++;

            // Skip the header row
            if ($rowNumber == 1) {
                continue;
            }

            // Stop reading if encounter an empty row
            if (empty($row[0])) {
                break;
            }

            // Map CSV data to database columns
            $attendanceData[] = [
                'employee_id' => $row[2], // Column C
                'remark' => $row[6], // Column G
                'machine' => $row[1], // Column B
                'date' => $this->formatDate($row[3]), // Column D
                'time_in' => $row[4], // Column E
                'time_out' => $row[5], // Column F
            ];
        }

        // Close the file handle
        fclose($handle);
        log_message('info', 'Attendance data: ' . json_encode($attendanceData));
        return $attendanceData;
    }

    protected function formatDate($rawDate)
    {
        // Format the date
        $date = DateTime::createFromFormat('m/d/Y', $rawDate);
        $formattedDate = $date ? $date->format('Y-m-d') : null;

        return $formattedDate;
    }
}
