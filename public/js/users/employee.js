$(function () {
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

    // dependencies
    const dependencies = $('#beneficiariesContainer .beneficiary-row').prop('outerHTML');
    // Beneficiaries Functionality
    (function beneficiariesFunctionality() {
        const maxRows = 100;
        const minRows = 1;

        let index = $('.beneficiary-row').length;
        
        // Add beneficiary row
        $('#addBeneficiary').on('click', function () {
            const totalRows = $('.beneficiary-row').length;

            if (totalRows < maxRows) {
                // Clone the content of #affiliationProContainer
                
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
        const maxRows = 8; // Maximum number of employment entries
        const minRows = 1; // Minimum number of employment entries

        // Add employment row
        $('#addEmployment').click(function () {
            const totalRows = $('.employment-row').length;

            if (totalRows < maxRows) {
                // Clone the content of #affiliationProContainer
                var newRow = $('#employmentContainer .employment-row').first().clone();
                
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
        const maxRows = 3;
        const minRows = 1;

        // Add employment row
        $('#addAffiliationPro').on('click', function () {
            const totalRows = $('.affiliation-pro-row').length;

            if (totalRows < maxRows) {
                // Clone the content of #affiliationProContainer
                var newRow = $('#affiliationProContainer .affiliation-pro-row').first().clone();

                // Enable the remove button in the cloned row
                // newRow.find('.remove-affiliation-pro').removeAttr('disabled');

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

    // Affiliation in Professional Organization
    (function affiliationSocioFunctionality() {
        const maxRows = 3;
        const minRows = 1;

        // Add row
        $('#addAffiliationSocio').on('click', function () {
            const totalRows = $('.affiliation-socio-row').length;

            if (totalRows < maxRows) {
                // Clone the content of #affiliationProContainer
                var newRow = $('#affiliationSocioContainer .affiliation-socio-row').first().clone();

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
});
