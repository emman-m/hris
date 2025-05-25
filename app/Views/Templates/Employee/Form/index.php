<?php

use App\Enums\EducationLevel;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <title>Personnel Information Form</title>
    <style>
        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .page {
                width: 210mm;
                min-height: 297mm;
                padding: 20mm;
                margin: auto;
                font-size: 12pt;
                font-family: "Times New Roman", serif;
            }
        }

        body {
            margin: 0;
            font-family: "Times New Roman", serif;
            font-size: 12pt;
            background: #fff;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            padding: 20mm;
            margin: auto;
            background: white;
        }

        .title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 16pt;
        }

        .subtitle {
            text-align: center;
            font-style: italic;
            font-size: 11pt;
            margin-bottom: 20px;
        }

        .section-title {
            font-weight: bold;
            margin-top: 1.5rem;
            margin-bottom: 0.5rem;
            font-size: 13pt;
            border-bottom: 1px solid #000;
        }

        .field-group {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 6px;
        }

        .label {
            width: auto;
            margin-right: 5px;
        }

        .field {
            border-bottom: 1px solid black;
            padding: 0 5px;
            min-width: 100px;
            flex-grow: 1;
            margin-right: 10px;
        }

        .field-inline {
            border-bottom: 1px solid black;
            display: inline-block;
            min-width: 100px;
            padding: 0 5px;
            margin: 0 10px;
        }

        p {
            margin: 6px 0;
        }
    </style>
</head>

<body>
    <div class="page">
        <div class="title">PERSONNEL INFORMATION</div>
        <div class="subtitle">(This form is printed via HRMS portal)</div>

        <div class="field-group">
            <div class="label">NAME:</div>
            <div class="field"><?= $user['last_name'] ?></div>
            <div class="field"><?= $user['first_name'] ?></div>
            <div class="field"><?= $user['middle_name'] ?></div>
        </div>

        <div class="field-group">
            <div class="label">Department:</div>
            <div class="field"><?= $employeeInfo['department'] ?></div>
        </div>

        <div class="field-group">
            <div class="label">Date of Birth:</div>
            <div class="field"><?= $employeeInfo['birth'] ?></div>
            <div class="label">Gender:</div>
            <div class="field"><?= $employeeInfo['gender'] ?></div>
            <div class="label">Status:</div>
            <div class="field"><?= $employeeInfo['status'] ?></div>
        </div>

        <div class="field-group">
            <div class="label">Place of Birth:</div>
            <div class="field"><?= $employeeInfo['birth_place'] ?></div>
        </div>

        <?php if ($employeeInfo['status'] === 'Married'): ?>
            <div class="field-group">
                <div class="label">Name of Spouse (if Married):</div>
                <div class="field"><?= $employeeInfo['spouse'] ?></div>
            </div>
        <?php endif; ?>

        <div class="field-group">
            <div class="label">Permanent Address:</div>
            <div class="field"><?= $employeeInfo['permanent_address'] ?></div>
        </div>

        <div class="field-group">
            <div class="label">Present Address:</div>
            <div class="field"><?= $employeeInfo['present_address'] ?></div>
        </div>

        <div class="field-group">
            <div class="label">Father's Name:</div>
            <div class="field"><?= $employeeInfo['fathers_name'] ?></div>
            <div class="label">Mother's Name:</div>
            <div class="field"><?= $employeeInfo['mothers_name'] ?></div>
        </div>

        <div class="field-group">
            <div class="label">Mother's Maiden Name:</div>
            <div class="field"><?= $employeeInfo['mothers_maiden_name'] ?></div>
            <div class="label">Religion:</div>
            <div class="field"><?= $employeeInfo['religion'] ?></div>
        </div>

        <div class="field-group">
            <div class="label">Tel No.:</div>
            <div class="field"><?= $employeeInfo['tel'] ?></div>
            <div class="label">Cell Phone No.:</div>
            <div class="field"><?= $employeeInfo['phone'] ?></div>
            <div class="label">Nationality:</div>
            <div class="field"><?= $employeeInfo['nationality'] ?></div>
        </div>

        <div class="field-group">
            <div class="label">SSS No.:</div>
            <div class="field"><?= $employeeInfo['sss'] ?></div>
            <div class="label">Date of Coverage:</div>
            <div class="field"><?= $employeeInfo['date_of_coverage'] ?></div>
        </div>

        <div class="field-group">
            <div class="label">Pag-ibig MID No.:</div>
            <div class="field"><?= $employeeInfo['pagibig'] ?></div>
            <div class="label">TIN:</div>
            <div class="field"><?= $employeeInfo['tin'] ?></div>
            <div class="label">Philhealth No.:</div>
            <div class="field"><?= $employeeInfo['philhealth'] ?></div>
        </div>

        <div class="field-group">
            <div class="label">Res. Cert. No.:</div>
            <div class="field"><?= $employeeInfo['res_cert_no'] ?></div>
            <div class="label">Issued on:</div>
            <div class="field"><?= $employeeInfo['res_issued_on'] ?></div>
            <div class="label">Issued at:</div>
            <div class="field"><?= $employeeInfo['res_issued_at'] ?></div>
        </div>

        <div class="field-group">
            <div class="label">Contact Person in Case of Emergency:</div>
            <div class="field"><?= $employeeInfo['contact_person'] ?></div>
        </div>

        <div class="field-group">
            <div class="label">Contact No.:</div>
            <div class="field"><?= $employeeInfo['contact_person_no'] ?></div>
            <div class="label">Relationship:</div>
            <div class="field"><?= $employeeInfo['contact_person_relation'] ?></div>
            <div class="label">Year Employed:</div>
            <div class="field"><?= $employeeInfo['employment_date'] ?></div>
        </div>

        <div class="section-title">EDUCATION:</div>
        <?php foreach ($employeeInfo['educations'] as $education): ?>
            <p><strong><?= $education['level'] ?></strong></p>
            <div class="field-group">
                <div class="label">School/Address:</div>
                <div class="field"><?= $education['school_address'] ?></div>
            </div>
            <!-- Hide fields if it is elementary or hight school -->
            <?php if (($education['level'] !== EducationLevel::ELEMENTARY->value) && ($education['level'] !== EducationLevel::HIGHSCHOOL->value)): ?>
                <div class="field-group">
                    <div class="label">Degree:</div>
                    <div class="field"><?= $education['degree'] ?></div>
                </div>
                <div class="field-group">
                    <div class="label">Major/Minor:</div>
                    <div class="field"><?= $education['major_minor'] ?></div>
                </div>
            <?php endif; ?>
            <div class="field-group">
                <div class="label">Year Graduated:</div>
                <div class="field"><?= $education['year_graduated'] ?></div>
            </div>
        <?php endforeach; ?>
        <div style="page-break-after:always"></div>

        <div class="section-title">DEPENDENTS:</div>
        <?php foreach ($employeeInfo['dependents'] as $dependent): ?>
            <div class="field-group">
                <div class="label">Name:</div>
                <div class="field"><?= $dependent['name'] ?></div>
                <div class="label">Birthdate:</div>
                <div class="field"><?= $dependent['birth'] ?></div>
                <div class="label">Relationship:</div>
                <div class="field"><?= $dependent['relationship'] ?></div>
            </div>
        <?php endforeach; ?>

        <div class="section-title">EMPLOYMENT RECORD:</div>
        <?php foreach ($employeeInfo['employmentHistory'] as $employment): ?>
            <div class="field-group">
                <div class="label">Name of Employer:</div>
                <div class="field"><?= $employment['name'] ?></div>
            </div>
            <div class="field-group">
                <div class="label">Position Held:</div>
                <div class="field"><?= $employment['position'] ?></div>
            </div>
            <div class="field-group">
                <div class="label">Inclusive Dates:</div>
                <div class="field"><?= $employment['year_from'] ?> - <?= $employment['year_to'] ?></div>
            </div>
        <?php endforeach; ?>

        <div class="section-title">PROFESSIONAL AFFILIATIONS:</div>
        <?php foreach ($employeeInfo['affiliationPro'] as $pro): ?>
            <div class="field-group">
                <div class="label">Organization:</div>
                <div class="field"><?= $pro['name'] ?></div>
                <div class="label">Position:</div>
                <div class="field"><?= $pro['position'] ?></div>
            </div>
        <?php endforeach; ?>

        <div class="section-title">SOCIO-CIVIC AFFILIATIONS:</div>
        <?php foreach ($employeeInfo['affiliationSocio'] as $socio): ?>
            <div class="field-group">
                <div class="label">Organization:</div>
                <div class="field"><?= $socio['name'] ?></div>
                <div class="label">Position:</div>
                <div class="field"><?= $socio['position'] ?></div>
            </div>
        <?php endforeach; ?>

        <div class="section-title">LICENSES/CERTIFICATIONS:</div>
        <?php if ($employeeInfo['licensure']): ?>
            <div class="field-group">
                <div class="label">License:</div>
                <div class="field"><?= $employeeInfo['licensure']['license'] ?></div>
                <div class="label">Year:</div>
                <div class="field"><?= $employeeInfo['licensure']['year'] ?></div>
            </div>
            <div class="field-group">
                <div class="label">Rating:</div>
                <div class="field"><?= $employeeInfo['licensure']['rating'] ?></div>
                <div class="label">License No.:</div>
                <div class="field"><?= $employeeInfo['licensure']['license_no'] ?></div>
            </div>
        <?php endif; ?>

        <div class="section-title">POSITION HISTORY:</div>
        <div class="subtitle">Current Position</div>
        <?php foreach ($employeeInfo['currentPosition'] as $position): ?>
            <div class="field-group">
                <div class="label">Position:</div>
                <div class="field"><?= $position['position'] ?></div>
                <div class="label">From:</div>
                <div class="field"><?= $position['year_from'] ?></div>
                <div class="label">To:</div>
                <div class="field"><?= $position['year_to'] ?></div>
            </div>
        <?php endforeach; ?>

        <div class="subtitle">Past Positions</div>
        <?php foreach ($employeeInfo['pastPosition'] as $position): ?>
            <div class="field-group">
                <div class="label">Position:</div>
                <div class="field"><?= $position['position'] ?></div>
                <div class="label">From:</div>
                <div class="field"><?= $position['year_from'] ?></div>
                <div class="label">To:</div>
                <div class="field"><?= $position['year_to'] ?></div>
            </div>
        <?php endforeach; ?>

        <div class="section-title">CERTIFICATION:</div>
        <p style="text-align: justify;">I hereby certify that the above information is true and correct to the best of
            my knowledge and belief. I understand that any false information may be grounds for termination.</p>

        <div class="field-group" style="margin-top: 2rem;">
            <div class="label" style="width: 30%;">Signature:</div>
            <div class="field" style="width: 50%;"><?= $user['first_name'] . ' ' . $user['last_name'] ?></div>
        </div>
        <div class="field-group">
            <div class="label" style="width: 30%;">Date:</div>
            <div class="field" style="width: 50%;"><?= date('F d, Y') ?></div>
        </div>
    </div>
</body>
<script>
    window.print();
    window.onafterprint = function () {
        window.close();
    };
</script>

</html>