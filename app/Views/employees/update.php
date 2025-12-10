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
        let currentEmployeeData = null;
        let departmentsData = [];

        if (employeeId) {
            loadEmployeeData(employeeId);
            loadDepartmentsAndRoles();
        } else {
            showError('Employee ID is missing in the URL.');
        }

        document.getElementById('cancelBtn').addEventListener('click', function () {
            if (confirm('Are you sure you want to cancel? Any unsaved changes will be lost.')) {
                window.location.href = `employees/show?id=${employeeId}`;
            }
        });

        document.getElementById('employeeForm').addEventListener('submit', function (e) {
            e.preventDefault();
            saveEmployeeChanges();
        });

        // Load employee data
        function loadEmployeeData(employeeId) {
            fetch(`employees/get?id=${employeeId}`)
                .then(response => {
                    if (!response.ok) {
                        return response.text().then(text => {
                            throw new Error(`HTTP ${response.status}: ${text.substring(0, 100)}`);
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Employee data response:', data); // DEBUG
                    if (data.success) {
                        // CORREÇÃO: Controller retorna data.data
                        const employeeData = data.data || data.employee;
                        if (!employeeData) {
                            throw new Error('Employee data not found in response');
                        }
                        currentEmployeeData = employeeData;
                        console.log('Current employee data:', currentEmployeeData); // DEBUG
                        
                        // Se os departamentos já carregaram, preenche o formulário
                        if (departmentsData.length > 0) {
                            console.log('Departments already loaded, populating form');
                            populateEmployeeForm(currentEmployeeData);
                        } else {
                            console.log('Waiting for departments to load...');
                        }
                    } else {
                        throw new Error(data.error || 'Failed to load employee data');
                    }
                })
                .catch(error => {
                    console.error('Error loading employee:', error);
                    showError('Error loading employee data: ' + error.message);
                });
        }

        // Load departments and roles
        function loadDepartmentsAndRoles() {
            fetch('departments/with-roles')
                .then(response => {
                    if (!response.ok) throw new Error('Network response was not ok');
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        departmentsData = data.data;
                        populateDepartmentSelect(data.data);
                        if (currentEmployeeData) {
                            populateEmployeeForm(currentEmployeeData);
                        }
                    } else {
                        throw new Error(data.error || 'Failed to load departments and roles');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showError('Error loading departments and roles: ' + error.message);
                });
        }

        // Populate department select
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

        // Populate role select based on department
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

        // Set selected department and role
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

        // Department change event
        document.getElementById('department').addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                const roles = JSON.parse(selectedOption.getAttribute('data-roles') || '[]');
                populateRoleSelect(roles);
            } else {
                populateRoleSelect([]);
            }
        });

        // Populate employee form
        function populateEmployeeForm(employee) {
            document.getElementById('loadingState').style.display = 'none';
            document.getElementById('employeeForm').style.display = 'block';

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

        // Save employee changes
        function saveEmployeeChanges() {
            if (!confirm('Are you sure you want to save these changes?')) {
                return;
            }

            const form = document.getElementById('employeeForm');
            const formData = new FormData(form);
            const saveBtn = document.getElementById('saveBtn');
            const cancelBtn = document.getElementById('cancelBtn');

            // Validate data before sending
            const salary = parseFloat(formData.get('salary'));
            if (isNaN(salary) || salary < 0) {
                showError('Please enter a valid salary amount');
                return;
            }

            const departmentId = parseInt(formData.get('department_id'));
            const roleId = parseInt(formData.get('role_id'));

            if (isNaN(departmentId) || departmentId <= 0) {
                showError('Please select a valid department');
                return;
            }

            if (isNaN(roleId) || roleId <= 0) {
                showError('Please select a valid role');
                return;
            }

            // Handle optional secondary phone
            const secondPhoneValue = formData.get('second_phone_number');
            let secondPhone;
            if (secondPhoneValue === null || secondPhoneValue === undefined) {
                secondPhone = undefined;
            } else {
                const trimmed = secondPhoneValue.trim();
                secondPhone = trimmed === '' ? undefined : trimmed;
            }

            const employeeData = {
                id: parseInt(employeeId),
                first_name: formData.get('first_name').trim(),
                last_name: formData.get('last_name').trim(),
                birthday: formData.get('birthday'),
                email: formData.get('email').trim(),
                phone_number: formData.get('phone_number').trim(),
                salary: salary,
                address: formData.get('address') ? formData.get('address').trim() : '',
                department_id: departmentId,
                role_id: roleId
            };

            // Only add secondary_phone if it is not undefined.
            if (secondPhone !== undefined) {
                employeeData.second_phone_number = secondPhone;
            }

            if (!employeeData.first_name || !employeeData.last_name || !employeeData.email ||
                !employeeData.phone_number || !employeeData.birthday) {
                showError('Please fill in all required fields');
                return;
            }

            const originalSaveText = saveBtn.innerHTML;

            // Immediate feedback
            saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving Changes...';
            saveBtn.disabled = true;

            // Hide the cancel button after confirming changes. 
            cancelBtn.style.display = 'none';

            console.log('Sending data:', employeeData);

            fetch('employees/update', {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(employeeData)
            })
            .then(response => {
                // Primeiro, verificar se a resposta é HTML (provavelmente será)
                const contentType = response.headers.get('content-type');
                
                if (contentType && contentType.includes('text/html')) {
                    // Se for HTML, retornar o texto HTML
                    return response.text();
                } else {
                    // Se não for HTML, tentar JSON como fallback
                    return response.json().then(data => {
                        throw new Error(`Unexpected response type. Expected HTML, got: ${contentType}`);
                    });
                }
            })
            .then(html => {
                // Substituir o conteúdo da página atual pelo HTML da resposta
                document.open();
                document.write(html);
                document.close();
            })
            .catch(error => {
                console.error('Error:', error);
                let errorMessage = 'Error updating employee: ';
                
                if (error.message.includes('Unexpected token')) {
                    errorMessage += 'Server returned invalid response. Please check server logs.';
                } else {
                    errorMessage += error.message;
                }

                // Restaurar botões em caso de erro
                saveBtn.innerHTML = originalSaveText;
                saveBtn.disabled = false;
                cancelBtn.style.display = 'block';
                showError(errorMessage);
            });
        }

        // Format date for input type="date"
        function formatDateForInput(dateString) {
            if (!dateString) return '';
            const date = new Date(dateString);
            if (isNaN(date.getTime())) return dateString;

            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        }

        function showError(message) {
            document.getElementById('loadingState').style.display = 'none';
            const employeeCard = document.getElementById('employeeCard');
            employeeCard.innerHTML = `<div class="error-message">${message}</div>`;
        }

        function showSuccess(message) {
            const employeeCard = document.getElementById('employeeCard');
            const successDiv = document.createElement('div');
            successDiv.className = 'success-message';
            successDiv.innerHTML = `<i class="fas fa-check-circle"></i> ${message}`;
            employeeCard.insertBefore(successDiv, employeeCard.firstChild);
        }
    });
</script>
HTML;

include __DIR__ . '/../layouts/main.php';
