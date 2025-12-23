<?php
$pageTitle = "Edit Employee";
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
        <h1 class="page-title">Edit Employee</h1>
        <div class="header-actions">
            <a href="employees">
                <button type="button" class="btn btn-back btn-sm">
                    <i class="fas fa-arrow-left"></i> Back to List
                </button>
            </a>
        </div>
    </div>

    <!-- Employee editing card -->
    <div class="employee-card" id="employeeCard">
        <div class="loading" id="loadingState">
            <div class="loading-spinner"></div>
            <p>Loading employee data...</p>
        </div>

        <form id="employeeForm" style="display: none;">
            <!-- Personal information -->
            <div class="info-section">
                <h3 class="section-title">Personal Information</h3>
                <div class="info-grid-compact">
                    <div class="info-item">
                        <div class="info-label">First Name *</div>
                        <input type="text" class="form-control" id="firstName" name="first_name" required>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Last Name *</div>
                        <input type="text" class="form-control" id="lastName" name="last_name" required>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Date of Birth *</div>
                        <input type="date" class="form-control" id="birthday" name="birthday" required>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email Address *</div>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Primary Phone *</div>
                        <input type="tel" class="form-control" id="phoneNumber" name="phone_number" required>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Secondary Phone</div>
                        <input type="tel" class="form-control" id="secondPhoneNumber" name="second_phone_number">
                    </div>
                </div>
            </div>

            <!-- Professional Information -->
            <div class="info-section">
                <h3 class="section-title">Professional Information</h3>
                <div class="info-grid-compact">
                    <div class="info-item">
                        <div class="info-label">Department *</div>
                        <select class="form-select" id="department" name="department_id" required>
                            <option value="">Select Department</option>
                            <!-- Departments will be loaded dynamically -->
                        </select>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Role *</div>
                        <select class="form-select" id="role" name="role_id" required>
                            <option value="">Select Role</option>
                            <!-- Roles will be loaded dynamically -->
                        </select>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Salary *</div>
                        <input type="number" step="0.01" class="form-control" id="salary" name="salary" required>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Hire Date</div>
                        <input type="date" class="form-control" id="hireDate" disabled>
                        <small class="form-text text-muted">Hire date cannot be modified</small>
                    </div>
                </div>
            </div>

            <!-- Address -->
            <div class="info-section">
                <h3 class="section-title">Address</h3>
                <div class="info-item">
                    <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                </div>
            </div>

            <!-- Form actions -->
            <div class="form-actions">
                <button type="button" class="btn btn-cancel btn-sm" id="cancelBtn">
                    <i class="fas fa-times"></i> Cancel
                </button>
                <button type="submit" class="btn btn-save btn-sm" id="saveBtn">
                    <i class="fas fa-save"></i> Save Changes
                </button>
            </div>
        </form>
    </div>
</div>
HTML;

$inlineScript = <<<'HTML'
<script>
    // ============================================
    // INITIALIZATION
    // ============================================
    
    // Global variables
    let employeeID;
    let currentEmployeeData = null;
    let departmentsData = [];

    document.addEventListener('DOMContentLoaded', function () {
        console.log('Edit Employee Page');

        // Get employee ID from URL
        const params = Object.fromEntries(new URLSearchParams(window.location.search));
        ({ id: employeeID } = params);

        if (!isValidParam(employeeID)) {
            showErrorState('Employee ID is missing in the URL.');
            console.error('Employee ID is missing in the URL:', employeeID);
            return;
        }

        console.log('Editing employee ID:', employeeID);

        showLoadingState();
        loadEmployeeData(employeeID);
        loadDepartmentsAndRoles();

        // Event listeners
        document.getElementById('cancelBtn').addEventListener('click', function () {
            if (confirm('Are you sure you want to cancel? Any unsaved changes will be lost.')) {
                window.location.href = `employees/show?id=${employeeID}`;
            }
        });

        document.getElementById('employeeForm').addEventListener('submit', function (e) {
            e.preventDefault();
            saveEmployeeChanges();
        });

        // Department change event
        document.getElementById('department').addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];

            const roles = selectedOption.value
                ? JSON.parse(selectedOption.getAttribute('data-roles') || '[]')
                : [];

            populateRoleSelect(roles);
        });
    });

    // ============================================
    // UI STATE MANAGEMENT FUNCTIONS
    // ============================================

    function showLoadingState() {
        const loadingState = document.getElementById('loadingState');
        const employeeForm = document.getElementById('employeeForm');
        
        if (loadingState) loadingState.style.display = 'block';
        if (employeeForm) employeeForm.style.display = 'none';
    }

    function showFormState() {
        const loadingState = document.getElementById('loadingState');
        const employeeForm = document.getElementById('employeeForm');
        
        if (loadingState) loadingState.style.display = 'none';
        if (employeeForm) employeeForm.style.display = 'block';
    }

    function showErrorState(message) {
        const employeeCard = document.getElementById('employeeCard');
        const loadingState = document.getElementById('loadingState');
        const employeeForm = document.getElementById('employeeForm');
        
        if (loadingState) loadingState.style.display = 'none';
        if (employeeForm) employeeForm.style.display = 'none';
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.innerHTML = `
            <i class="fas fa-exclamation-circle fa-2x" style="margin-bottom: 15px;"></i>
            <h4 style="color: #c0392b; margin-bottom: 10px;">Unable to Load Employee Data</h4>
            <p>${escapeHtml(message)}</p>
            <button class="btn btn-primary retry-btn" style="margin-top: 15px;">
                <i class="fas fa-redo"></i> Try Again
            </button>
        `;
        
        employeeCard.innerHTML = '';
        employeeCard.appendChild(errorDiv);
        
        // Add retry button functionality
        setTimeout(() => {
            document.querySelector('.retry-btn')?.addEventListener('click', function() {
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Trying...';
                this.disabled = true;
                showLoadingState();
                setTimeout(() => {
                    loadEmployeeData(employeeID);
                    loadDepartmentsAndRoles();
                }, 1000);
            });
        }, 100);
    }

    function showSaveSuccessState(message) {
        const employeeCard = document.getElementById('employeeCard');
        const loadingState = document.getElementById('loadingState');
        const employeeForm = document.getElementById('employeeForm');
        
        if (loadingState) loadingState.style.display = 'none';
        if (employeeForm) employeeForm.style.display = 'none';
        
        const successDiv = document.createElement('div');
        successDiv.className = 'success-message';
        successDiv.innerHTML = `
            <i class="fas fa-check-circle fa-2x" style="margin-bottom: 15px;"></i>
            <h4 style="color: #155724; margin-bottom: 10px;">Success!</h4>
            <p>${escapeHtml(message)}</p>
            <p style="font-size: 0.9rem; margin-top: 15px; color: #6c757d;">
                You will be redirected to employee details in <span id="countdown">3</span> seconds...
            </p>
            <button id="backNowBtn" class="btn btn-success mt-3">
                Back now
            </button>
        `;
        
        employeeCard.innerHTML = '';
        employeeCard.appendChild(successDiv);
        document.getElementById('backNowBtn').addEventListener('click', function() {
            window.location.href = `employees/show?id=${employeeID}`;
        });
        // Start countdown
        let seconds = 3;
        const countdownElement = document.getElementById('countdown');
        const countdownInterval = setInterval(() => {
            seconds--;
            if (countdownElement) {
                countdownElement.textContent = seconds;
            }
            
            if (seconds <= 0) {
                clearInterval(countdownInterval);
                window.location.href = `employees/show?id=${employeeID}`;
            }
        }, 1000);
    }

    // ============================================
    // API CALL FUNCTIONS (Standard Pattern)
    // ============================================

    function loadEmployeeData(employeeId) {
        const FUNCTION_NAME = 'loadEmployeeData';
        const ENDPOINT = `employees/get?id=${employeeId}`;
        const TIMEOUT_MS = 10000;
        
        console.log(`[${FUNCTION_NAME}] Loading employee ID: ${employeeId}`);

        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), TIMEOUT_MS);

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
                        console.error(`[${FUNCTION_NAME}] Response is not valid JSON:`, {
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
                hasData: !!responseBody.data
            });

            if (!responseBody || !responseBody.success || !responseBody.data) {
                console.error(`[${FUNCTION_NAME}] Invalid response structure!`, responseBody);
                showErrorState(responseBody?.friendly_message || 'Invalid server response. Please try again.');
                return;
            }

            currentEmployeeData = responseBody.data;
            console.log(`[${FUNCTION_NAME}] Employee data loaded successfully.`);
            
            // If departments are already loaded, populate the form
            if (departmentsData.length > 0) {
                populateEmployeeForm(currentEmployeeData);
            }
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
                showErrorState(err.friendlyMessage || 'Error loading employee data.');
                return;
            }

            console.error(`[${FUNCTION_NAME}] Unexpected error loading employee data:`, {
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

    function loadDepartmentsAndRoles() {
        const FUNCTION_NAME = 'loadDepartmentsAndRoles';
        const ENDPOINT = 'departments/with-roles';
        const TIMEOUT_MS = 10000;
        
        console.log(`[${FUNCTION_NAME}] Loading departments with roles`);

        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), TIMEOUT_MS);

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
                        console.error(`[${FUNCTION_NAME}] Response is not valid JSON:`, {
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
                hasData: !!responseBody.data
            });

            if (!responseBody || !responseBody.success || !responseBody.data) {
                console.error(`[${FUNCTION_NAME}] Invalid response structure!`, responseBody);
                showErrorState(responseBody?.friendly_message || 'Invalid server response. Please try again.');
                return;
            }

            departmentsData = responseBody.data;
            populateDepartmentSelect(departmentsData);
            console.log(`[${FUNCTION_NAME}] Departments and roles loaded successfully.`);
            
            // If employee data is already loaded, populate the form
            if (currentEmployeeData) {
                populateEmployeeForm(currentEmployeeData);
            }
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
                showErrorState(err.friendlyMessage || 'Error loading departments and roles.');
                return;
            }

            console.error(`[${FUNCTION_NAME}] Unexpected error:`, {
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

    function saveEmployeeChanges() {
        const FUNCTION_NAME = 'saveEmployeeChanges';
        const ENDPOINT = 'employees/update';
        const TIMEOUT_MS = 10000;
        
        console.log(`[${FUNCTION_NAME}] Saving changes for employee ID: ${employeeID}`);

        // Validate form data
        const form = document.getElementById('employeeForm');
        const formData = new FormData(form);

        // Validate required fields
        const firstName = formData.get('first_name').trim();
        const lastName = formData.get('last_name').trim();
        const birthday = formData.get('birthday');
        const email = formData.get('email').trim();
        const phoneNumber = formData.get('phone_number').trim();
        const salary = parseFloat(formData.get('salary'));
        const departmentId = parseInt(formData.get('department_id'));
        const roleId = parseInt(formData.get('role_id'));

        if (!firstName || !lastName || !birthday || !email || !phoneNumber) {
            alert('Please fill in all required fields');
            return;
        }

        if (isNaN(salary) || salary < 0) {
            alert('Please enter a valid salary amount');
            return;
        }

        if (isNaN(departmentId) || departmentId <= 0) {
            alert('Please select a valid department');
            return;
        }

        if (isNaN(roleId) || roleId <= 0) {
            alert('Please select a valid role');
            return;
        }

        if (!confirm('Are you sure you want to save these changes?')) {
            return;
        }

        // Handle optional secondary phone
        const secondPhoneValue = formData.get('second_phone_number');
        const secondPhone = secondPhoneValue?.trim() || undefined;


        const employeeData = {
            id: parseInt(employeeID),
            first_name: firstName,
            last_name: lastName,
            birthday: birthday,
            email: email,
            phone_number: phoneNumber,
            salary: salary,
            address: formData.get('address') ? formData.get('address').trim() : '',
            department_id: departmentId,
            role_id: roleId
        };

        // Only add secondary_phone if it is not undefined
        if (secondPhone !== undefined) {
            employeeData.second_phone_number = secondPhone;
        }

        const saveBtn = document.getElementById('saveBtn');
        const cancelBtn = document.getElementById('cancelBtn');
        const originalSaveText = saveBtn.innerHTML;

        // Visual feedback
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving Changes...';
        saveBtn.disabled = true;
        cancelBtn.style.display = 'none';

        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), TIMEOUT_MS);

        console.log(`[${FUNCTION_NAME}] Sending data:`, employeeData);

        return fetch(ENDPOINT, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(employeeData),
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
        .then(function handleSuccess(responseBody) {
            if (!responseBody || !responseBody.success) {
                console.error(`[${FUNCTION_NAME}] Invalid response structure!`, responseBody);
                showErrorState(responseBody?.friendly_message || 'Invalid server response. Please try again.');
                return;
            }  
            
            console.log(`[${FUNCTION_NAME}] Employee updated successfully.`);
            showSaveSuccessState(responseBody.message || 'Employee successfully updated.');
        })
        .catch(function handleFetchError(err) {
            clearTimeout(timeoutId);

            if (err && err.name === 'AbortError') {
                console.error(`[${FUNCTION_NAME}] Timeout after ${TIMEOUT_MS}ms`);
                alert('Request timed out. Please try again.');
                restoreButtons(saveBtn, cancelBtn, originalSaveText);
                return;
            }

            if (err.type && (err.type === 'API_ERROR' || err.type === 'HTTP_ERROR')) {
                console.error(`[${FUNCTION_NAME}] Error occurred | Status: ${err.status || 'N/A'} | Type: ${err.type}`);
                
                // Show error message
                const errorMessage = err.friendlyMessage || 'Error updating employee.';
                showFormState(); // Ensure form is visible
                alert(errorMessage);
                restoreButtons(saveBtn, cancelBtn, originalSaveText);
                return;
            }

            console.error(`[${FUNCTION_NAME}] Unexpected error:`, {
                name: err.name,
                message: err.message,
            });

            alert('An unexpected error occurred. Please check your connection and try again.');
            restoreButtons(saveBtn, cancelBtn, originalSaveText);
        })
        .finally(() => {
            clearTimeout(timeoutId);
            console.log(`[${FUNCTION_NAME}] Completed`);
        });
    }

    // ============================================
    // DATA MANAGEMENT FUNCTIONS
    // ============================================

    function populateDepartmentSelect(departments) {
        const departmentSelect = document.getElementById('department');
        departmentSelect.innerHTML = '<option value="">Select Department</option>';

        departments.forEach(dept => {
            const option = document.createElement('option');
            option.value = dept.department_id;
            option.textContent = dept.department_display;
            option.setAttribute('data-roles', JSON.stringify(dept.roles));
            departmentSelect.appendChild(option);
        });
    }

    function populateRoleSelect(roles) {
        const roleSelect = document.getElementById('role');
        roleSelect.innerHTML = '<option value="">Select Role</option>';

        if (roles && roles.length > 0) {
            roles.forEach(role => {
                const option = document.createElement('option');
                option.value = role.role_id;
                option.textContent = role.role_name;
                roleSelect.appendChild(option);
            });
        }
    }

    function setSelectedDepartmentAndRole() {
        if (!currentEmployeeData) return;

        const departmentSelect = document.getElementById('department');
        const roleSelect = document.getElementById('role');

        // Find current department
        const currentDept = departmentsData.find(dept =>
            dept.department_id == currentEmployeeData.department_id
        );

        if (currentDept) {
            // Select department
            departmentSelect.value = currentDept.department_id;

            // Load roles for this department
            const roles = currentDept.roles;
            populateRoleSelect(roles);

            // Select current role
            if (currentEmployeeData.role_id) {
                roleSelect.value = currentEmployeeData.role_id;
            }
        }
    }

    function populateEmployeeForm(employee) {
        console.log('Populating form with employee data:', employee);

        showFormState();

        // Personal information
        document.getElementById('firstName').value = employee.first_name || '';
        document.getElementById('lastName').value = employee.last_name || '';
        document.getElementById('birthday').value = formatDateForInput(employee.birthday) || '';
        document.getElementById('email').value = employee.email || '';
        document.getElementById('phoneNumber').value = employee.phone_number || '';
        document.getElementById('secondPhoneNumber').value = employee.second_phone_number || '';

        // Professional information
        document.getElementById('salary').value = employee.salary || '';
        document.getElementById('hireDate').value = formatDateForInput(employee.hire_date) || '';
        document.getElementById('address').value = employee.address || '';

        // Set department and role
        setSelectedDepartmentAndRole();
    }

    function restoreButtons(saveBtn, cancelBtn, originalSaveText) {
        saveBtn.innerHTML = originalSaveText;
        saveBtn.disabled = false;
        cancelBtn.style.display = 'block';
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
        if (!unsafe) return '';
        return unsafe
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    function formatDateForInput(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        if (isNaN(date.getTime())) return dateString;

        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        return `${year}-${month}-${day}`;
    }
</script>
HTML;

include __DIR__ . '/../layouts/main.php';