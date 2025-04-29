<?php

use App\Enums\AffiliationType;
use App\Enums\EducationLevel;
use App\Enums\EmployeeDepartment;
use App\Enums\EmployeeStatus;
use App\Enums\Religion;

$is_locked ??= false;
?>
<div class="card-body">
    <!-- Step 1 -->
    <div class="step-form step1">
        <h2>Personal Information</h2>
        <input type="hidden" name="ei_id" value="<?= old('ei_id') ?>">
        <!-- Row -->
        <div class="row">
            <!-- Department -->
            <div class="mb-4 department-container">
                <label class="form-label">Department</label>
                <select name="department" class="form-select mt-1 block w-full" <?= $is_locked ? 'disabled' : '' ?>>
                    <option value="" selected disabled>- Please Select -</option>
                    <?php foreach (EmployeeDepartment::cases() as $department): ?>
                        <option value="<?= $department->value ?>" <?= $department->value === old('department') ? 'selected' : '' ?>>
                            <?= $department->value ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <!-- Error Message -->
                <?php if (isset($errors['department'])): ?>
                    <div class="invalid-feedback d-block">
                        <?= $errors['department'] ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-12 col-md-3">
                <div class="mb-4">
                    <!-- Date of Birth -->
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="ei_date_of_birth" class="form-control mt-1 block w-full"
                        value="<?= old('ei_date_of_birth') ?>" autocomplete="off" <?= $is_locked ? 'disabled' : '' ?>>
                    <!-- Error Message -->
                    <?php if (isset($errors['ei_date_of_birth'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= $errors['ei_date_of_birth'] ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
                <div class="mb-4">
                    <!-- Place of Birth -->
                    <label class="form-label">Place of Birth</label>
                    <input type="text" name="ei_birth_place" class="form-control mt-1 block w-full"
                        value="<?= old('ei_birth_place') ?>" autocomplete="off" <?= $is_locked ? 'disabled' : '' ?>>
                    <!-- Error Message -->
                    <?php if (isset($errors['ei_birth_place'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= $errors['ei_birth_place'] ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
                <div class="mb-4">
                    <!-- Gender -->
                    <label class="form-label">Gender</label>
                    <select name="ei_gender" class="form-select mt-1 block w-full" <?= $is_locked ? 'disabled' : '' ?>>
                        <option value="" selected disabled>- Please Select -</option>
                        <option value="Male" <?= old('ei_gender') === 'Male' ? 'selected' : '' ?>>Male</option>
                        <option value="Female" <?= old('ei_gender') === 'Female' ? 'selected' : '' ?>>Female</option>
                    </select>
                    <!-- Error Message -->
                    <?php if (isset($errors['ei_gender'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= $errors['ei_gender'] ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
                <div class="mb-4">
                    <!-- Status -->
                    <label class="form-label">Status</label>
                    <select id="ei_status" name="ei_status" class="form-select mt-1 block w-full" <?= $is_locked ? 'disabled' : '' ?>>
                        <option value="" selected disabled>- Please Select -</option>
                        <?php foreach (EmployeeStatus::cases() as $status): ?>
                            <option value="<?= $status->value ?>" <?= $status->value === old('ei_status') ? 'selected' : '' ?>>
                                <?= $status->value ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <!-- Error Message -->
                    <?php if (isset($errors['ei_status'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= $errors['ei_status'] ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- Row -->
        <div class="row">
            <div class="col-sm-12 col-md-4 spouse-div" style="display:none">
                <div class="mb-4">
                    <!-- Spouse -->
                    <label class="form-label">Spouse Name</label>
                    <input type="text" name="ei_spouse" class="form-control mt-1 block w-full"
                        value="<?= old('ei_spouse') ?>" autocomplete="off" <?= $is_locked ? 'disabled' : '' ?>>
                    <!-- Error Message -->
                    <?php if (isset($errors['ei_spouse'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= $errors['ei_spouse'] ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- Row -->
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <!-- Permanent Address -->
                <div class="mb-4">
                    <label class="form-label">Permanent Address</label>
                    <input type="text" name="ei_permanent_address" class="form-control mt-1 block w-full"
                        value="<?= old('ei_permanent_address') ?>" autocomplete="off" <?= $is_locked ? 'disabled' : '' ?>>
                    <!-- Error Message -->
                    <?php if (isset($errors['ei_permanent_address'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= $errors['ei_permanent_address'] ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-6">
                <!-- Present Address -->
                <div class="mb-4">
                    <label class="form-label">Present Address</label>
                    <input type="text" name="ei_present_address" class="form-control mt-1 block w-full"
                        value="<?= old('ei_present_address') ?>" autocomplete="off" <?= $is_locked ? 'disabled' : '' ?>>
                    <!-- Error Message -->
                    <?php if (isset($errors['ei_present_address'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= $errors['ei_present_address'] ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <hr>
        <!-- Row -->
        <div class="row">
            <div class="col-sm-12 col-md-5">
                <!-- Father's Name -->
                <div class="mb-4">
                    <label class="form-label">Father's Name</label>
                    <input type="text" name="ei_fathers_name" class="form-control mt-1 block w-full"
                        value="<?= old('ei_fathers_name') ?>" autocomplete="off" <?= $is_locked ? 'disabled' : '' ?>>
                    <!-- Error Message -->
                    <?php if (isset($errors['ei_fathers_name'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= $errors['ei_fathers_name'] ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-7">
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <!-- Mother's Name -->
                        <div class="mb-4">
                            <label class="form-label">Mother's Name</label>
                            <input type="text" name="ei_mothers_name" class="form-control mt-1 block w-full"
                                value="<?= old('ei_mothers_name') ?>" autocomplete="off" <?= $is_locked ? 'disabled' : '' ?>>
                            <!-- Error Message -->
                            <?php if (isset($errors['ei_mothers_name'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $errors['ei_mothers_name'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <!-- Mother's Maiden Name -->
                        <div class="mb-4">
                            <label class="form-label">Mother's Maiden Name</label>
                            <input type="text" name="ei_mothers_maiden_name" class="form-control mt-1 block w-full"
                                value="<?= old('ei_mothers_maiden_name') ?>" autocomplete="off" <?= $is_locked ? 'disabled' : '' ?>>
                            <!-- Error Message -->
                            <?php if (isset($errors['ei_mothers_maiden_name'])): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $errors['ei_mothers_maiden_name'] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Row -->
        <div class="row">
            <div class="col-sm-12 col-md-3">
                <!-- Religion -->
                <div class="mb-4">
                    <label class="form-label">Religion</label>
                    <select id="ei_religion" name="ei_religion" class="form-select mt-1 block w-full" <?= $is_locked ? 'disabled' : '' ?>>
                        <option value="" selected disabled>- Please Select -</option>
                        <?php foreach (Religion::cases() as $status): ?>
                            <option value="<?= $status->value ?>" <?= $status->value === old('ei_religion') ? 'selected' : '' ?>>
                                <?= $status->value ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <!-- Error Message -->
                    <?php if (isset($errors['ei_religion'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= $errors['ei_religion'] ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
                <!-- Tel No. -->
                <div class="mb-4">
                    <label class="form-label">Tel No.</label>
                    <input type="text" name="ei_tel" class="form-control mt-1 block w-full" value="<?= old('ei_tel') ?>"
                        autocomplete="off" <?= $is_locked ? 'disabled' : '' ?>>
                    <!-- Error Message -->
                    <?php if (isset($errors['ei_tel'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= $errors['ei_tel'] ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
                <!-- Phone No. -->
                <div class="mb-4">
                    <label class="form-label">Phone No.</label>
                    <input type="text" name="ei_phone" class="form-control mt-1 block w-full"
                        value="<?= old('ei_phone') ?>" autocomplete="off" <?= $is_locked ? 'disabled' : '' ?>>
                    <!-- Error Message -->
                    <?php if (isset($errors['ei_phone'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= $errors['ei_phone'] ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
                <!-- Nationality -->
                <div class="mb-4">
                    <label class="form-label">Nationality</label>
                    <input type="text" name="ei_nationality" class="form-control mt-1 block w-full"
                        value="<?= old('ei_nationality') ?>" autocomplete="off" <?= $is_locked ? 'disabled' : '' ?>>
                    <!-- Error Message -->
                    <?php if (isset($errors['ei_nationality'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= $errors['ei_nationality'] ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <hr>
        <!-- Row -->
        <div class="row">
            <div class="col-sm-12 col-md-3">
                <!-- SSS No -->
                <div class="mb-4">
                    <label class="form-label">SSS No</label>
                    <input type="text" name="ei_sss" class="form-control mt-1 block w-full" value="<?= old('ei_sss') ?>"
                        autocomplete="off" <?= $is_locked ? 'disabled' : '' ?>>
                    <!-- Error Message -->
                    <?php if (isset($errors['ei_sss'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= $errors['ei_sss'] ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-2">
                <!-- Date of Coverage -->
                <div class="mb-4">
                    <label class="form-label">SSS Date of Coverage</label>
                    <input type="date" name="ei_date_of_coverage" class="form-control mt-1 block w-full"
                        value="<?= old('ei_date_of_coverage') ?>" autocomplete="off" <?= $is_locked ? 'disabled' : '' ?>>
                    <!-- Error Message -->
                    <?php if (isset($errors['ei_date_of_coverage'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= $errors['ei_date_of_coverage'] ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
                <!-- Pag-ibig MID No. -->
                <div class="mb-4">
                    <label class="form-label">Pag-ibig MID No.</label>
                    <input type="text" name="ei_pagibig" class="form-control mt-1 block w-full"
                        value="<?= old('ei_pagibig') ?>" autocomplete="off" <?= $is_locked ? 'disabled' : '' ?>>
                    <!-- Error Message -->
                    <?php if (isset($errors['ei_pagibig'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= $errors['ei_pagibig'] ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
                <!-- TIN No. -->
                <div class="mb-4">
                    <label class="form-label">TIN No.</label>
                    <input type="text" name="ei_tin" class="form-control mt-1 block w-full" value="<?= old('ei_tin') ?>"
                        autocomplete="off" <?= $is_locked ? 'disabled' : '' ?>>
                    <!-- Error Message -->
                    <?php if (isset($errors['ei_tin'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= $errors['ei_tin'] ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-sm-12 col-md-3">
                <!-- Philhealth No. -->
                <div class="mb-4">
                    <label class="form-label">Philhealth No.</label>
                    <input type="text" name="ei_philhealth" class="form-control mt-1 block w-full"
                        value="<?= old('ei_philhealth') ?>" autocomplete="off" <?= $is_locked ? 'disabled' : '' ?>>
                    <!-- Error Message -->
                    <?php if (isset($errors['ei_philhealth'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= $errors['ei_philhealth'] ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- Row -->
        <div class="row">
            <div class="col-sm-12 col-md-6">
                <!-- Res Cert No. -->
                <div class="mb-4">
                    <label class="form-label">Res Cert No.</label>
                    <input type="text" name="ei_res_cert_no" class="form-control mt-1 block w-full"
                        value="<?= old('ei_res_cert_no') ?>" autocomplete="off" <?= $is_locked ? 'disabled' : '' ?>>
                    <!-- Error Message -->
                    <?php if (isset($errors['ei_res_cert_no'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= $errors['ei_res_cert_no'] ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
                <!-- Issued on -->
                <div class="mb-4">
                    <label class="form-label">Issued On</label>
                    <input type="date" name="ei_res_issued_on" class="form-control mt-1 block w-full"
                        value="<?= old('ei_res_issued_on') ?>" autocomplete="off" <?= $is_locked ? 'disabled' : '' ?>>
                    <!-- Error Message -->
                    <?php if (isset($errors['ei_res_issued_on'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= $errors['ei_res_issued_on'] ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-3">
                <!-- Issued At -->
                <div class="mb-4">
                    <label class="form-label">Issued At</label>
                    <input type="text" name="ei_res_issued_at" class="form-control mt-1 block w-full"
                        value="<?= old('ei_res_issued_at') ?>" autocomplete="off" <?= $is_locked ? 'disabled' : '' ?>>
                    <!-- Error Message -->
                    <?php if (isset($errors['ei_res_issued_at'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= $errors['ei_res_issued_at'] ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <hr>
        <!-- Row -->
        <div class="row">
            <div class="col-sm-12 col-md-4">
                <!-- Contact Person in Case of Emergency -->
                <div class="mb-4">
                    <label class="form-label">Contact Person in Case of Emergency</label>
                    <input type="text" name="ei_contact_person" class="form-control mt-1 block w-full"
                        value="<?= old('ei_contact_person') ?>" autocomplete="off" <?= $is_locked ? 'disabled' : '' ?>>
                    <!-- Error Message -->
                    <?php if (isset($errors['ei_contact_person'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= $errors['ei_contact_person'] ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <!-- Contact No. -->
                <div class="mb-4">
                    <label class="form-label">Contact No.</label>
                    <input type="text" name="ei_contact_person_no" class="phone form-control mt-1 block w-full"
                        value="<?= old('ei_contact_person_no') ?>" autocomplete="off" <?= $is_locked ? 'disabled' : '' ?>>
                    <!-- Error Message -->
                    <?php if (isset($errors['ei_contact_person_no'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= $errors['ei_contact_person_no'] ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <!-- Relationship -->
                <div class="mb-4">
                    <label class="form-label">Relationship</label>
                    <input type="text" name="ei_contact_person_relation" class="form-control mt-1 block w-full"
                        value="<?= old('ei_contact_person_relation') ?>" autocomplete="off" <?= $is_locked ? 'disabled' : '' ?>>
                    <!-- Error Message -->
                    <?php if (isset($errors['ei_contact_person_relation'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= $errors['ei_contact_person_relation'] ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <hr>
        <!-- Row -->
        <div class="row">
            <div class="col-sm-12 col-md-4">
                <!-- Year Employed in LCCT -->
                <div class="mb-4">
                    <label class="form-label">Year Employed in LCCT</label>
                    <input type="date" name="ei_employment_date" class="form-control mt-1 block w-full"
                        value="<?= old('ei_employment_date') ?>" autocomplete="off" <?= $is_locked ? 'disabled' : '' ?>>
                    <!-- Error Message -->
                    <?php if (isset($errors['ei_employment_date'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= $errors['ei_employment_date'] ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Step 2 -->
    <div class="step-form step2">
        <h2>Education</h2>
        <div class="row">
            <?php
            foreach (EducationLevel::cases() as $key => $val): ?>
                <h3><?= $val->value ?></h3>
                <input type="hidden" name="e_id[]"
                    value="<?= isset($form['e_id'][$key]) ? esc($form['e_id'][$key]) : '' ?>">
                <input type="hidden" name="e_level[]" value="<?= $val->value ?>">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <!-- School/Address -->
                        <label class="form-label">School/Address</label>
                        <input type="text" name="e_school_address[]" class="form-control mt-1 block w-full"
                            value="<?= isset($form['e_school_address'][$key]) ? esc($form['e_school_address'][$key]) : '' ?>"
                            <?= $is_locked ? 'disabled' : '' ?> />

                        <!-- Error Message -->
                        <?php if (isset($errors["e_school_address.$key"])): ?>
                            <div class="invalid-feedback d-block">
                                <?= $errors["e_school_address.$key"] ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6 mb-4">
                        <!-- Year Graduated -->
                        <label class="form-label">Year Graduated</label>
                        <input type="text" name="e_year_graduated[]" class="form-control mt-1 block w-full"
                            value="<?= isset($form['e_year_graduated'][$key]) ? esc($form['e_year_graduated'][$key]) : '' ?>"
                            <?= $is_locked ? 'disabled' : '' ?> />

                        <!-- Error Message -->
                        <?php if (isset($errors["e_year_graduated.$key"])): ?>
                            <div class="invalid-feedback d-block">
                                <?= $errors["e_year_graduated.$key"] ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php
                    if (
                        ($val->name === EducationLevel::UNDERGRADUATE->name)
                        || ($val->name === EducationLevel::GRADUATE->name)
                        || ($val->name === EducationLevel::POSTGRADUATE->name)
                    ): ?>
                        <div class="col-md-4 mb-4">
                            <!-- Degree -->
                            <label class="form-label">Degree</label>
                            <input type="text" name="e_degree[]" class="form-control mt-1 block w-full"
                                value="<?= isset($form['e_degree'][$key]) ? esc($form['e_degree'][$key]) : '' ?>" <?= $is_locked ? 'disabled' : '' ?> />

                            <!-- Error Message -->
                            <?php if (isset($errors["e_degree.$key"])): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $errors["e_degree.$key"] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-4 mb-4">
                            <!-- Major/Minor -->
                            <label class="form-label">Major/Minor</label>
                            <input type="text" name="e_major_minor[]" class="form-control mt-1 block w-full"
                                value="<?= isset($form['e_major_minor'][$key]) ? esc($form['e_major_minor'][$key]) : '' ?>"
                                <?= $is_locked ? 'disabled' : '' ?> />

                            <!-- Error Message -->
                            <?php if (isset($errors["e_major_minor.$key"])): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $errors["e_major_minor.$key"] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php else: ?>
                        <input type="hidden" name="e_degree[]" class="form-control mt-1 block w-full" />
                        <input type="hidden" name="e_major_minor[]" class="form-control mt-1 block w-full" />

                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
    <!-- Step 3 -->
    <div class="step-form step3">
        <h2>Dependents/Beneficiaries</h2>

        <div class="row">
            <div id="beneficiariesContainer">
                <?php
                $beneficiaries = $form['d_name'] ?? [''];
                foreach ($beneficiaries as $index => $beneficiary):
                    ?>
                    <input type="hidden" name="d_id[]"
                        value="<?= isset($form['d_id'][$index]) ? esc($form['d_id'][$index]) : '' ?>">
                    <div class="beneficiary-row row">
                        <div class="col-md-4 mb-4">
                            <!-- Name -->
                            <label class="form-label">Name</label>
                            <input type="text" name="d_name[]" class="form-control mt-1 block w-full"
                                value="<?= isset($form['d_name'][$index]) ? esc($form['d_name'][$index]) : '' ?>"
                                <?= $is_locked ? 'disabled' : '' ?> />
                            <!-- Error Message -->
                            <?php if (isset($errors["d_name.$index"])): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $errors["d_name.$index"] ?>
                                </div>
                            <?php endif; ?>

                        </div>
                        <div class="col-md-4 mb-4">
                            <!-- Date of Birth -->
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="d_birth[]" class="form-control mt-1 block w-full"
                                value="<?= isset($form['d_birth'][$index]) ? esc($form['d_birth'][$index]) : '' ?>"
                                <?= $is_locked ? 'disabled' : '' ?> />
                            <!-- Error Message -->
                            <?php if (isset($errors["d_birth.$index"]) && $errors["d_birth.$index"]): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $errors["d_birth.$index"] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-3 mb-4">
                            <!-- Relationship to Employee -->
                            <label class="form-label">Relationship to Employee</label>
                            <input type="text" name="d_relationship[]" class="form-control mt-1 block w-full"
                                value="<?= isset($form['d_relationship'][$index]) ? esc($form['d_relationship'][$index]) : '' ?>"
                                <?= $is_locked ? 'disabled' : '' ?> />
                            <!-- Error Message -->
                            <?php if (isset($errors["d_relationship.$index"]) && $errors["d_relationship.$index"]): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $errors["d_relationship.$index"] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if (!$is_locked): ?>
                            <div class="col-md-1 d-flex align-items-center">
                                <button type="button" class="btn btn-danger remove-beneficiary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-trash m-0">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 7l16 0" />
                                        <path d="M10 11l0 6" />
                                        <path d="M14 11l0 6" />
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                    </svg>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if (!$is_locked): ?>
                <div class="d-flex justify-content-between">
                    <!-- Add Button -->
                    <button type="button" id="addBeneficiary" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-plus m-0">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                    </button>
                </div>
            <?php endif; ?>
        </div>
        <hr>

        <h2>Previous Employement History</h2>
        <div class="row">
            <div id="employmentContainer">
                <!-- Employment Row Template -->
                <?php
                $employments = $form['eh_name'] ?? [''];
                foreach ($employments as $index => $employment):
                    ?>
                    <input type="hidden" name="eh_id[]"
                        value="<?= isset($form['eh_id'][$index]) ? esc($form['eh_id'][$index]) : '' ?>">
                    <div class="employment-row row">
                        <div class="col-md-4 mb-4">
                            <!-- Institution/Company -->
                            <label class="form-label">Institution/Company</label>
                            <input type="text" name="eh_name[]" class="form-control mt-1 block w-full"
                                value="<?= isset($form['eh_name'][$index]) ? esc($form['eh_name'][$index]) : '' ?>"
                                <?= $is_locked ? 'disabled' : '' ?> />
                            <!-- Error Message -->
                            <?php if (isset($errors["eh_name.$index"]) && $errors["eh_name.$index"]): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $errors["eh_name.$index"] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-3 mb-4">
                            <!-- Position -->
                            <label class="form-label">Position</label>
                            <input type="text" name="eh_position[]" class="form-control mt-1 block w-full"
                                value="<?= isset($form['eh_position'][$index]) ? esc($form['eh_position'][$index]) : '' ?>"
                                <?= $is_locked ? 'disabled' : '' ?> />
                            <!-- Error Message -->
                            <?php if (isset($errors["eh_position.$index"]) && $errors["eh_position.$index"]): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $errors["eh_position.$index"] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-4 row">
                            <!-- Inclusive Years -->
                            <label class="form-label">Inclusive Years</label>
                            <div class="col-md-6 col-sm-12 mb-4">
                                <!-- From -->
                                <input type="text" name="eh_year_from[]" class="form-control block w-full"
                                    placeholder="From"
                                    value="<?= isset($form['eh_year_from'][$index]) ? esc($form['eh_year_from'][$index]) : '' ?>"
                                    <?= $is_locked ? 'disabled' : '' ?> />
                                <!-- Error Message -->
                                <?php if (isset($errors["eh_year_from.$index"]) && $errors["eh_year_from.$index"]): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= $errors["eh_year_from.$index"] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-4">
                                <!-- To -->
                                <input type="text" name="eh_year_to[]" class="form-control block w-full" placeholder="To"
                                    value="<?= isset($form['eh_year_to'][$index]) ? esc($form['eh_year_to'][$index]) : '' ?>"
                                    <?= $is_locked ? 'disabled' : '' ?> />
                                <!-- Error Message -->
                                <?php if (isset($errors["eh_year_to.$index"]) && $errors["eh_year_to.$index"]): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= $errors["eh_year_to.$index"] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if (!$is_locked): ?>
                            <div class="col-md-1 d-flex align-items-center">
                                <!-- Remove button -->
                                <button type="button" class="btn btn-danger remove-employment" disabled>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-trash m-0">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 7l16 0" />
                                        <path d="M10 11l0 6" />
                                        <path d="M14 11l0 6" />
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                    </svg>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if (!$is_locked): ?>
                <div class="d-flex justify-content-between">
                    <!-- Add button -->
                    <button type="button" id="addEmployment" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-plus m-0">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                    </button>
                </div>
            <?php endif; ?>
        </div>
        <hr>

        <h2>Affiliation in Professional Organization</h2>
        <div class="row">
            <div id="affiliationProContainer">
                <?php
                $professionals = $form['a_p_type'] ?? [''];
                foreach ($professionals as $index => $professional): ?>
                    <input type="hidden" name="a_p_id[]"
                        value="<?= isset($form['a_p_id'][$index]) ? esc($form['a_p_id'][$index]) : '' ?>">
                    <div class="affiliation-pro-row row">
                        <input type="hidden" name="a_p_type[]" value="<?= AffiliationType::PROFESSIONAL->value ?>">
                        <div class="col-md-6 mb-4">
                            <!-- Name of Organization -->
                            <label class="form-label">Name of Organization</label>
                            <input type="text" name="a_p_name[]" class="form-control mt-1 block w-full"
                                value="<?= isset($form['a_p_name'][$index]) ? esc($form['a_p_name'][$index]) : '' ?>"
                                <?= $is_locked ? 'disabled' : '' ?> />
                            <!-- Error Message -->
                            <?php if (isset($errors["a_p_name.$index"]) && $errors["a_p_name.$index"]): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $errors["a_p_name.$index"] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-5 mb-4">
                            <!-- Position -->
                            <label class="form-label">Position</label>
                            <input type="text" name="a_p_position[]" class="form-control mt-1 block w-full"
                                value="<?= isset($form['a_p_position'][$index]) ? esc($form['a_p_position'][$index]) : '' ?>"
                                <?= $is_locked ? 'disabled' : '' ?> />
                            <!-- Error Message -->
                            <?php if (isset($errors["a_p_position.$index"]) && $errors["a_p_position.$index"]): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $errors["a_p_position.$index"] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if (!$is_locked): ?>
                            <div class="col-md-1 d-flex align-items-center">
                                <!-- Remove button -->
                                <button type="button" class="btn btn-danger remove-affiliation-pro" disabled>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-trash m-0">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 7l16 0" />
                                        <path d="M10 11l0 6" />
                                        <path d="M14 11l0 6" />
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                    </svg>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if (!$is_locked): ?>
                <div class="d-flex justify-content-between">
                    <!-- Add button -->
                    <button type="button" id="addAffiliationPro" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-plus m-0">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                    </button>
                </div>
            <?php endif; ?>
        </div>
        <hr>

        <h2>Affiliation in Socio-Civic Organization</h2>
        <div class="row">
            <div id="affiliationSocioContainer">
                <?php
                $socios = $form['a_s_type'] ?? [''];
                foreach ($socios as $index => $socio): ?>
                    <input type="hidden" name="a_s_id[]"
                        value="<?= isset($form['a_s_id'][$index]) ? esc($form['a_s_id'][$index]) : '' ?>">
                    <div class="affiliation-socio-row row">
                        <input type="hidden" name="a_s_type[]" value="<?= AffiliationType::SOCIOCIVIC->value ?>">
                        <div class="col-md-6 mb-4">
                            <!-- Name of Organization -->
                            <label class="form-label">Name of Organization</label>
                            <input type="text" name="a_s_name[]" class="form-control mt-1 block w-full"
                                value="<?= isset($form['a_s_name'][$index]) ? esc($form['a_s_name'][$index]) : '' ?>"
                                <?= $is_locked ? 'disabled' : '' ?> />
                            <!-- Error Message -->
                            <?php if (isset($errors["a_s_name.$index"]) && $errors["a_s_name.$index"]): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $errors["a_s_name.$index"] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-5 mb-4">
                            <!-- Position -->
                            <label class="form-label">Position</label>
                            <input type="text" name="a_s_position[]" class="form-control mt-1 block w-full"
                                value="<?= isset($form['a_s_position'][$index]) ? esc($form['a_s_position'][$index]) : '' ?>"
                                <?= $is_locked ? 'disabled' : '' ?> />
                            <!-- Error Message -->
                            <?php if (isset($errors["a_s_position.$index"]) && $errors["a_s_position.$index"]): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $errors["a_s_position.$index"] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if (!$is_locked): ?>
                            <div class="col-md-1 d-flex align-items-center">
                                <!-- Remove button -->
                                <button type="button" class="btn btn-danger remove-affiliation-socio" disabled>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-trash m-0">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 7l16 0" />
                                        <path d="M10 11l0 6" />
                                        <path d="M14 11l0 6" />
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                    </svg>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if (!$is_locked): ?>
                <div class="d-flex justify-content-between">
                    <!-- Add button -->
                    <button type="button" id="addAffiliationSocio" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-plus m-0">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- Step 4 -->
    <div class="step-form step4">
        <h2>Licensure/Government Exam Passed</h2>
        <input type="hidden" name="l_id" value="<?= old('l_id') ?>">
        <div class="row">
            <div class="col-md-4 mb-4">
                <!-- License -->
                <label class="form-label">License</label>
                <input type="text" name="l_license" class="form-control mt-1 block w-full"
                    value="<?= old('l_license') ?>" <?= $is_locked ? 'disabled' : '' ?> />
                <!-- Error Message -->
                <?php if (isset($errors["l_license"]) && $errors["l_license"]): ?>
                    <div class="invalid-feedback d-block">
                        <?= $errors["l_license"] ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-4 mb-4">
                <!-- Year Taken -->
                <label class="form-label">Year Taken</label>
                <input type="text" name="l_year" class="form-control mt-1 block w-full" value="<?= old('l_year') ?>"
                    <?= $is_locked ? 'disabled' : '' ?> />
                <!-- Error Message -->
                <?php if (isset($errors["l_year"]) && $errors["l_year"]): ?>
                    <div class="invalid-feedback d-block">
                        <?= $errors["l_year"] ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-4 mb-4">
                <!-- Rating -->
                <label class="form-label">Rating</label>
                <input type="text" name="l_rating" class="form-control mt-1 block w-full" value="<?= old('l_rating') ?>"
                    <?= $is_locked ? 'disabled' : '' ?> />
                <!-- Error Message -->
                <?php if (isset($errors["l_rating"]) && $errors["l_rating"]): ?>
                    <div class="invalid-feedback d-block">
                        <?= $errors["l_rating"] ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="col-md-12 mb-4">
                <!-- License No. -->
                <label class="form-label">License No.</label>
                <input type="text" name="l_license_no" class="form-control mt-1 block w-full"
                    value="<?= old('l_license_no') ?>" <?= $is_locked ? 'disabled' : '' ?> />
                <!-- Error Message -->
                <?php if (isset($errors["l_license_no"]) && $errors["l_license_no"]): ?>
                    <div class="invalid-feedback d-block">
                        <?= $errors["l_license_no"] ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <hr>
        <!-- Past Position(s) held in LCCT -->
        <h2>Past Position(s) held in LCCT</h2>
        <div class="row">
            <div id="pastPositionContainer">
                <?php
                $pasts = $form['pp_is_current'] ?? [''];
                foreach ($pasts as $index => $past): ?>
                    <input type="hidden" name="pp_id[]"
                        value="<?= isset($form['pp_id'][$index]) ? esc($form['pp_id'][$index]) : '' ?>">
                    <div class="past-position-row row">
                        <input type="hidden" name="pp_is_current[]" value="0">
                        <div class="col-md-6 mb-4">
                            <!-- Position -->
                            <label class="form-label">Position</label>
                            <input type="text" name="pp_position[]" class="form-control mt-1 block w-full"
                                value="<?= isset($form['pp_position'][$index]) ? esc($form['pp_position'][$index]) : '' ?>"
                                <?= $is_locked ? 'disabled' : '' ?> />
                            <!-- Error Message -->
                            <?php if (isset($errors["pp_position.$index"]) && $errors["pp_position.$index"]): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $errors["pp_position.$index"] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-5 row mb-4">
                            <label class="form-label">Inclusive Year</label>
                            <div class="col-md-6 col-sm-12">
                                <!-- Year From -->
                                <input type="text" name="pp_year_from[]" class="form-control mt-1 block w-full"
                                    placeholder="From"
                                    value="<?= isset($form['pp_year_from'][$index]) ? esc($form['pp_year_from'][$index]) : '' ?>"
                                    <?= $is_locked ? 'disabled' : '' ?> />
                                <!-- Error Message -->
                                <?php if (isset($errors["pp_year_from.$index"]) && $errors["pp_year_from.$index"]): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= $errors["pp_year_from.$index"] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <!-- Year To -->
                                <input type="text" name="pp_year_to[]" class="form-control mt-1 block w-full"
                                    placeholder="To"
                                    value="<?= isset($form['pp_year_to'][$index]) ? esc($form['pp_year_to'][$index]) : '' ?>"
                                    <?= $is_locked ? 'disabled' : '' ?> />
                                <!-- Error Message -->
                                <?php if (isset($errors["pp_year_to.$index"]) && $errors["pp_year_to.$index"]): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= $errors["pp_year_to.$index"] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if (!$is_locked): ?>
                            <div class="col-md-1 d-flex align-items-center">
                                <!-- Remove button -->
                                <button type="button" class="btn btn-danger remove-past-position" disabled>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-trash m-0">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 7l16 0" />
                                        <path d="M10 11l0 6" />
                                        <path d="M14 11l0 6" />
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                    </svg>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if (!$is_locked): ?>
                <div class="d-flex justify-content-between">
                    <!-- Add button -->
                    <button type="button" id="addPastPosition" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-plus m-0">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                    </button>
                </div>
            <?php endif; ?>
        </div>
        <hr>

        <!-- Current Position(s) -->
        <h2>Current Position(s)</h2>
        <div class="row">
            <div id="currentPositionContainer">
                <?php
                $currents = $form['cp_is_current'] ?? [''];
                foreach ($currents as $index => $current): ?>
                    <input type="hidden" name="cp_id[]"
                        value="<?= isset($form['cp_id'][$index]) ? esc($form['cp_id'][$index]) : '' ?>">
                    <div class="current-position-row row">
                        <input type="hidden" name="cp_is_current[]" value="1">
                        <div class="col-md-6 mb-4">
                            <!-- Position -->
                            <label class="form-label">Position</label>
                            <input type="text" name="cp_position[]" class="form-control mt-1 block w-full"
                                value="<?= isset($form['cp_position'][$index]) ? esc($form['cp_position'][$index]) : '' ?>"
                                <?= $is_locked ? 'disabled' : '' ?> />
                            <!-- Error Message -->
                            <?php if (isset($errors["cp_position.$index"]) && $errors["cp_position.$index"]): ?>
                                <div class="invalid-feedback d-block">
                                    <?= $errors["cp_position.$index"] ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-5 row mb-4">
                            <label class="form-label">Inclusive Year</label>
                            <div class="col-md-6 col-sm-12">
                                <!-- Year From -->
                                <input type="text" name="cp_year_from[]" class="form-control mt-1 block w-full"
                                    placeholder="From"
                                    value="<?= isset($form['cp_year_from'][$index]) ? esc($form['cp_year_from'][$index]) : '' ?>"
                                    <?= $is_locked ? 'disabled' : '' ?> />
                                <!-- Error Message -->
                                <?php if (isset($errors["cp_year_from.$index"]) && $errors["cp_year_from.$index"]): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= $errors["cp_year_from.$index"] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6 col-sm-12 mb-4">
                                <!-- Year To -->
                                <input type="text" name="cp_year_to[]" class="form-control mt-1 block w-full"
                                    placeholder="To"
                                    value="<?= isset($form['cp_year_to'][$index]) ? esc($form['cp_year_to'][$index]) : '' ?>"
                                    <?= $is_locked ? 'disabled' : '' ?> />
                                <!-- Error Message -->
                                <?php if (isset($errors["cp_year_to.$index"]) && $errors["cp_year_to.$index"]): ?>
                                    <div class="invalid-feedback d-block">
                                        <?= $errors["cp_year_to.$index"] ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if (!$is_locked): ?>
                            <div class="col-md-1 d-flex align-items-center">
                                <!-- Remove button -->
                                <button type="button" class="btn btn-danger remove-current-position" disabled>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="icon icon-tabler icons-tabler-outline icon-tabler-trash m-0">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M4 7l16 0" />
                                        <path d="M10 11l0 6" />
                                        <path d="M14 11l0 6" />
                                        <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                        <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                    </svg>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if (!$is_locked): ?>
                <div class="d-flex justify-content-between">
                    <!-- Add button -->
                    <button type="button" id="addCurrentPosition" class="btn btn-primary">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-plus m-0">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
    const affiliationPro = '<?= AffiliationType::PROFESSIONAL->value?>';
    const affiliationSocio = '<?= AffiliationType::SOCIOCIVIC->value?>';
</script>