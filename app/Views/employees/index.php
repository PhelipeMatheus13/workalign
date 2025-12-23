<?php
$pageTitle = "Employees";
$styles = <<<'HTML'
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

$scripts = <<<'HTML'
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
HTML;

$content = <<<'HTML'
<!-- Btn create a new employee -->
<div class="create-employee-btn-container">
    <a href="employees/create">
        <button type="button" class="btn btn-primary btn-sm btn-create">
            <i class="fas fa-plus"></i> New Employee
        </button>
    </a>
</div>

<!-- List employees -->
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

$inlineScript = <<<'HTML'
<script>
    // ============================================
    // INITIALIZATION
    // ============================================
    
    // Global variables
    let dataTableInstance = null;
    
    document.addEventListener('DOMContentLoaded', function () {
        console.log('Employees Page');
        
        // Initialize DataTable
        initializeDataTable();
        
        // Load employees
        loadEmployees();
        
        // Attach event listeners
        attachEventListeners();
    });

    function attachEventListeners() {
        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();
            const employeeID = $(this).data('id');
            deleteEmployee(employeeID);
        });

        $(document).on('click', '.btn-view', function (e) {
            e.preventDefault();
            const employeeID = $(this).data('id');
            window.location.href = `employees/show?id=${employeeID}`;
        });

        $(document).on('click', '.retry-btn', function () {
            loadEmployees();
        });
    }

    // ============================================
    // UI STATE MANAGEMENT FUNCTIONS
    // ============================================

    function showLoadingState() {
        const tbody = $('#employeesTable tbody');
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
        const tbody = $('#employeesTable tbody');
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
        const tbody = $('#employeesTable tbody');
        tbody.html(`
            <tr>
                <td colspan="6">
                    <div class="error-state">
                        <i class="fas fa-exclamation-circle"></i>
                        <div>${escapeHtml(message)}</div>
                        <button class="btn btn-primary retry-btn">Try Again</button>
                    </div>
                </td>
            </tr>
        `);
    }

    // ============================================
    // API CALL FUNCTIONS (Standard Pattern)
    // ============================================

    function loadEmployees() {
        const FUNCTION_NAME = 'loadEmployees';
        const ENDPOINT = 'employees/list';
        const TIMEOUT_MS = 10000;
        
        console.log('[' + FUNCTION_NAME + '] Loading employees...');

        showLoadingState();

        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), TIMEOUT_MS);

        fetch(ENDPOINT, {
            method: 'GET',
            headers: { 'Content-Type': 'application/json' },
            signal: controller.signal
        })
        .then(function handleResponse(response) {
            clearTimeout(timeoutId);
            
            console.log(`[${FUNCTION_NAME}] Response received:`, {
                status: response.status,
                statusText: response.statusText,
                ok: response.ok
            });

            if (!response.ok) {
                return response.json()
                    .catch(function handleJsonError() {
                        console.error(`[${FUNCTION_NAME}] Response is not valid JSON.:`, {
                            status: response.status,
                            statusText: response.statusText
                        });
                        
                        throw {
                            type: 'HTTP_ERROR',
                            status: response.status,
                            message: response.statusText,
                            friendlyMessage: `Erro ${response.status}: ${response.statusText}`
                        };
                    })
                    .then(function handleErrorJson(errJson) {
                        console.error(`[${FUNCTION_NAME}] API Error:`, {
                            endpoint: ENDPOINT,
                            status: response.status,
                            error: errJson.error,
                            errorMessage: errJson.error_message,
                        });
                        
                        throw {
                            type: 'API_ERROR',
                            status: response.status,
                            error: errJson.error,
                            errorMessage: errJson.error_message,
                            friendlyMessage: errJson.friendly_message || `Erro: ${errJson.error}`
                        };
                    });
            }

            return response.json();
        })
        .then(function handleSuccessData(responseBody) {
            console.log(`[${FUNCTION_NAME}] Response body:`, {
                success: responseBody.success,
                hasData: !!responseBody.data,
                dataLength: responseBody.data ? responseBody.data.length : 0
            });

            if (!responseBody || !responseBody.success || !responseBody.data) {
                console.error(`[${FUNCTION_NAME}] Invalid response structure!`, responseBody);
                showErrorState(responseBody?.friendly_message || 'Invalid server response. Please try again.');
                return;
            }

            // Check if there are employees
            if (responseBody.data.length === 0) {
                console.log(`[${FUNCTION_NAME}] No employees found. Showing empty state.`);
                showEmptyState();
                if (dataTableInstance) {
                    dataTableInstance.destroy();
                    dataTableInstance = null;
                }
                return;
            }

            console.log(`[${FUNCTION_NAME}] Rendering table with ${responseBody.data.length} employees.`);
            renderTable(responseBody.data);
        })
        .catch(function handleFetchError(err) {
            clearTimeout(timeoutId);

            if (err && err.name === 'AbortError') {
                console.error(`[${FUNCTION_NAME}] Timeout after ${TIMEOUT_MS}ms`);
                showErrorState('Request timed out. Please try again.');
                return;
            }

            if (err.type && (err.type === 'HTTP_ERROR' || err.type === 'API_ERROR')) {
                console.error(`[${FUNCTION_NAME}] Error occurred | Status: ${err.status} | Type: ${err.type}`);
                showErrorState(err.friendlyMessage || 'Error loading employees.');
                return;
            }

            console.error(`[${FUNCTION_NAME}] Unexpected error loading employees:`, {
                name: err.name,
                message: err.message,
            });
            
            showErrorState('An unexpected error occurred. Please check your connection and try again.');
        })
        .finally(function() {
            clearTimeout(timeoutId);
            console.log('[' + FUNCTION_NAME + '] Completed');
        });
    }

    function deleteEmployee(employeeID) {
        const FUNCTION_NAME = 'deleteEmployee';
        const ENDPOINT = 'employees/delete';
        const TIMEOUT_MS = 10000;
        
        console.log(`[${FUNCTION_NAME}] Deleting employee ID: ${employeeID}`);

        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), TIMEOUT_MS);

        if (confirm('Are you sure you want to delete this employee? This action cannot be undone.')) {
            const deleteBtn = $(`.btn-delete[data-id="${employeeID}"] `);
            const originalHtml = deleteBtn.html();
            deleteBtn.html('<i class="fas fa-spinner fa-spin"></i>');
            deleteBtn.prop('disabled', true);

            fetch(ENDPOINT, {
                method: 'DELETE',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ id: employeeID }),
                signal: controller.signal
            })
            .then(function handleResponse(response) {
                clearTimeout(timeoutId);

                console.log(`[${FUNCTION_NAME}] Response received:`, {
                    status: response.status,
                    statusText: response.statusText,
                    ok: response.ok
                });

                if (!response.ok) {
                    return response.json()
                        .catch(function handleJsonError() {
                            console.error(`[${FUNCTION_NAME}] Response is not valid JSON:`, {
                                status: response.status,
                                statusText: response.statusText
                            });
                            
                            throw {
                                type: 'HTTP_ERROR',
                                status: response.status,
                                message: response.statusText,
                                friendlyMessage: 'Error ' + response.status + ': ' + response.statusText
                            };
                        })
                        .then(function handleErrorJson(errJson) {
                            console.error(`[${FUNCTION_NAME}] API Error:`, {
                                endpoint: ENDPOINT,
                                status: response.status,
                                error: errJson.error,
                                errorMessage: errJson.error_message,
                            });
                            
                            throw {
                                type: 'API_ERROR',
                                status: response.status,
                                error: errJson.error,
                                errorMessage: errJson.error_message,
                                friendlyMessage: errJson.friendly_message || `Erro: ${errJson.error}`
                            };
                        });
                }

                return response.json();
            })
            .then(function handleSuccessData(responseBody) {
                if (!responseBody || !responseBody.success) {
                    console.error(`[${FUNCTION_NAME}] Invalid response structure!`, responseBody);
                    alert('Error deleting employee: ' + (responseBody?.friendly_message || 'Invalid server response.'));
                    return;
                }

                alert('Employee deleted successfully.');
                console.log(`[${FUNCTION_NAME}] Employee deleted successfully. Reloading employees...`);
                return loadEmployees();
            })
            .catch(function handleFetchError(err) {
                clearTimeout(timeoutId);

                if (err && err.name === 'AbortError') {
                    console.error(`[${FUNCTION_NAME}] Timeout after ${TIMEOUT_MS}ms`);
                    alert('Request timed out. Please try again.');
                    return;
                }

                if (err.type && (err.type === 'HTTP_ERROR' || err.type === 'API_ERROR')) {
                    console.error(`[${FUNCTION_NAME}] Error occurred | Status: ${err.status} | Type: ${err.type}`);
                    alert(err.friendlyMessage || 'Error deleting employee.');
                    return;
                }

                console.error(`[${FUNCTION_NAME}] Unexpected error:`, {
                    name: err.name,
                    message: err.message,
                });

                alert('An unexpected error occurred. Please check your connection and try again.');
            })
            .finally(function() {
                deleteBtn.html(originalHtml);
                deleteBtn.prop('disabled', false);
                clearTimeout(timeoutId);
                console.log(`[${FUNCTION_NAME}] Completed`);
            });
        }
    }

    // ============================================
    // DATA MANAGEMENT FUNCTIONS
    // ============================================

    function initializeDataTable() {
        dataTableInstance = $('#employeesTable').DataTable({
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

    function renderTable(employees) {
        // Clear and destroy existing DataTable
        if (dataTableInstance) {
            dataTableInstance.destroy();
            dataTableInstance = null;
        }
        
        // Clear table body
        $('#employeesTable tbody').empty();
        
        // Populate table with data
        populateTable(employees);
        
        // Reinitialize DataTable
        initializeDataTable();
    }

    function populateTable(employees) {
        const tbody = $('#employeesTable tbody');
        employees.forEach(function(emp) {
            const row = `
                <tr>
                    <td>${escapeHtml(emp.name)}</td>
                    <td>${emp.age}</td>
                    <td>${escapeHtml(emp.department)}</td>
                    <td>${escapeHtml(emp.role)}</td>
                    <td>${emp.salary}</td>
                    <td class="text-center">
                        <div class="table-actions">
                            <button class="btn btn-sm btn-view" data-id="${emp.id}" title="View">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-delete" data-id="${emp.id}" title="Delete">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
            tbody.append(row);
        });
    }

    // ============================================
    // UTILITY FUNCTIONS
    // ============================================

    function escapeHtml(unsafe) {
        if (!unsafe) return '';
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
</script>
HTML;

include __DIR__ . '/../layouts/main.php';