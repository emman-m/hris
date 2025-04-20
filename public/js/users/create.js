$(function() {
    $('#role').on('change', function() {
        employeeIdVisibility($(this).val());
    });

    employeeIdVisibility($('#role').val());

    function employeeIdVisibility(role) {
        if (role === employeeRole) {
            $('.employee_id_container').show();
        } else {
            $('.employee_id_container').hide();
        }
    }
});