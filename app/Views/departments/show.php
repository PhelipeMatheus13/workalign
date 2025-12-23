<?php
$pageTitle = "Departments";
$styles = <<<'HTML'
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
<style>
   html,
   body {
      height: 100%;
      overflow: hidden; /* Prevent body scroll */
      margin: 0;
      padding: 0;
      background-color: #f8f9fa;

   }

   .col-md-9 {
      height: calc(100vh - 56px);
      padding: 25px;
      overflow-y: auto; /* Enable vertical scrolling */ 
   }

   .carousel-container {
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
      padding: 30px;
      margin-bottom: 30px;
      border: 1px solid #e9ecef;
      position: relative;
   }

   .department-title {
      text-align: center;
      margin-bottom: 25px;
      color: #343a40;
      font-weight: 600;
      font-size: 1.8rem;
      border-bottom: 1px solid #e9ecef;
      padding-bottom: 15px;
   }

   .role-card {
      text-align: center;
      padding: 0 15px;
   }

   .role-name {
      font-size: 1.5rem;
      color: #343a40;
      margin-bottom: 20px;
      font-weight: 600;
   }

   .role-description {
      color: #6c757d;
      margin-bottom: 25px;
      font-style: italic;
      line-height: 1.5;
   }

   .role-stats {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-around;
      margin-bottom: 25px;
   }

   .stat-item {
      text-align: center;
      margin: 10px;
      flex: 1;
      min-width: 120px;
   }

   .stat-value {
      font-size: 1.5rem;
      font-weight: 600;
      color: #495057;
      display: block;
   }

   .stat-label {
      font-size: 0.85rem;
      color: #6c757d;
      text-transform: uppercase;
      letter-spacing: 0.5px;
   }

   .highest-paid {
      background-color: #f8f9fa;
      border-radius: 8px;
      padding: 15px;
      margin-top: 15px;
   }

   .highest-paid-label {
      font-size: 0.9rem;
      color: #6c757d;
      margin-bottom: 5px;
   }

   .highest-paid-name {
      font-weight: 600;
      color: #495057;
   }

   .highest-paid-salary {
      font-weight: 600;
      color: #28a745;
   }

   .role-actions {
      display: flex;
      justify-content: center;
      gap: 10px;
      margin-top: 25px;
   }

   .carousel-indicators-container {
      position: absolute;
      bottom: -35px;
      left: 0;
      right: 0;
      text-align: center;
   }

   .carousel-indicators {
      position: static;
      display: inline-block;
      margin: 0;
      padding: 0;
   }

   .carousel-indicators li {
      background-color: #adb5bd;
      width: 10px;
      height: 10px;
      border-radius: 50%;
      display: inline-block;
      margin: 0 5px;
   }

   .carousel-indicators .active {
      background-color: #007bff;
   }

   .carousel-control-prev,
   .carousel-control-next {
      width: 5%;
      opacity: 0.7;
   }

   .carousel-control-prev-icon,
   .carousel-control-next-icon {
      background-color: #343a40;
      border-radius: 50%;
      background-size: 60%;
      width: 35px;
      height: 35px;
   }

   .btn-create {
      background-color: #007bff;
      border-color: #007bff;
      color: white;
   }

   .btn-edit {
      background-color: #28a745;
      border-color: #28a745;
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

   .header-actions {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 25px;
   }

   .page-title {
      color: #343a40;
      font-weight: 600;
      font-size: 1.8rem;
      margin: 0;
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

   .create-role-btn-container {
      display: flex;
      justify-content: flex-end;
      margin-bottom: 20px;
   }


   .loading {
      text-align: center;
      padding: 40px;
      color: #6c757d;
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
      0% {
            transform: rotate(0deg);
      }

      100% {
            transform: rotate(360deg);
      }
   }

   .no-data {
      text-align: center;
      padding: 40px;
      color: #6c757d;
      font-style: italic;
   }

   .error-message {
      text-align: center;
      padding: 20px;
      color: #dc3545;
      background-color: #f8d7da;
      border-radius: 5px;
      margin: 10px 0;
   }

   .btn-view {
      background-color: #17a2b8;
      border-color: #17a2b8;
      color: white;
   }

   .btn-view:hover {
      background-color: #138496;
      border-color: #117a8b;
   }
</style>
HTML;

$scripts = <<<HTML
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
HTML;

$content = <<<'HTML'
<!-- Create New Role -->
<div class="create-role-btn-container">
   <a href="departments/roles/create">
      <button type="button" class="btn btn-primary btn-sm btn-create new-role-btn">
            <i class="fas fa-plus"></i> New Role
      </button>
   </a>
</div>

<!-- Carrossel of roles-->
<div class="carousel-container">
   <h2 class="department-title" id="departmentTitle">
      Loading department...
   </h2>

   <div id="rolesCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
      <div class="carousel-inner" id="carouselInner">
            <!-- Dynamic content -->
      </div>

      <!-- Carousel Controls -->
      <a class="carousel-control-prev" href="#rolesCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#rolesCarousel" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
      </a>
   </div>

   <!-- carousel index -->
   <div class="carousel-indicators-container">
      <ol class="carousel-indicators" id="carouselIndicators">
      </ol>
   </div>
</div>

<!-- List of Employees-->
<div class="employees-section">
   <div class="table-container">
      <h3 class="section-title">Employees in Current Role</h3>
      <table id="employeesTable" class="table table-hover" style="width:100%">
            <thead>
               <tr>
                  <th>Name</th>
                  <th>Age</th>
                  <th>Phone</th>
                  <th>Salary</th>
                  <th class="text-center">Actions</th>
               </tr>
            </thead>
            <tbody>
               <!-- Dynamic content -->
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
    let departmentID;
    let departmentName;
    let employeesTable;
    
    document.addEventListener('DOMContentLoaded', function () {
        console.log('Department Details Page');

        // Show loading state
        showLoadingState();

        
        // Initialize DataTable
        employeesTable = $('#employeesTable').DataTable({
            "language": {
                "emptyTable": "No employees found for this role",
                "info": "Showing _START_ to _END_ of _TOTAL_ employees",
                "infoEmpty": "Showing 0 to 0 of 0 employees",
                "infoFiltered": "(filtered from _MAX_ total employees)",
                "lengthMenu": "Show _MENU_ employees",
                "search": "Search:",
                "zeroRecords": "No matching employees found",
                "paginate": {
                    "first": "First",
                    "last": "Last",
                    "next": "Next",
                    "previous": "Previous"
                }
            },
            "responsive": true,
            "columnDefs": [
                { "orderable": false, "targets": 4 }
            ]
        });

        // Get parameters from URL
        const params = Object.fromEntries(new URLSearchParams(window.location.search));
        ({ id: departmentID, name: departmentName } = params);
        
        // Validate parameters
        if (!isValidParam(departmentID) || !isValidParam(departmentName)) {
            showErrorState('Department ID or Name is missing in the URL.');
            console.error('Department ID or Name is missing in the URL:', {
                departmentID,
                departmentName
            });
            return;
        }

        console.log('Getting department details for URL ID:', departmentID, 'Name:', departmentName);

        // Update "New Role" button link
        const newRoleBtn = document.querySelector('.new-role-btn');
        if (newRoleBtn && departmentID) {
            const link = newRoleBtn.closest('a');
            link.href = `departments/roles/create?department_id=${departmentID}`;
        }

        loadDepartmentRolesData(departmentID);
        attachGlobalEventListeners();
    });

    function attachGlobalEventListeners() {
        $('.new-role-btn').click(function () {
            console.log('Navigating to create new role page');
        });

        $(document).on('click', '.btn-view', function (e) {
            e.preventDefault();
            const employeeId = $(this).data('id');
            window.location.href = `employees/show?id=${employeeId}`;
        });

        $(document).on('click', '.btn-delete', function (e) {
            e.preventDefault();
            const employeeId = $(this).data('id');
            deleteEmployee(employeeId);
        });
    }

    // ============================================
    // UI STATE MANAGEMENT FUNCTIONS
    // ============================================

    function showLoadingState() {
        const carouselInner = document.getElementById('carouselInner');
        const carouselIndicators = document.getElementById('carouselIndicators');
        const departmentTitle = document.getElementById('departmentTitle');
        
        // Clear existing content
        carouselInner.innerHTML = '';
        carouselIndicators.innerHTML = '';
        
        // Update department title
        departmentTitle.innerHTML = `
            <div class="loading-spinner" style="margin: 0 auto 10px;"></div>
            Loading department...
        `;
        
        // Create loading carousel item
        const loadingItem = document.createElement('div');
        loadingItem.className = 'carousel-item active';
        loadingItem.innerHTML = `
            <div class="loading">
                <div class="loading-spinner"></div>
                <p>Loading department roles...</p>
                <p style="font-size: 0.9rem; color: #6c757d;">Please wait while we load the department information.</p>
            </div>
        `;
        
        carouselInner.appendChild(loadingItem);
        
        // Clear employees table
        if (employeesTable && typeof employeesTable.clear === 'function') {
            employeesTable.clear().draw();
        }
    }

    function showErrorState(message) {
        const carouselInner = document.getElementById('carouselInner');
        const carouselIndicators = document.getElementById('carouselIndicators');
        const departmentTitle = document.getElementById('departmentTitle');
        
        // Clear existing content
        carouselInner.innerHTML = '';
        carouselIndicators.innerHTML = '';
        
        // Update department title
        departmentTitle.innerHTML = `
            <span style="color: #e74c3c;">
                <i class="fas fa-exclamation-triangle"></i> Error Loading Department
            </span>
        `;
        
        // Create error carousel item
        const errorItem = document.createElement('div');
        errorItem.className = 'carousel-item active';
        errorItem.innerHTML = `
            <div class="error-message">
                <i class="fas fa-exclamation-circle fa-2x" style="margin-bottom: 15px;"></i>
                <h4 style="color: #c0392b; margin-bottom: 10px;">Unable to Load Department Data</h4>
                <p>${escapeHtml(message)}</p>
                <button class="btn btn-primary retry-btn" style="margin-top: 15px;">
                    <i class="fas fa-redo"></i> Try Again
                </button>
            </div>
        `;
        
        carouselInner.appendChild(errorItem);
        
        // Add retry button functionality
        setTimeout(() => {
            document.querySelector('.retry-btn')?.addEventListener('click', function() {
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Trying...';
                this.disabled = true;
                showLoadingState();
                setTimeout(() => loadDepartmentRolesData(departmentID), 1000);
            });
        }, 100);
        
        // Clear employees table
        if (employeesTable && typeof employeesTable.clear === 'function') {
            employeesTable.clear().draw();
        }
    }

    function showNoRolesState() {
        const carouselInner = document.getElementById('carouselInner');
        const carouselIndicators = document.getElementById('carouselIndicators');
        const departmentTitle = document.getElementById('departmentTitle');
        
        // Clear existing content
        carouselInner.innerHTML = '';
        carouselIndicators.innerHTML = '';
        
        // Update department title with department name
        departmentTitle.textContent = departmentName || 'Department';
        
        // Create empty state carousel item
        const emptyItem = document.createElement('div');
        emptyItem.className = 'carousel-item active';
        emptyItem.innerHTML = `
            <div class="no-data">
                <i class="fas fa-clipboard-list fa-3x" style="color: #6c757d; margin-bottom: 20px;"></i>
                <h3 style="color: #343a40;">No Roles Found</h3>
                <p>This department doesn't have any roles yet.</p>
                <p style="font-size: 0.9rem; margin-top: 15px;">Click the button below to create the first role for this department.</p>
                
                <div class="role-actions" style="margin-top: 25px;">
                    <a href="departments/roles/create?department_id=${departmentID}">
                        <button class="btn btn-primary" style="padding: 10px 20px;">
                            <i class="fas fa-plus"></i> Create First Role
                        </button>
                    </a>
                </div>
            </div>
        `;
        
        carouselInner.appendChild(emptyItem);
        
        // Clear employees table
        if (employeesTable && typeof employeesTable.clear === 'function') {
            employeesTable.clear().draw();
        }
    }

    // ============================================
    // API CALL FUNCTIONS (Standard Pattern)
    // ============================================

    function loadDepartmentRolesData(departmentID) {
        const FUNCTION_NAME = 'loadDepartmentRolesData';
        const ENDPOINT = `departments/roles/list?department_id=${departmentID}`;
        const TIMEOUT_MS = 10000;
        
        console.log(`[${FUNCTION_NAME}] Loading roles for department ID: ${departmentID}`);

        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), TIMEOUT_MS);

        return fetch(ENDPOINT, {
            method: 'GET',
            headers: { 'Content-Type': 'application/json' },
            signal: controller.signal
        })
        .then(function handleResponse(response) {
            clearTimeout(timeoutId); // Response received - cancel timeout
            
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
                dataLength: responseBody.data?.length || 0
            });

            if (!responseBody || !responseBody.success || !responseBody.data) {
                console.error(`[${FUNCTION_NAME}] Invalid response structure!`, responseBody);
                showErrorState(responseBody?.friendly_message || 'Invalid server response. Please try again.');
                return;
            }

            // Check if there are roles
            if (responseBody.data.length === 0) {
                console.log(`[${FUNCTION_NAME}] No roles found. Showing empty state.`);
                showNoRolesState();
                return;
            }

            console.log(`[${FUNCTION_NAME}] Rendering department with ${responseBody.data.length} roles.`);
            return renderDepartmentData(responseBody.data);
        })
        .catch(function handleFetchError(err) {
            clearTimeout(timeoutId); // An error occurred - cancel timeout

            if (err && err.name === 'AbortError') {
                console.error(`[${FUNCTION_NAME}] Timeout after ${TIMEOUT_MS}ms`);
                showErrorState('Request timed out. Please try again.');
                return;
            }

            if (err.type && (err.type === 'HTTP_ERROR' || err.type === 'API_ERROR')) {
                console.error(`[${FUNCTION_NAME}] Error occurred | Status: ${err.status} | Type: ${err.type}`);
                showErrorState(err.friendlyMessage || 'Error loading department data.');
                return;
            }

            console.error(`[${FUNCTION_NAME}] Unexpected error loading roles data:`, {
                name: err.name,
                message: err.message,
            });
            
            showErrorState('An unexpected error occurred. Please check your connection and try again.');
        })
        .finally(() => {
            clearTimeout(timeoutId);
            console.log(`[${FUNCTION_NAME}] Completed`);
        });
    }

    function loadEmployeesForRole(roleId) {
        const FUNCTION_NAME = 'loadEmployeesForRole';
        const ENDPOINT = `employees/list-by-role?role_id=${roleId}`;
        const TIMEOUT_MS = 10000;
        
        console.log(`[${FUNCTION_NAME}] Loading employees for role ID: ${roleId}`);
        
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), TIMEOUT_MS);

        if (!employeesTable) return;

        employeesTable.clear().draw();

        return fetch(ENDPOINT, {
            method: 'GET',
            headers: { 'Content-Type': 'application/json' },
            signal: controller.signal
        })
        .then(function handleResponse(response) {
            clearTimeout(timeoutId); // Response received - cancel timeout

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
                dataLength: responseBody.data?.length || 0
            });

            if (!responseBody || !responseBody.success || !responseBody.data) {
                console.error(`[${FUNCTION_NAME}] Invalid response structure!`, responseBody);
                // Don't show error state here, just update table with error message
                updateEmployeesTable([]);
                return;
            }

            console.log(`[${FUNCTION_NAME}] ${responseBody.data.length} loaded employees.`);
            return updateEmployeesTable(responseBody.data);
        })
        .catch(function handleFetchError(err) {
            clearTimeout(timeoutId);

            if (err && err.name === 'AbortError') {
                console.error(`[${FUNCTION_NAME}] Timeout after ${TIMEOUT_MS}ms`);
                employeesTable.clear().draw();
                employeesTable.row.add(['Request timed out. Please try again.', '', '', '', '']).draw();
                return;
            }

            if (err.type && (err.type === 'HTTP_ERROR' || err.type === 'API_ERROR')) {
                console.error(`[${FUNCTION_NAME}] Error occurred | Status: ${err.status} | Type: ${err.type}`);
                employeesTable.clear().draw();
                employeesTable.row.add(['Error loading employees: ' + err.friendlyMessage, '', '', '', '']).draw();
                return;
            }

            console.error(`[${FUNCTION_NAME}] Unexpected error:`, {
                name: err.name,
                message: err.message,
            });

            employeesTable.clear().draw();
            employeesTable.row.add(['Error loading employees', '', '', '', '']).draw();
        })
        .finally(() => {
            clearTimeout(timeoutId);
            console.log(`[${FUNCTION_NAME}] Completed`);
        });
    }

    function deleteRole(roleId) {
        const FUNCTION_NAME = 'deleteRole';
        const ENDPOINT = 'departments/roles/delete';
        const TIMEOUT_MS = 10000;
        
        console.log(`[${FUNCTION_NAME}] Deleting role ID: ${roleId}`);

        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), TIMEOUT_MS);

        if (confirm('Are you sure you want to delete this role?')) {
            return fetch(ENDPOINT, {
                method: 'DELETE',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ id: roleId }),
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
                if (!responseBody || !responseBody.success) {
                    console.error(`[${FUNCTION_NAME}] Invalid response structure!`, responseBody);
                    alert(`Error deleting role: ${responseBody?.friendly_message || 'Invalid server response.'}`);
                    return;
                }

                alert('Role deleted successfully.');
                console.log(`[${FUNCTION_NAME}] Role deleted successfully. Reloading roles...`);
                showLoadingState();
                return loadDepartmentRolesData(departmentID);
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
                    alert(err.friendlyMessage || 'Error deleting role.');
                    return;
                }

                console.error(`[${FUNCTION_NAME}] Unexpected error:`, {
                    name: err.name,
                    message: err.message,
                });

                alert('An unexpected error occurred. Please check your connection and try again.');
            })
            .finally(() => {
                clearTimeout(timeoutId);
                console.log(`[${FUNCTION_NAME}] Completed`);
            });
        }
    }

    function deleteEmployee(employeeId) {
        const FUNCTION_NAME = 'deleteEmployee';
        const ENDPOINT = 'employees/delete';
        const TIMEOUT_MS = 10000;

        console.log(`[${FUNCTION_NAME}] Deleting employee ID: ${employeeId}`);

        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), TIMEOUT_MS);

        if (confirm('Are you sure you want to delete this employee? This action cannot be undone.')) {
            const deleteBtn = $(`.btn-delete[data-id="${employeeId}"]`);
            const originalHtml = deleteBtn.html();
            deleteBtn.html('<i class="fas fa-spinner fa-spin"></i>');
            deleteBtn.prop('disabled', true);

            return fetch(ENDPOINT, {
                method: 'DELETE',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ id: employeeId }),
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
            .then(function handleSuccess(responseBody){
                if (!responseBody || !responseBody.success) {
                    console.error(`[${FUNCTION_NAME}] Invalid response structure!`, responseBody);
                    alert(`Error deleting employee: ${responseBody?.friendly_message || 'Invalid server response.'}`);
                    return;
                }

                alert('Employee deleted successfully.');
                console.log(`[${FUNCTION_NAME}] Employee deleted successfully. Reloading data...`);
                
                // Reload department roles and employees for current role
                const activeRoleId = $('.carousel-item.active').data('role-id');
                if (activeRoleId) {
                    loadEmployeesForRole(activeRoleId);
                }
            })
            .catch(function handleFetchError(err){
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
            .finally(() => {
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

    function renderDepartmentData(roles) {
        const FUNCTION_NAME = 'renderDepartmentData';        
        console.log(`[${FUNCTION_NAME}] Rendering data for department: ${departmentName}.`);
        
        // Update department title
        $('#departmentTitle').text(departmentName);

        console.log(`[${FUNCTION_NAME}] Rendering ${roles.length} roles.`);
        // Render roles carousel
        renderRolesCarousel(roles);

        // Automatically loads employees from the first position.
        if (roles.length > 0) {
            console.log(`[${FUNCTION_NAME}] Loading employees for first role.`);
            return loadEmployeesForRole(roles[0].id);
        }
    }

    function renderRolesCarousel(roles) {
        const FUNCTION_NAME = 'renderRolesCarousel';
        const carouselInner = $('#carouselInner');
        const carouselIndicators = $('#carouselIndicators');

        carouselInner.empty();
        carouselIndicators.empty();

        // Loop to dynamically create each function card.
        roles.forEach((role, index) => {
            const indicator = $('<li></li>')
                .attr('data-target', '#rolesCarousel')
                .attr('data-slide-to', index)
                .toggleClass('active', index === 0);
            carouselIndicators.append(indicator);

            const carouselItem = $('<div></div>')
                .addClass('carousel-item')
                .toggleClass('active', index === 0)
                .attr('data-role-id', role.id);

            const roleCard = `
                <div class="role-card">
                    <h3 class="role-name">${escapeHtml(role.name)}</h3>
                    <p class="role-description">${escapeHtml(role.description || 'No description available.')}</p>
                    
                    <div class="role-stats">
                        <div class="stat-item">
                            <span class="stat-value">${role.employees_count}</span>
                            <span class="stat-label">Employees</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">$${role.total_salary}</span>
                            <span class="stat-label">Total Salary</span>
                        </div>
                        <div class="stat-item">
                            <span class="stat-value">-</span>
                            <span class="stat-label">Avg. Age</span>
                        </div>
                    </div>
                    
                    <div class="highest-paid">
                        <div class="highest-paid-label">Highest Paid Employee</div>
                        <div>
                            <span class="highest-paid-name">${escapeHtml(role.highest_paid_name || 'N/A')}</span> - 
                            <span class="highest-paid-salary">${role.highest_paid_salary ? '$' + role.highest_paid_salary : 'N/A'}</span>
                        </div>
                    </div>
                    
                    <div class="role-actions">
                        <button class="btn btn-edit btn-sm edit-role-btn" data-role-id="${role.id}">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-delete btn-sm delete-role-btn" data-role-id="${role.id}">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>
            `;

            carouselItem.html(roleCard);
            carouselInner.append(carouselItem);
        });

        // Reconfigure the carousel (Bootstrap)
        $('#rolesCarousel').carousel('dispose').carousel({ interval: false });

        // Event: When the slide changes, it updates the employees.
        $('#rolesCarousel').on('slid.bs.carousel', function (e) {
            const activeRoleId = $(e.relatedTarget).data('role-id');
            console.log(`[${FUNCTION_NAME}] Slide changed. Loading employees for role ID: ${activeRoleId}`);
            loadEmployeesForRole(activeRoleId);

            $('.carousel-indicators li').removeClass('active');
            $('.carousel-indicators li[data-slide-to="' + $(e.relatedTarget).index() + '"]').addClass('active');
        });

        // Attach event listeners to edit and delete buttons
        $('.edit-role-btn').on('click', function (e) {
            e.stopPropagation();
            const roleId = $(this).data('role-id');
            window.location.href = `departments/roles/update?id=${roleId}&department_id=${departmentID}`;
        });

        $('.delete-role-btn').on('click', function (e) {
            e.stopPropagation();
            const roleId = $(this).data('role-id');
            deleteRole(roleId);
        });

        console.log(`[${FUNCTION_NAME}] Rendering completed of ${roles.length} roles in the carousel.`);
    }

    function updateEmployeesTable(employees) {
        if (!employeesTable) return;

        employeesTable.clear();

        if (employees.length === 0) {
            employeesTable.row.add(['No employees found for this role', '', '', '', '']).draw();
            return;
        }

        employees.forEach(function (employee) {
        var actionsHtml = `
            <div class="table-actions">
                <button class="btn btn-view btn-sm" title="View" data-id="${employee.id}">
                    <i class="fas fa-eye"></i>
                </button>
                <button class="btn btn-delete btn-sm" data-id="${employee.id}" title="Delete">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        `;

            employeesTable.row.add([
                escapeHtml(employee.name),
                employee.age,
                escapeHtml(employee.phone_number),
                `$${employee.salary}`,
                actionsHtml
            ]);
        });

        employeesTable.draw();
    }

    // ============================================
    // UTILITY FUNCTIONS
    // ============================================
    function isValidParam(value) {
        return value !== null &&
            value !== undefined &&
            value !== '' &&
            value !== 'null' &&
            value !== 'undefined';
    }

    function escapeHtml(unsafe) {
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }
</script>
HTML;

include __DIR__ .'/../layouts/main.php';