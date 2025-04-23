<?php

namespace App\Services;

use App\Libraries\Policy\AuthPolicy;
use Config\Database;
use DateTime;

class AttendanceService
{
    protected $auth;
    protected $attendance;

    public function __construct()
    {
        $this->auth = new AuthPolicy();
        $this->attendance = model('Attendance');
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

        $db = Database::connect();

        $attendanceData = [];
        $rowNumber = 0;

        $duplicate = 0;

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

            // skip row if invalid date
            if (!$this->formatDate($row[3])) {
                log_message('error', "Invalid date format on row $rowNumber");
                continue;
            }

            if (is_numeric($row[2][0])) {
                continue;
            }

            $formattedDate = $this->formatDate($row[3]);

            // search for an existing record
            $searchResponse = $db->table('attendances')
                ->where('employee_id', $row[2])
                ->where('transaction_date', $formattedDate)
                ->where('time_in', substr($row[4], 0, 8))
                ->get()
                ->getRow();

            // Map CSV data to database columns
            if (!$searchResponse) {
                $attendanceData[] = [
                    'employee_id' => $row[2], // Column C
                    'remark' => $row[6], // Column G
                    'machine' => $row[1], // Column B
                    'transaction_date' => $formattedDate, // Column D
                    'time_in' => $row[4], // Column E
                    'time_out' => $row[5], // Column F
                ];
            } else {
                fclose($handle);

                return [];
            }
        }

        // Close the file handle
        fclose($handle);
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
