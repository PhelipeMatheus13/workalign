<?php
$pageTitle = "Employee Details";
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

    .info-value {
        color: #2c3e50;
        font-size: 1rem;
        font-weight: 500;
    }

    .info-value.empty {
        color: #bdc3c7;
        font-style: italic;
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

    .btn-back {
        background-color: #6c757d;
        border-color: #6c757d;
        color: white;
    }

    .btn-edit {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
    }

    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        border-radius: 4px;
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
    }
</style>
HTML;

$content = <<<'HTML'
<div class="content-container">
    <div class="page-header">
        <h1 class="page-title">Employee Details</h1>
        <div class="header-actions">
            <a href="employees">
                <button type="button" class="btn btn-back btn-sm">
                    <i class="fas fa-arrow-left"></i> Back
                </button>
            </a>
            <button type="button" class="btn btn-edit btn-sm" id="editEmployeeBtn">
                <i class="fas fa-edit"></i> Edit
            </button>
        </div>
    </div>

    <!-- Employee details card -->
    <div class="employee-card" id="employeeCard">
        <div class="loading" id="loadingState">
            <div class="loading-spinner"></div>
            <p>Loading employee data...</p>
            <p style="font-size: 0.9rem; color: #6c757d;">Please wait while we load the employee information.</p>
        </div>

        <div id="employeeContent" style="display: none;">
            <!-- Personal Information -->
            <div class="info-section">
                <h3 class="section-title">Personal Information</h3>
                <div class="info-grid-compact">
                    <div class="info-item">
                        <div class="info-label">First Name</div>
                        <div class="info-value" id="firstName">-</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Last Name</div>
                        <div class="info-value" id="lastName">-</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Date of Birth</div>
                        <div class="info-value" id="birthday">-</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email Address</div>
                        <div class="info-value" id="email">-</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Primary Phone</div>
                        <div class="info-value" id="phoneNumber">-</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Secondary Phone</div>
                        <div class="info-value empty" id="secondPhoneNumber">Not provided</div>
                    </div>
                </div>
            </div>

            <!-- Professional Information -->
            <div class="info-section">
                <h3 class="section-title">Professional Information</h3>
                <div class="info-grid-compact">
                    <div class="info-item">
                        <div class="info-label">Department</div>
                        <div class="info-value" id="department">-</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Role</div>
                        <div class="info-value" id="role">-</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Salary</div>
                        <div class="info-value" id="salary">-</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Hire Date</div>
                        <div class="info-value" id="hireDate">-</div>
                    </div>
                </div>
            </div>

            <!-- Address -->
            <div class="info-section">
                <h3 class="section-title">Address</h3>
                <div class="info-item">
                    <div class="info-value" id="address">-</div>
                </div>
            </div>
        </div>
    </div>
</div>
HTML;

$inlineScript = <<<'HTML'
<script>
    // ============================================
    // INITIALIZATION
    // ============================================
    
    document.addEventListener('DOMContentLoaded', function () {
        console.log('Employee Details Page');

        const urlParams = new URLSearchParams(window.location.search);
        const employeeID = urlParams.get('id');

        if (!employeeID) {
            showErrorState('Employee ID is missing in the URL.');
            console.error('Employee ID is missing in the URL');
            return;
        }

        console.log('Loading employee data for ID:', employeeID);

        // Attach event listeners
        document.getElementById('editEmployeeBtn').addEventListener('click', function () {
            window.location.href = `employees/update?id=${employeeID}`;
        });

        // Load employee data
        showLoadingState();
        loadEmployeeData(employeeID);
    });

    // ============================================
    // UI STATE MANAGEMENT FUNCTIONS
    // ============================================

    function showLoadingState() {
        const loadingState = document.getElementById('loadingState');
        const employeeContent = document.getElementById('employeeContent');
        
        loadingState.style.display = 'block';
        employeeContent.style.display = 'none';
    }

    function showErrorState(message) {
        const loadingState = document.getElementById('loadingState');
        const employeeContent = document.getElementById('employeeContent');
        const employeeCard = document.getElementById('employeeCard');
        
        loadingState.style.display = 'none';
        employeeContent.style.display = 'none';
        
        employeeCard.innerHTML = `
            <div class="error-message">
                <i class="fas fa-exclamation-circle fa-2x" style="margin-bottom: 15px;"></i>
                <h4 style="color: #c0392b; margin-bottom: 10px;">Unable to Load Employee Data</h4>
                <p>${escapeHtml(message)}</p>
                <button class="btn btn-primary retry-btn" style="margin-top: 15px;">
                    <i class="fas fa-redo"></i> Try Again
                </button>
            </div>
        `;
        
        // Add retry button functionality
        setTimeout(() => {
            document.querySelector('.retry-btn')?.addEventListener('click', function() {
                const urlParams = new URLSearchParams(window.location.search);
                const employeeID = urlParams.get('id');
                
                if (employeeID) {
                    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Trying...';
                    this.disabled = true;
                    showLoadingState();
                    setTimeout(() => loadEmployeeData(employeeID), 1000);
                }
            });
        }, 100);
    }

    function showEmployeeData() {
        const loadingState = document.getElementById('loadingState');
        const employeeContent = document.getElementById('employeeContent');
        
        loadingState.style.display = 'none';
        employeeContent.style.display = 'block';
    }

    // ============================================
    // API CALL FUNCTIONS (Standard Pattern)
    // ============================================

    function loadEmployeeData(employeeID) {
        const FUNCTION_NAME = 'loadEmployeeData';
        const ENDPOINT = `employees/get?id=${employeeID}`;
        const TIMEOUT_MS = 10000;
        
        console.log(`[${FUNCTION_NAME}] Loading employee data for ID: ${employeeID}`);

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
                data: responseBody.data
            });

            if (!responseBody || !responseBody.success || !responseBody.data) {
                console.error(`[${FUNCTION_NAME}] Invalid response structure!`, responseBody);
                showErrorState(responseBody?.friendly_message || 'Invalid server response. Please try again.');
                return;
            }

            console.log(`[${FUNCTION_NAME}] Employee data loaded successfully.`);
            return populateEmployeeData(responseBody.data || responseBody.employee);
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

    // ============================================
    // DATA MANAGEMENT FUNCTIONS
    // ============================================

    function populateEmployeeData(employee) {
        FUNCTION_NAME = 'populateEmployeeData';
        console.log(`[${FUNCTION_NAME}] Populate form with employee Data:`, employee);
        
        if (!employee) {
            throw new Error('Employee data is undefined');
        }

        showEmployeeData();

        document.getElementById('firstName').textContent = employee.first_name || '-';
        document.getElementById('lastName').textContent = employee.last_name || '-';
        document.getElementById('birthday').textContent = formatDate(employee.birthday) || '-';
        document.getElementById('email').textContent = employee.email || '-';
        document.getElementById('phoneNumber').textContent = formatPhone(employee.phone_number) || '-';

        const secondPhone = document.getElementById('secondPhoneNumber');

        // Default to "Not provided"
        secondPhone.textContent = 'Not provided';
        secondPhone.classList.add('empty');

        if (employee.second_phone_number) {
            secondPhone.textContent = formatPhone(employee.second_phone_number);
            secondPhone.classList.remove('empty');
        }

        document.getElementById('department').textContent = employee.department_name || '-';
        document.getElementById('role').textContent = employee.role_name || '-';
        document.getElementById('salary').textContent = employee.salary ? `$${parseFloat(employee.salary).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}` : '-';
        document.getElementById('hireDate').textContent = formatDate(employee.hire_date) || '-';
        document.getElementById('address').textContent = employee.address || '-';
        
        console.log(`[${FUNCTION_NAME}] Employee data populated successfully.`);
    }

    // ============================================
    // UTILITY FUNCTIONS
    // ============================================

    function formatDate(dateString) {
        if (!dateString) return '';
        const date = new Date(dateString);
        if (isNaN(date.getTime())) return dateString;
        
        const day = String(date.getDate()).padStart(2, '0');
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const year = date.getFullYear();
        return `${day}/${month}/${year}`;
    }

    function formatPhone(phone) {
        if (!phone) return '';
        const cleaned = phone.replace(/\D/g, '');
        
        if (cleaned.length === 10) {
            return `(${cleaned.substring(0, 3)}) ${cleaned.substring(3, 6)}-${cleaned.substring(6)}`;
        }
        
        return phone;
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