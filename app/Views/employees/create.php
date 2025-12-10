<?php
$pageTitle = "New Employee";
$styles = <<<'HTML'
<link rel="stylesheet" href="https://cdn.datatables.net/2.3.4/css/dataTables.dataTables.css">
<style>
    body {
        overflow: hidden;
    }

    .col-md-9 {
        overflow-y: auto;
    }

    .card-employees {
        box-shadow: 2px 2px 10px rgba(0,0,0,0.1);
        padding: 10px;
        border-radius: 10px;
        margin: 10px; 
        background: white;
    }

    .form-title {
        margin-bottom: 20px;
        color: #2c3e50;
    }

    .form-actions {
        margin-top: 5px;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
    }
</style>
HTML;

$content = <<<'HTML'
<div class="row">
    <div class="col-md card-employees">
        <h3 class="form-title">Register New Employee</h3>
        <form id="employeeForm" action="employees/create" method="POST">
            <!-- First Name, Last Name, Date of Birth -->
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="first_name">First Name *</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter first name" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="last_name">Last Name *</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter last name" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="birthday">Date of Birth *</label>
                    <input type="date" class="form-control" id="birthday" name="birthday" required>
                </div>
            </div>

            <!-- Email and Phones -->
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="email">Email Address *</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email address" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="phone_number">Primary Phone *</label>
                    <input type="tel" class="form-control" id="phone_number" name="phone_number" placeholder="(123) 456-7890" required>
                </div>
                <div class="form-group col-md-3">
                    <label for="second_phone_number">Secondary Phone</label>
                    <input type="tel" class="form-control" id="second_phone_number" name="second_phone_number" placeholder="(123) 456-7890">
                    <small class="form-text text-muted">Optional</small>
                </div>
            </div>

            <!-- Address -->
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="address">Address *</label>
                    <input type="text" class="form-control" id="address" name="address" placeholder="Enter complete address" required>
                </div>
            </div>
            
            <!-- Salary, Department, Role -->
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="salary">Salary ($) *</label>
                    <input type="number" class="form-control" id="salary" name="salary" placeholder="0.00" step="0.01" min="0" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="department_id">Department *</label>
                    <select class="form-control" id="department" name="department_id" required>
                        <option value="">Loading departments...</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="role_id">Role *</label>
                    <select class="form-control" id="role" name="role_id" disabled required>
                        <option value="">Select Department First</option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="window.history.back()">Cancel</button>
                <button type="submit" class="btn btn-primary">Register Employee</button>
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
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Register employee page loaded - setting active menu');
        
        const menuItems = document.querySelectorAll('.menu-item, #navbarMobileMenu .nav-link');
        menuItems.forEach(item => {
            item.classList.remove('active');
            if (item.getAttribute('data-menu') === 'employees') {
                item.classList.add('active');
            }
        });
        
        localStorage.setItem('activeMenu', 'employees');

        loadDepartmentsAndRoles();
    });

    // Global variable for storing the data
    let departmentsData = [];

    function loadDepartmentsAndRoles() {
        console.log('Loading departments and roles...');
        showLoadingState();

        const departmentSelect = document.getElementById('department');
        const roleSelect = document.getElementById('role');
        

        fetch('departments/with-roles')
            .then(response => {
                if (!response.ok) {
                    return response.json()
                        .catch(() => {
                           // If response is not JSON, reject with status info
                           throw { status: response.status, message: response.statusText };
                        })
                        .then(errJson => {
                           // Reject with parsed error body
                           throw { status: response.status, body: errJson };
                        });
                }
                return response.json();
            })
            .then(payload => {             
                const valid = payload && payload.data && payload.data.length > 0;
                if (!valid) {
                    console.error('API returned an error payload:', payload)
                    showErrorState();
                    return;
                }   

                if(payload.success && (!payload.data || payload.data.length === 0)) {
                    console.log('No departments found in database');
                    showEmptyState();
                    return;
                }

                console.log('Received departments with role: ', payload.data);
                departmentsData = payload.data;
                populateDepartmentSelect();

            })
            .catch(error => {
                console.error('Error loading departments and roles:', error);
                showErrorState();
            });
    }

    // Show state of loading
    function showLoadingState() {
        const departmentSelect = document.getElementById('department');
        const roleSelect = document.getElementById('role');
        
        departmentSelect.innerHTML = `
            <option value="">
                <i class="fas fa-spinner fa-spin"></i> Loading departments...
            </option>
        `;
        roleSelect.innerHTML = '<option value="">Select department first</option>';
        roleSelect.disabled = true;
    }

    // Fill in the department selection form.
    function populateDepartmentSelect() {
        const departmentSelect = document.getElementById('department');
        
        // Clear previous options
        departmentSelect.innerHTML = '<option value="">Select Department</option>';
        
        // Add each department
        departmentsData.forEach(dept => {
            const option = document.createElement('option');
            option.value = dept.department_id;
            option.textContent = dept.department_display;
            option.setAttribute('data-full-name', dept.department_name);
            option.setAttribute('data-roles', JSON.stringify(dept.roles));
            departmentSelect.appendChild(option);
        });
        
        console.log('Department select populated with', departmentsData.length, 'options');
    }

    // Show empty state
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
        
        console.log('Empty state shown - no departments with roles found');
    }

    // Show error state
    function showErrorState() {
        const departmentSelect = document.getElementById('department');
        const roleSelect = document.getElementById('role');
        
        departmentSelect.innerHTML = `
            <option value="">
                <i class="fas fa-exclamation-triangle"></i> Error
            </option>
        `;
        departmentSelect.disabled = true;
        
        roleSelect.innerHTML = '<option value="">Error</option>';
        roleSelect.disabled = true;
        
        console.log('Error state shown - failed to load departments');
    }

    document.getElementById('department').addEventListener('change', function() {
        const roleSelect = document.getElementById('role');
        const selectedDeptId = this.value;
        
        // Clear previous options
        roleSelect.innerHTML = '<option value="">Select Role</option>';
        
        if (selectedDeptId) {
            // Enable and populate the role selection.
            roleSelect.disabled = false;
            
            const selectedOption = this.options[this.selectedIndex];
            const roles = JSON.parse(selectedOption.getAttribute('data-roles'));
            
            if (roles && roles.length > 0) {
                roles.forEach(role => {
                    const option = document.createElement('option');
                    option.value = role.role_id;
                    option.textContent = role.role_name;
                    roleSelect.appendChild(option);
                });
                console.log(`Populated role select with ${roles.length} roles for department ${selectedDeptId}`);
            } else {
                roleSelect.innerHTML = '<option value="">No roles available</option>';
                roleSelect.disabled = true;
                console.log('No roles found for selected department');
            }
        } else {
            // Disable if no department is selected.
            roleSelect.disabled = true;
            roleSelect.innerHTML = '<option value="">Select department first</option>';
        }
    });

    // Validate the form before submitting.
    document.getElementById('employeeForm').addEventListener('submit', function(e) {
        const departmentId = document.getElementById('department').value;
        const roleId = document.getElementById('role').value;
        
        if (!departmentId || !roleId) {
            e.preventDefault();
            alert('Please select both department and role before submitting.');
            return;
        }
        
        console.log('Form submitted with department_id:', departmentId, 'and role_id:', roleId);
    });
</script>
HTML;

include __DIR__ . '/../layouts/main.php';