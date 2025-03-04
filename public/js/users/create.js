$(function() {
    $('#role').on('change', function() {
        employeeIdVisibility($(this).val());
    });

    employeeIdVisibility($('#role').val());

    function employeeIdVisibility(role) {
        if (role === employeeRole) {
            console.log('employee');
            $('.employee_id_container').show();
        } else {
            console.log('not employee');
            $('.employee_id_container').hide();
        }
    }
});