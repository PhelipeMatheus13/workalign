<?php
$pageTitle = "New Employee";
$styles = <<<'HTML'
<style>
    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        overflow: hidden;
        background: #f6f9fb;
    }

    .container-fluid {
        padding: 0;
        height: 100vh;
    }

    .row {
        margin: 0;
        height: 100%;
    }

    .col-md-9 {
        height: calc(100vh - 56px);
        padding: 0;
        display: flex;
        flex-direction: column;
        overflow-y: auto;
    }

    .content-container {
        max-width: 800px;
        width: 100%;
        margin: 0 auto;
        padding: 20px;
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .page-title {
        color: #2c3e50;
        font-weight: 600;
        font-size: 1.8rem;
        margin: 0;
    }

    .header-actions {
        display: flex;
        gap: 10px;
    }

    .employee-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 30px;
    }

    .info-grid-compact {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }

    .info-section {
        margin-bottom: 25px;
    }

    .section-title {
        color: #2c3e50;
        font-weight: 600;
        font-size: 1.1rem;
        margin-bottom: 15px;
        padding-bottom: 8px;
        border-bottom: 1px solid #e9ecef;
    }

    .info-item {
        margin-bottom: 12px;
    }

    /* NOVO: Estilo para itens que ocupam toda a largura */
    .info-item.full-width {
        grid-column: span 2;
        margin-bottom: 15px;
    }

    /* NOVO: Estilo para containers de 2 itens lado a lado */
    .two-columns-container {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        grid-column: span 2;
        margin-bottom: 15px;
    }

    /* NOVO: Estilo para melhor espaçamento entre itens */
    .two-columns-container .info-item {
        margin-bottom: 0;
    }

    .info-label {
        color: #6c757d;
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 3px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .form-control, .form-select {
        border: 1px solid #ced4da;
        border-radius: 4px;
        padding: 8px 12px;
        font-size: 1rem;
        color: #2c3e50;
        width: 100%;
    }

    .form-control:focus, .form-select:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
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
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .error-message {
        text-align: center;
        padding: 20px;
        color: #dc3545;
        background-color: #f8d7da;
        border-radius: 5px;
        margin: 10px 0;
    }

    .success-message {
        text-align: center;
        padding: 20px;
        color: #155724;
        background-color: #d4edda;
        border-radius: 5px;
        margin: 10px 0;
    }

    .btn-back {
        background-color: #6c757d;
        border-color: #6c757d;
        color: white;
    }

    .btn-save {
        background-color: #28a745;
        border-color: #28a745;
        color: white;
    }

    .btn-cancel {
        background-color: #6c757d;
        border-color: #6c757d;
        color: white;
    }

    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        border-radius: 4px;
    }

    .form-actions {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
    }

    @media (max-width: 768px) {
        .col-md-9 {
            height: calc(100vh - 56px);
        }

        .content-container {
            padding: 15px;
        }

        .page-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 20px;
        }

        .header-actions {
            width: 100%;
            justify-content: space-between;
        }

        .info-grid-compact {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        /* NOVO: Ajustes responsivos para os novos layouts */
        .info-item.full-width {
            grid-column: span 1;
        }

        .two-columns-container {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .employee-card {
            padding: 20px;
        }

        .form-actions {
            flex-direction: column;
        }
    }
</style>
HTML;

$content = <<<'HTML'
<div class="content-container">
    <div class="page-header">
        <h1 class="page-title">Register New Employee</h1>
        <div class="header-actions">
            <a href="employees">
                <button type="button" class="btn btn-back btn-sm">
                    <i class="fas fa-arrow-left"></i> Back to List
                </button>
            </a>
        </div>
    </div>

    <div class="employee-card">
        <form id="employeeForm" action="employees/create" method="POST">
            <!-- Personal Information -->
            <div class="info-section">
                <h3 class="section-title">Personal Information</h3>
                <div class="info-grid-compact">
                    <!-- Primeira linha: Nome e Sobrenome lado a lado -->
                    <div class="two-columns-container">
                        <div class="info-item">
                            <div class="info-label">First Name *</div>
                            <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" required>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Last Name *</div>
                            <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter last name" required>
                        </div>
                    </div>
                    
                    <!-- Segunda linha: Data de nascimento e Email lado a lado -->
                    <div class="two-columns-container">
                        <div class="info-item">
                            <div class="info-label">Date of Birth *</div>
                            <input type="date" class="form-control" id="birthday" name="birthday" required>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Email Address *</div>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" required>
                        </div>
                    </div>
                    
                    <!-- Terceira linha: Telefones lado a lado -->
                    <div class="two-columns-container">
                        <div class="info-item">
                            <div class="info-label">Primary Phone *</div>
                            <input type="tel" class="form-control" id="phone_number" name="phone_number" placeholder="(123) 456-7890" required>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Secondary Phone</div>
                            <input type="tel" class="form-control" id="second_phone_number" name="second_phone_number" placeholder="(123) 456-7890">
                            <small class="form-text text-muted">Optional</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Professional Information -->
            <div class="info-section">
                <h3 class="section-title">Professional Information</h3>
                <div class="info-grid-compact">
                    <div class="two-columns-container">
                        <!-- Select department and roles -->
                        <div class="info-item">
                            <div class="info-label">Department *</div>
                            <select class="form-select" id="department" name="department_id" required>
                                <option value="">Loading departments...</option>
                            </select>
                        </div>
                        <div class="info-item">
                            <div class="info-label">Role *</div>
                            <select class="form-select" id="role" name="role_id" disabled required>
                                <option value="">Select Department First</option>
                            </select>
                        </div>
                    </div>
                    <!-- Salary -->
                    <div class="info-item full-width">
                        <div class="info-label">Salary ($) *</div>
                        <input type="number" class="form-control" id="salary" name="salary" placeholder="0.00" step="0.01" min="0" required>
                    </div>
                </div>
            </div>

            <!-- Address -->
            <div class="info-section">
                <h3 class="section-title">Address</h3>
                <div class="info-item full-width">
                    <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter complete address" required></textarea>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="form-actions">
                <button type="button" class="btn btn-cancel btn-sm" onclick="window.history.back()">Cancel</button>
                <button type="submit" class="btn btn-save btn-sm">Register Employee</button>
            </div>
        </form>
    </div>
</div>
HTML;

$scripts = <<<'HTML'
<script src="https://cdn.datatables.net/2.3.4/js/dataTables.js"></script>
HTML;

$inlineScript = <<<'HTML'
<script>
    // ============================================
    // INITIALIZATION
    // ============================================

    document.addEventListener('DOMContentLoaded', function() {
        console.log('Register employee page');
        
        // Load initial data
        loadDepartmentsAndRoles();
        
        // Attach event listeners
        attachEventListeners();
    });

    function attachEventListeners() {
        // Department change event
        document.getElementById('department').addEventListener('change', function() {
            handleDepartmentChange(this.value);
        });
        
        // Form submit event
        document.getElementById('employeeForm').addEventListener('submit', function(e) {
            validateFormBeforeSubmit(e);
        });
    }

    // ============================================
    // UI STATE MANAGEMENT FUNCTIONS
    // ============================================

    function showLoadingState() {
        const departmentSelect = document.getElementById('department');
        const roleSelect = document.getElementById('role');
        
        departmentSelect.innerHTML = `
            <option value="">
                <i class="fas fa-spinner fa-spin"></i> Loading departments...
            </option>
        `;
        departmentSelect.disabled = true;
        
        roleSelect.innerHTML = '<option value="">Loading...</option>';
        roleSelect.disabled = true;
        
    }

    function showErrorState(message = 'Failed to load departments. Please try again.') {
        const departmentSelect = document.getElementById('department');
        const roleSelect = document.getElementById('role');
        
        departmentSelect.innerHTML = `
            <option value="">
                <i class="fas fa-exclamation-triangle"></i> Error Loading Data
            </option>
        `;
        departmentSelect.disabled = false;
        
        roleSelect.innerHTML = '<option value="">Error - Please reload</option>';
        roleSelect.disabled = true;
        
        // Show error message to user
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.innerHTML = `
            <i class="fas fa-exclamation-circle fa-2x" style="margin-bottom: 10px;"></i>
            <h5 style="color: #c0392b; margin-bottom: 5px;">Unable to Load Data</h5>
            <p style="margin-bottom: 15px;">${escapeHtml(message)}</p>
            <button class="btn btn-primary retry-btn" style="padding: 5px 15px; font-size: 0.9rem;">
                <i class="fas fa-redo"></i> Retry
            </button>
        `;
        
        // Remove any existing error message
        const existingError = document.querySelector('.error-message');
        if (existingError) {
            existingError.remove();
        }
        
        // Insert error message before the form
        const form = document.getElementById('employeeForm');
        form.parentNode.insertBefore(errorDiv, form);
        
        // Add retry functionality
        setTimeout(() => {
            document.querySelector('.retry-btn')?.addEventListener('click', function() {
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Retrying...';
                this.disabled = true;
                showLoadingState();
                loadDepartmentsAndRoles();
            });
        }, 100);
        
    }

    function showEmptyState() {
        const departmentSelect = document.getElementById('department');
        const roleSelect = document.getElementById('role');
        
        departmentSelect.innerHTML = `
            <option value="">
                <i class="fas fa-search"></i> No departments found
            </option>
        `;
        departmentSelect.disabled = true;
        
        roleSelect.innerHTML = '<option value="">No roles available</option>';
        roleSelect.disabled = true;
        
        // Show empty state message
        const emptyDiv = document.createElement('div');
        emptyDiv.className = 'success-message';
        emptyDiv.style.backgroundColor = '#f8f9fa';
        emptyDiv.innerHTML = `
            <i class="fas fa-clipboard-list fa-2x" style="color: #6c757d; margin-bottom: 10px;"></i>
            <h5 style="color: #343a40;">No Departments Found</h5>
            <p>There are no departments with roles available. Please create a department and role first.</p>
            <a href="departments" class="btn btn-primary" style="margin-top: 10px;">
                <i class="fas fa-building"></i> Go to Departments
            </a>
        `;
        
        // Remove any existing empty state
        const existingEmpty = document.querySelector('.success-message');
        if (existingEmpty) {
            existingEmpty.remove();
        }
        
        // Insert empty state message before the form
        const form = document.getElementById('employeeForm');
        form.parentNode.insertBefore(emptyDiv, form);
        
    }

    function showFormReadyState() {
        // Remove any error/empty states
        const errorDiv = document.querySelector('.error-message');
        const emptyDiv = document.querySelector('.success-message');
        
        if (errorDiv) errorDiv.remove();
        if (emptyDiv) emptyDiv.remove();
        
    }

    // ============================================
    // API CALL FUNCTIONS (Standard Pattern)
    // ============================================

    function loadDepartmentsAndRoles() {
        const FUNCTION_NAME = 'loadDepartmentsAndRoles';
        const ENDPOINT = 'departments/with-roles';
        const TIMEOUT_MS = 10000;
        
        console.log(`[${FUNCTION_NAME}] Loading departments with roles`);

        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), TIMEOUT_MS);

        showLoadingState();

        return fetch(ENDPOINT, {
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
                            friendlyMessage: `Error ${response.status}: ${response.statusText}`
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
                            friendlyMessage: errJson.friendly_message || `Error: ${errJson.error}`
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

            if (!responseBody || !responseBody.success) {
                console.error(`[${FUNCTION_NAME}] Invalid response structure!`, responseBody);
                showErrorState(responseBody?.friendly_message || 'Invalid server response. Please try again.');
                return;
            }

            // Check if there are departments
            if (!responseBody.data || responseBody.data.length === 0) {
                console.log(`[${FUNCTION_NAME}] No departments found. Showing empty state.`);
                showEmptyState();
                return;
            }

            console.log(`[${FUNCTION_NAME}] ${responseBody.data.length} departments loaded.`);
            
            showFormReadyState();
            return populateDepartmentSelect(responseBody.data);
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
                showErrorState(err.friendlyMessage || 'Error loading department data.');
                return;
            }

            console.error(`[[${FUNCTION_NAME}] Unexpected error:`, {
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

    // ============================================
    // DATA MANAGEMENT FUNCTIONS
    // ============================================

    function populateDepartmentSelect(departmentsData) {
        const FUNCTION_NAME = 'populateDepartmentSelect';
        console.log(`[${FUNCTION_NAME}] Populating department select with`, departmentsData.length, 'departments');
        
        const departmentSelect = document.getElementById('department');
        
        // Clear previous options
        departmentSelect.innerHTML = '<option value="">Select Department</option>';
        
        // Add each department
        departmentsData.forEach(dept => {
            const option = document.createElement('option');
            option.value = dept.department_id;
            option.textContent = dept.department_display;
            option.setAttribute('data-full-name', dept.department_name);
            option.setAttribute('data-roles', JSON.stringify(dept.roles || []));
            departmentSelect.appendChild(option);
        });
        
        // Enable the select
        departmentSelect.disabled = false;
        
        console.log(`[${FUNCTION_NAME}] Department select populated successfully`);
    }

function handleDepartmentChange(departmentId) {
    const roleSelect = document.getElementById('role');

    roleSelect.innerHTML = '<option value="">Select Role</option>';
    roleSelect.disabled = true;

    // If no department is selected, it closes.
    if (!departmentId) {
        roleSelect.innerHTML = '<option value="">Select department first</option>';
        return;
    }

    const departmentSelect = document.getElementById('department');
    const selectedOption = departmentSelect.options[departmentSelect.selectedIndex];

    // If department not found, it closes
    if (!selectedOption) {
        roleSelect.innerHTML = '<option value="">Error: Department not found</option>';
        return;
    }

    const roles = JSON.parse(selectedOption.getAttribute('data-roles') || '[]');

    // If no roles are available, it closes
    if (!roles || roles.length === 0) {
        roleSelect.innerHTML = '<option value="">No roles available for this department</option>';
        console.log('[DATA] No roles found for selected department');
        return;
    }

    // If no roles are available, it closes
    roleSelect.disabled = false;

    roles.forEach(role => {
        const option = document.createElement('option');
        option.value = role.role_id;
        option.textContent = role.role_name;
        roleSelect.appendChild(option);
    });

    console.log(`[DATA] Populated role select with ${roles.length} roles for department ${departmentId}`);
}


    // ============================================
    // FORM VALIDATION FUNCTIONS
    // ============================================

    function validateFormBeforeSubmit(e) {
        const departmentId = document.getElementById('department').value;
        const roleId = document.getElementById('role').value;
        
        if (!departmentId || !roleId) {
            e.preventDefault();
            showValidationError('Please select both department and role before submitting.');
            return;
        }
        
        // Validate date of birth (should be in the past)
        const birthday = document.getElementById('birthday').value;
        if (birthday) {
            const birthDate = new Date(birthday);
            const today = new Date();
            if (birthDate >= today) {
                e.preventDefault();
                showValidationError('Date of birth must be in the past.');
                return;
            }
        }
        
        // Validate salary (must be positive)
        const salary = document.getElementById('salary').value;
        if (salary <= 0) {
            e.preventDefault();
            showValidationError('Salary must be a positive number.');
            return;
        }
        
        // Validate address (cannot be empty)
        const address = document.getElementById('address').value.trim();
        if (!address) {
            e.preventDefault();
            showValidationError('Address is required.');
            return;
        }
        
        console.log('[FORM] Form submitted with department_id:', departmentId, 'and role_id:', roleId);
    }

    function showValidationError(message) {
        // Remove any existing validation error
        const existingError = document.querySelector('.validation-error');
        if (existingError) {
            existingError.remove();
        }
        
        // Create error message
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.style.marginTop = '10px';
        errorDiv.innerHTML = `
            <i class="fas fa-exclamation-circle"></i>
            <strong>Validation Error:</strong> ${escapeHtml(message)}
        `;
        
        // Insert before form actions
        const formActions = document.querySelector('.form-actions');
        formActions.parentNode.insertBefore(errorDiv, formActions);
        
        console.log('[VALIDATION] Validation error:', message);
    }

    // ============================================
    // UTILITY FUNCTIONS
    // ============================================

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

include __DIR__ . '/../layouts/main.php';