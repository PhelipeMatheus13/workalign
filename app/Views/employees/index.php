<?php
$pageTitle = "Employees";
$styles = <<<HTML
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
<style>
    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        overflow: hidden;
        background: #f6f9fb;
    }

    .container-fluid, .row {
        width: 100%;
        margin: 0;
        padding: 0;
    }

    .col-md-9 {
        height: calc(100vh - 56px);
        padding: 0;
        display: flex;
        flex-direction: column;
        overflow-y: auto;
        padding: 30px;
    }

    .create-employee-btn-container {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 20px;
    }

    .btn-create {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
    }

    .btn-view {
        background-color: #17a2b8;
        border-color: #17a2b8;
        color: white;
    }

    .btn-delete {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
    }

    .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.875rem;
        border-radius: 4px;
    }

    .employees-section {
        margin-top: 40px;
    }

    .section-title {
        margin-bottom: 20px;
        color: #343a40;
        font-size: 1.5rem;
        font-weight: 600;
        text-align: center;
    }

    .table-container {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        padding: 25px;
        border: 1px solid #e9ecef;
    }

    .dataTables_wrapper {
        margin-top: 15px;
    }

    table.dataTable {
        border-collapse: collapse !important;
    }

    table.dataTable thead th {
        border-bottom: 2px solid #dee2e6;
        color: #495057;
        font-weight: 600;
    }

    table.dataTable tbody td {
        border-top: 1px solid #e9ecef;
        vertical-align: middle;
    }

    .table-actions {
        display: flex;
        gap: 5px;
        justify-content: center;
    }

    .loading-state, .empty-state, .error-state {
        text-align: center;
        place-items: center;
        padding: 40px 20px;
        color: #6c757d;
    }

    .empty-state i, .error-state i {
        font-size: 3rem;
        color: #6c757d;
        margin-bottom: 1rem;
        display: block;
    }

    .error-state i {
        color: #dc3545;
    }

    .error-state div {
        margin-bottom: 1rem;
        font-size: 1.1em;
        color: #dc3545;
    }

    #employeesTable tbody td[colspan="6"] {
        padding: 0 !important;
        border: none !important;
        text-align: center;
    }

    .loading-spinner {
        width: 40px;
        height: 40px;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        animation: spin 1s linear infinite;
        margin: 0 auto 20px;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .retry-btn {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
    }
</style>
HTML;

$scripts = <<<HTML
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
HTML;

$content = <<<HTML
<!-- Btn create a new employee -->
<div class="create-employee-btn-container">
    <a href="employees/create">
        <button type="button" class="btn btn-primary btn-sm btn-create">
            <i class="fas fa-plus"></i> New Employee
        </button>
    </a>
</div>

<!-- List enployees -->
<div class="employees-section">
    <div class="table-container">
        <h3 class="section-title">Employees</h3>
        <table id="employeesTable" class="table table-hover" style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Department</th>
                    <th>Role</th>
                    <th>Salary</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Dynamic data -->
            </tbody>
        </table>
    </div>
</div>
HTML;

$inlineScript = <<<HTML
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const menuItems = document.querySelectorAll('.menu-item, #navbarMobileMenu .nav-link');
        menuItems.forEach(item => {
            item.classList.remove('active');
            if (item.getAttribute('data-menu') === 'employees') {
                item.classList.add('active');
            }
        });

        localStorage.setItem('activeMenu', 'employees');
    });

    $(document).ready(function () {
        const table = $('#employeesTable');
        const tbody = table.find('tbody');
        let dataTableInstance = null;

        function showLoadingState() {
            tbody.html(`
                <tr>
                    <td colspan="6">
                        <div class="loading-state">
                            <div class="loading-spinner"></div>
                            <div>Loading employees...</div>
                        </div>
                    </td>
                </tr>
            `);
        }

        function showEmptyState() {
            tbody.html(`
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <i class="fas fa-users"></i>
                            <div>No employees registered in the database.</div>
                        </div>
                    </td>
                </tr>
            `);
        }

        function showErrorState(message) {
            tbody.html(`
                <tr>
                    <td colspan="6">
                        <div class="error-state">
                            <i class="fas fa-exclamation-circle"></i>
                            <div>\${message}</div>
                            <button class="btn btn-primary retry-btn">Try Again</button>
                        </div>
                    </td>
                </tr>
            `);
        }

        function clearTableBody() {
            tbody.empty();
        }

       
        function loadEmployees() {
            showLoadingState();

            $.ajax({
                url: 'employees/list',
                type: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.data && response.data.length > 0) {
                        renderTable(response.data);
                    } else {
                        showEmptyState();
                        if (dataTableInstance) {
                            dataTableInstance.destroy();
                            dataTableInstance = null;
                        }
                    }
                },
                error: function (xhr, status, error) {
                    let message = "An error occurred while loading employees.";
                    if (xhr.responseJSON && xhr.responseJSON.error) {
                        message = xhr.responseJSON.error;
                    }
                    showErrorState(message);
                    if (dataTableInstance) {
                        dataTableInstance.destroy();
                        dataTableInstance = null;
                    }
                }
            });
        }

        // Renders the table with dynamic data.
        function renderTable(employees) {
            if (dataTableInstance) {
                dataTableInstance.destroy();
                dataTableInstance = null;
            }

            clearTableBody();
            populateTable(employees);
            initializeDataTable();
        }

        function populateTable(employees) {
            employees.forEach(emp => {
                const row = `
                    <tr>
                        <td>\${emp.name}</td>
                        <td>\${emp.age}</td>
                        <td>\${emp.department}</td>
                        <td>\${emp.role}</td>
                        <td>\${emp.salary}</td>
                        <td class="text-center">
                            <div class="table-actions">
                                <button class="btn btn-sm btn-view" data-id="\${emp.id}" title="View">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-delete" data-id="\${emp.id}" title="Delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
                tbody.append(row);
            });
        }

        function initializeDataTable() {
            dataTableInstance = table.DataTable({
                language: {
                    search: "Search:",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                },
                columnDefs: [
                    { orderable: false, targets: 5 }
                ]
            });
        }

        function deleteEmployee(employeeId) {
            if (confirm('Are you sure you want to delete this employee? This action cannot be undone.')) {
                const deleteBtn = $(`.btn-delete[data-id="\${employeeId}"]`);
                const originalHtml = deleteBtn.html();
                deleteBtn.html('<i class="fas fa-spinner fa-spin"></i>');
                deleteBtn.prop('disabled', true);

                $.ajax({
                    url: 'employees/delete',
                    type: 'DELETE',
                    contentType: 'application/json',
                    data: JSON.stringify({ id: employeeId }),
                    dataType: 'json',
                    success: function (response) {
                        if (response.success) {
                            loadEmployees();
                            showNotification('Employee deleted successfully!', 'success');
                        } else {
                            showNotification('Error: ' + response.error, 'error');
                        }
                    },
                    error: function (xhr, status, error) {
                        let message = "An error occurred while deleting the employee.";
                        if (xhr.responseJSON && xhr.responseJSON.error) {
                            message = xhr.responseJSON.error;
                        }
                        showNotification(message, 'error');
                    },
                    complete: function () {
                        deleteBtn.html(originalHtml);
                        deleteBtn.prop('disabled', false);
                    }
                });
            }
        }

        function showNotification(message, type = 'info') {
            if (type === 'error') {
                alert('Error: ' + message);
            } else {
                alert(message);
            }
        }

        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();
            const employeeId = $(this).data('id');
            deleteEmployee(employeeId);
        });

        $(document).on('click', '.btn-view', function (e) {
            e.preventDefault();
            const employeeId = $(this).data('id');
            window.location.href = `employees/show?id=\${employeeId}`;
        });

        $(document).on('click', '.retry-btn', function () {
            loadEmployees();
        });

        loadEmployees();
    });
</script>
HTML;

include __DIR__ .'/../layouts/main.php';