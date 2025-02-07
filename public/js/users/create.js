$(function() {

    // If the role is employee display the department
    $('#role').on('change', function() {
        departmentDisplay($(this).val());
    })

    const departmentDisplay = (role) => {
        if (role === employeeRole) {
            $('.department-container').show();
        } else {
            $('.department-container').hide();
        }
    };

    departmentDisplay($('#role').val());
});