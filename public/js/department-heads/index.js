document.addEventListener('DOMContentLoaded', function() {
    // Toast configuration
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
        showCloseButton: true,
        customClass: {
            popup: 'alert alert-success',
        },
        didOpen: (toast) => {
            toast.onmouseenter = Swal.stopTimer;
            toast.onmouseleave = Swal.resumeTimer;
        }
    });

    // Initialize variables
    let searchTimeout;
    const assignModal = new bootstrap.Modal(document.getElementById('assign-modal'));
    const employeeSearch = document.getElementById('employee-search');
    const departmentValue = document.getElementById('department-value');
    const employeeResults = document.getElementById('employee-results');

    // Handle assign head button clicks
    document.querySelectorAll('.assign-head').forEach(button => {
        button.addEventListener('click', function() {
            const department = this.dataset.department;
            departmentValue.value = department;
            assignModal.show();
        });
    });

    // Handle remove head button clicks
    document.querySelectorAll('.remove-head').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.userId;
            Swal.fire({
                title: 'Remove Department Head',
                text: 'Are you sure you want to remove this department head?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, remove it',
                cancelButtonText: 'No, cancel',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6'
            }).then((result) => {
                if (result.isConfirmed) {
                    removeDepartmentHead(userId);
                }
            });
        });
    });

    // Handle employee search
    employeeSearch.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const search = this.value;
            const department = departmentValue.value;
            searchEmployees(search, department);
        }, 300);
    });

    // Function to search employees
    function searchEmployees(search, department) {
        $.ajax({
            url: `${baseUrl}hris/department-heads/search-employees`,
            method: 'GET',
            data: {
                search: search,
                department: department
            },
            success: function(data) {
                employeeResults.innerHTML = '';
                data.forEach(employee => {
                    const row = document.createElement('tr');
                    row.innerHTML = `
                        <td>${employee.name}</td>
                        <td>${employee.email}</td>
                        <td>${employee.employee_id}</td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm select-employee" 
                                    data-user-id="${employee.user_id}">
                                Select
                            </button>
                        </td>
                    `;
                    employeeResults.appendChild(row);
                });

                // Add event listeners to select buttons
                document.querySelectorAll('.select-employee').forEach(button => {
                    button.addEventListener('click', function() {
                        const userId = this.dataset.userId;
                        assignDepartmentHead(userId, department);
                    });
                });
            },
            error: function() {
                Toast.fire({
                    icon: "error",
                    text: "Failed to search employees"
                });
            }
        });
    }

    // Function to assign department head
    function assignDepartmentHead(userId, department) {
        $.ajax({
            url: `${baseUrl}hris/department-heads/assign`,
            method: 'POST',
            data: {
                user_id: userId,
                department: department
            },
            success: function(data) {
                if (data.success) {
                    Toast.fire({
                        icon: "success",
                        text: data.message
                    });
                    assignModal.hide();
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    Toast.fire({
                        icon: "error",
                        text: data.message
                    });
                }
            },
            error: function() {
                Toast.fire({
                    icon: "error",
                    text: "Failed to assign department head"
                });
            }
        });
    }

    // Function to remove department head
    function removeDepartmentHead(userId) {
        $.ajax({
            url: `${baseUrl}hris/department-heads/remove`,
            method: 'POST',
            data: {
                user_id: userId
            },
            success: function(data) {
                if (data.success) {
                    Toast.fire({
                        icon: "success",
                        text: data.message
                    });
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                } else {
                    Toast.fire({
                        icon: "error",
                        text: data.message
                    });
                }
            },
            error: function() {
                Toast.fire({
                    icon: "error",
                    text: "Failed to remove department head"
                });
            }
        });
    }
}); 