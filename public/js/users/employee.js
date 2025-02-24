$(function () {
    $('#ei_status').on('change', function () {
        const status = $(this).val();
        spouseVisible(status);
    });
    const spouseVisible = (status) => {
        if (employeeStatus === status) {
            $('.spouse-div').show();
        } else {
            $('.spouse-div').hide();
        }
    }
    spouseVisible($('#ei_status').val());
    // Stepper Functionality
    (function stepperFunctionality() {
        let currentStep = 1;
        const totalSteps = $('.step-form').length; // Total number of steps

        const showStep = (step) => {
            $('.step-form').hide(); // Hide all steps
            $(`.step${step}`).show(); // Show the current step

            // Toggle back button visibility
            if (step === 1) {
                $('#back-form').css({ visibility: 'hidden', pointerEvents: 'none' });
            } else {
                $('#back-form').css({ visibility: 'visible', pointerEvents: 'auto' });
            }

            if (step < totalSteps) {
                $('#next-form').show();
            } else {
                $('#next-form').hide();
            }

            // Update active step indicators
            $('.step-item').removeClass('active');
            $(`.steps .step-item:nth-child(${step})`).addClass('active');
        };

        // Handle the "Next" button click
        $('#next-form').on('click', function () {
            if (currentStep < totalSteps) {
                currentStep++;
                showStep(currentStep);
            }
        });

        // Handle the "Back" button click
        $('#back-form').on('click', function () {
            if (currentStep > 1) {
                currentStep--;
                showStep(currentStep);
            }
        });

        // Initialize the form with Step 1
        showStep(currentStep);
    })();

    // Beneficiaries Functionality
    (function beneficiariesFunctionality() {
        const maxRows = 100;
        const minRows = 1;

        // Add beneficiary row
        $('#addBeneficiary').on('click', function () {
            const totalRows = $('.beneficiary-row').length;

            if (totalRows < maxRows) {
                // Clone the content of #affiliationProContainer

                // dependencies template
                const dependencies = `
                    <div class="beneficiary-row row">
                        <div class="col-md-4 mb-4">
                            <!-- Name -->
                            <label class="form-label">Name</label>
                            <input type="text" name="d_name[]" class="form-control mt-1 block w-full" />

                        </div>
                        <div class="col-md-4 mb-4">
                            <!-- Date of Birth -->
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="d_birth[]" class="form-control mt-1 block w-full"/>
                            
                        </div>
                        <div class="col-md-3 mb-4">
                            <!-- Relationship to Employee -->
                            <label class="form-label">Relationship to Employee</label>
                            <input type="text" name="d_relationship[]" class="form-control mt-1 block w-full"/>
                            
                        </div>
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
                    </div>
                `;
                $('#beneficiariesContainer').append(dependencies);
                updateBeneficiaryButtons();
            }
        });

        // Remove beneficiary row
        $(document).on('click', '.remove-beneficiary', function () {
            const totalRows = $('.beneficiary-row').length;

            if (totalRows > minRows) {
                $(this).closest('.beneficiary-row').remove();
                updateBeneficiaryButtons();
            }
        });

        // Update Add/Remove button states
        function updateBeneficiaryButtons() {
            const totalRows = $('.beneficiary-row').length;

            $('#addBeneficiary').prop('disabled', totalRows >= maxRows);
            $('.remove-beneficiary').prop('disabled', totalRows <= minRows);
        }

        // Initialize button states
        updateBeneficiaryButtons();
    })();

    // Employment History Functionality
    (function employmentHistoryFunctionality() {
        const maxRows = 100;
        const minRows = 1;

        // Add employment row
        $('#addEmployment').click(function () {
            const totalRows = $('.employment-row').length;

            if (totalRows < maxRows) {
                // Clone the content of #affiliationProContainer
                var newRow = `
                    <div class="employment-row row">
                        <div class="col-md-4 mb-4">
                            <!-- Institution/Company -->
                            <label class="form-label">Institution/Company</label>
                            <input type="text" name="eh_name[]" class="form-control mt-1 block w-full"/>
                            
                        </div>
                        <div class="col-md-3 mb-4">
                            <!-- Position -->
                            <label class="form-label">Position</label>
                            <input type="text" name="eh_position[]" class="form-control mt-1 block w-full"/>
                            <!-- Error Message -->
                        </div>
                        <div class="col-md-4 row">
                            <!-- Inclusive Years -->
                            <label class="form-label">Inclusive Years</label>
                            <div class="col-md-6 col-sm-12 mb-4">
                                <!-- From -->
                                <input type="text" name="eh_year_from[]" class="form-control block w-full"
                                    placeholder="From"/>
                                
                            </div>
                            <div class="col-md-6 col-sm-12 mb-4">
                                <!-- To -->
                                <input type="text" name="eh_year_to[]" class="form-control block w-full" placeholder="To"/>
                                
                            </div>
                        </div>
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
                    </div>
                `;

                $('#employmentContainer').append(newRow);
                updateEmploymentButtons();
            }
        });

        // Remove employment row
        $(document).on('click', '.remove-employment', function () {
            const totalRows = $('.employment-row').length;

            if (totalRows > minRows) {
                $(this).closest('.employment-row').remove();
                updateEmploymentButtons();
            }
        });

        // Update Add/Remove button states
        function updateEmploymentButtons() {
            const totalRows = $('.employment-row').length;

            $('#addEmployment').prop('disabled', totalRows >= maxRows);
            $('.remove-employment').prop('disabled', totalRows <= minRows);
        }

        // Initialize button states
        updateEmploymentButtons();
    })();

    // Affiliation in Professional Organization
    (function affiliationProFunctionality() {
        const maxRows = 100;
        const minRows = 1;

        // Add employment row
        $('#addAffiliationPro').on('click', function () {
            const totalRows = $('.affiliation-pro-row').length;

            if (totalRows < maxRows) {
                // Clone the content of #affiliationProContainer
                var newRow = `
                    <div class="affiliation-pro-row row">
                        <input type="hidden" name="a_p_type[]" value="${affiliationPro}">
                        <div class="col-md-6 mb-4">
                            <!-- Name of Organization -->
                            <label class="form-label">Name of Organization</label>
                            <input type="text" name="a_p_name[]" class="form-control mt-1 block w-full"/>
                            
                        </div>
                        <div class="col-md-5 mb-4">
                            <!-- Position -->
                            <label class="form-label">Position</label>
                            <input type="text" name="a_p_position[]" class="form-control mt-1 block w-full"/>
                            
                        </div>
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
                    </div>
                `;

                // Append the cloned row to the container where you want to keep the cloned rows
                $('#affiliationProContainer').append(newRow);
                updateAffiliationProButtons();
            }
        });

        // Remove Affiliation Pro row
        $(document).on('click', '.remove-affiliation-pro', function () {
            const totalRows = $('.affiliation-pro-row').length;

            if (totalRows > minRows) {
                $(this).closest('.affiliation-pro-row').remove();
                updateAffiliationProButtons();
            }
        });

        // Update Add/Remove button states
        function updateAffiliationProButtons() {
            const totalRows = $('.affiliation-pro-row').length;

            $('#addAffiliationPro').prop('disabled', totalRows >= maxRows);
            $('.remove-affiliation-pro').prop('disabled', totalRows <= minRows);
        }

        // Initialize button states
        updateAffiliationProButtons();
    })();

    // Affiliation in Socio Civic Organization
    (function affiliationSocioFunctionality() {
        const maxRows = 100;
        const minRows = 1;

        // Add row
        $('#addAffiliationSocio').on('click', function () {
            const totalRows = $('.affiliation-socio-row').length;

            if (totalRows < maxRows) {
                // Clone the content of #affiliationProContainer
                var newRow = `
                    <div class="affiliation-socio-row row">
                        <input type="hidden" name="a_s_type[]" value="${affiliationSocio}">
                        <div class="col-md-6 mb-4">
                            <!-- Name of Organization -->
                            <label class="form-label">Name of Organization</label>
                            <input type="text" name="a_s_name[]" class="form-control mt-1 block w-full"/>
                            
                        </div>
                        <div class="col-md-5 mb-4">
                            <!-- Position -->
                            <label class="form-label">Position</label>
                            <input type="text" name="a_s_position[]" class="form-control mt-1 block w-full"/>
                            
                        </div>
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
                    </div>
                `;

                // Append the cloned row to the container where you want to keep the cloned rows
                $('#affiliationSocioContainer').append(newRow);
                updateAffiliationSocioButtons();
            }
        });

        // Remove Affiliation Pro row
        $(document).on('click', '.remove-affiliation-socio', function () {
            const totalRows = $('.affiliation-socio-row').length;

            if (totalRows > minRows) {
                $(this).closest('.affiliation-socio-row').remove();
                updateAffiliationSocioButtons();
            }
        });

        // Update Add/Remove button states
        function updateAffiliationSocioButtons() {
            const totalRows = $('.affiliation-socio-row').length;

            $('#addAffiliationSocio').prop('disabled', totalRows >= maxRows);
            $('.remove-affiliation-socio').prop('disabled', totalRows <= minRows);
        }

        // Initialize button states
        updateAffiliationSocioButtons();
    })();

    // Past Position
    (function pastPositionFunctionality() {
        const maxRows = 100;
        const minRows = 1;

        // Add row
        $('#addPastPosition').on('click', function () {
            const totalRows = $('.past-position-row').length;

            if (totalRows < maxRows) {
                // Clone the content of #pastPositionContainer
                var newRow = `
                    <div class="past-position-row row">
                        <input type="hidden" name="pp_is_current[]" value="0">
                        <div class="col-md-6 mb-4">
                            <!-- Position -->
                            <label class="form-label">Position</label>
                            <input type="text" name="pp_position[]" class="form-control mt-1 block w-full"/>
                            
                        </div>
                        <div class="col-md-5 row mb-4">
                            <label class="form-label">Inclusive Year</label>
                            <div class="col-md-6 col-sm-12">
                                <!-- Year From -->
                                <input type="text" name="pp_year_from[]" class="form-control mt-1 block w-full"
                                    placeholder="From" />
                                
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <!-- Year To -->
                                <input type="text" name="pp_year_to[]" class="form-control mt-1 block w-full"
                                    placeholder="to"/>
                                
                            </div>
                        </div>
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
                    </div>
                `;

                // Append the cloned row to the container where you want to keep the cloned rows
                $('#pastPositionContainer').append(newRow);
                updatePastPositionButtons();
            }
        });

        // Remove Past Position row
        $(document).on('click', '.remove-past-position', function () {
            const totalRows = $('.past-position-row').length;

            if (totalRows > minRows) {
                $(this).closest('.past-position-row').remove();
                updatePastPositionButtons();
            }
        });

        // Update Add/Remove button states
        function updatePastPositionButtons() {
            const totalRows = $('.past-position-row').length;

            $('#addPastPosition').prop('disabled', totalRows >= maxRows);
            $('.remove-past-position').prop('disabled', totalRows <= minRows);
        }

        // Initialize button states
        updatePastPositionButtons();
    })();

    // Current Position
    (function currentPositionFunctionality() {
        const maxRows = 100;
        const minRows = 1;

        // Add row
        $('#addCurrentPosition').on('click', function () {
            const totalRows = $('.current-position-row').length;

            if (totalRows < maxRows) {
                // Clone the content of #currentPositionContainer
                var newRow = `
                    <div class="current-position-row row">
                        <input type="hidden" name="cp_is_current[]" value="1">
                        <div class="col-md-6 mb-4">
                            <!-- Position -->
                            <label class="form-label">Position</label>
                            <input type="text" name="cp_position[]" class="form-control mt-1 block w-full"/>
                            
                        </div>
                        <div class="col-md-5 row mb-4">
                            <label class="form-label">Inclusive Year</label>
                            <div class="col-md-6 col-sm-12">
                                <!-- Year From -->
                                <input type="text" name="cp_year_from[]" class="form-control mt-1 block w-full"
                                    placeholder="From"/>
                                
                            </div>
                            <div class="col-md-6 col-sm-12 mb-4">
                                <!-- Year To -->
                                <input type="text" name="cp_year_to[]" class="form-control mt-1 block w-full"
                                    placeholder="To"/>
                                
                            </div>
                        </div>
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
                    </div>
                `;

                // Append the cloned row to the container where you want to keep the cloned rows
                $('#currentPositionContainer').append(newRow);
                updateCurrentPositionButtons();
            }
        });

        // Remove Past Position row
        $(document).on('click', '.remove-current-position', function () {
            const totalRows = $('.current-position-row').length;

            if (totalRows > minRows) {
                $(this).closest('.current-position-row').remove();
                updateCurrentPositionButtons();
            }
        });

        // Update Add/Remove button states
        function updateCurrentPositionButtons() {
            const totalRows = $('.current-position-row').length;

            $('#addCurrentPosition').prop('disabled', totalRows >= maxRows);
            $('.remove-current-position').prop('disabled', totalRows <= minRows);
        }

        // Initialize button states
        updateCurrentPositionButtons();
    })();
});
