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
    document.addEventListener('DOMContentLoaded', function () {
        const menuItems = document.querySelectorAll('.menu-item, #navbarMobileMenu .nav-link');
        menuItems.forEach(item => {
            item.classList.remove('active');
            if (item.getAttribute('data-menu') === 'employees') {
                item.classList.add('active');
            }
        });

        localStorage.setItem('activeMenu', 'employees');

        const urlParams = new URLSearchParams(window.location.search);
        const employeeId = urlParams.get('id');

        if (employeeId) {
            loadEmployeeData(employeeId);
        } else {
            showError('Employee ID is missing in the URL.');
        }

        // Edit button 
        document.getElementById('editEmployeeBtn').addEventListener('click', function () {
            if (employeeId) {
                window.location.href = `employees/update?id=${employeeId}`;
            } else {
                alert('Cannot edit: Employee ID not found');
            }
        });

        // Function to load employee data.
        function loadEmployeeData(employeeId) {
            fetch(`employees/get?id=${employeeId}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('API Response:', data); // DEBUG
                    if (data.success) {
                        // CORREÇÃO: Controller retorna data.data, não data.employee
                        const employeeData = data.data || data.employee;
                        if (!employeeData) {
                            throw new Error('Employee data is undefined');
                        }
                        populateEmployeeData(employeeData);
                    } else {
                        throw new Error(data.error || 'Failed to load employee data');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('Error loading employee data: ' + error.message);
                });
        }

        function populateEmployeeData(employee) {
            console.log('Employee Data:', employee); // DEBUG
            document.getElementById('loadingState').style.display = 'none';
            document.getElementById('employeeContent').style.display = 'block';

            document.getElementById('firstName').textContent = employee.first_name || '-';
            document.getElementById('lastName').textContent = employee.last_name || '-';
            document.getElementById('birthday').textContent = formatDate(employee.birthday) || '-';
            document.getElementById('email').textContent = employee.email || '-';
            document.getElementById('phoneNumber').textContent = formatPhone(employee.phone_number) || '-';

            const secondPhone = document.getElementById('secondPhoneNumber');
            if (employee.second_phone_number) {
                secondPhone.textContent = formatPhone(employee.second_phone_number);
                secondPhone.classList.remove('empty');
            } else {
                secondPhone.textContent = 'Not provided';
                secondPhone.classList.add('empty');
            }

            document.getElementById('department').textContent = employee.department_name || '-';
            document.getElementById('role').textContent = employee.role_name || '-';
            document.getElementById('salary').textContent = employee.salary ? `$${parseFloat(employee.salary).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}` : '-';
            document.getElementById('hireDate').textContent = formatDate(employee.hire_date) || '-';
            document.getElementById('address').textContent = employee.address || '-';
        }

        function showError(message) {
            document.getElementById('loadingState').style.display = 'none';
            const employeeCard = document.getElementById('employeeCard');
            employeeCard.innerHTML = `<div class="error-message">${message}</div>`;
        }

        // Function to format dates (from YYYY-MM-DD to DD/MM/YYYY)
        function formatDate(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            if (isNaN(date.getTime())) return dateString;
            
            const day = String(date.getDate()).padStart(2, '0');
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const year = date.getFullYear();
            return `${day}/${month}/${year}`;
        }

        // Function to format phone
        function formatPhone(phone) {
            if (!phone) return '';
            // Remove non-numeric characters
            const cleaned = phone.replace(/\D/g, '');
            
            // Format to (XXX) XXX-XXXX
            if (cleaned.length === 10) {
                return `(${cleaned.substring(0, 3)}) ${cleaned.substring(3, 6)}-${cleaned.substring(6)}`;
            }
            
            return phone;
        }
    });
</script>
HTML;

include __DIR__ .'/../layouts/main.php';