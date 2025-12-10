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
      <div class="loading-spinner"></div>
      Loading department...
   </h2>

   <div id="rolesCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
      <div class="carousel-inner" id="carouselInner">
            <!-- Dynamic content -->
            <div class="loading">
               <div class="loading-spinner"></div>
               <p>Loading roles...</p>
            </div>
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
   let departmentId;
   let employeesTable;



   function showError(message) {
      $('#departmentTitle').html(`<div class="error-message">Error Loading Department</div>`);
      $('#carouselInner').html(`<div class="error-message">${message}</div>`);
      if (employeesTable && typeof employeesTable.clear === 'function') {
         employeesTable.clear().draw();
      }
   }

   function loadDepartmentRolesData(departmentId) {
      fetch(`departments/roles/list?id=${departmentId}`)
         .then(response => {
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
               return response.text().then(text => {
                  if (text.includes('<html') || text.includes('<!DOCTYPE')) {
                     throw new Error('Server returned HTML instead of JSON. Check if PHP file exists and is accessible.');
                  }
                  throw new Error(`Expected JSON but got: ${text.substring(0, 100)}`);
               });
            }
            return response.json();
         })
         .then(data => {
            if (data.error) {
               throw new Error(data.error);
            }
            renderDepartmentData(data);
         })
         .catch(error => {
            console.error('Error:', error);
            showError('Failed to load department data: ' + error.message);
         });
   }

   function renderDepartmentData(data) {
      const roles = data.data;
      
   
      fetch(`departments/get?id=${departmentId}`)
         .then(response => response.json())
         .then(deptData => {
            if (deptData.success) {
               $('#departmentTitle').text(deptData.data.name);
            } else {
               $('#departmentTitle').text('Department');
            }
         })
         .catch(error => {
            console.error('Error loading department name:', error);
            $('#departmentTitle').text('Department');
         });

      renderRolesCarousel(roles);

      // Automatically loads employees from the first position.
      if (roles.length > 0) {
         loadEmployeesForRole(roles[0].id);
      } else {
         if (employeesTable) {
            employeesTable.clear().draw();
         }
      }
   }

   function renderRolesCarousel(roles) {
      const carouselInner = $('#carouselInner');
      const carouselIndicators = $('#carouselIndicators');

      carouselInner.empty();
      carouselIndicators.empty();

      // If no function is found
      if (roles.length === 0) {
         carouselInner.html(`
            <div class="no-data">
               <h3>Not Found</h3>
               <p>No functions found for the department.</p>
            </div>
         `);
         return;
      }

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
         loadEmployeesForRole(activeRoleId);

         $('.carousel-indicators li').removeClass('active');
         $('.carousel-indicators li[data-slide-to="' + $(e.relatedTarget).index() + '"]').addClass('active');
      });

      attachRoleEventListeners();
   }

   // Research and select employees for a specific role.
   function loadEmployeesForRole(roleId) {
      if (!employeesTable) return;

      employeesTable.clear().draw();
      employeesTable.rows.add([['Loading...', '', '', '', '']]).draw();

      fetch(`employees/list-by-role?role_id=${roleId}`)
         .then(response => {
            const contentType = response.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
               return response.text().then(text => {
                  throw new Error(`Expected JSON but got: ${text.substring(0, 100)}`);
               });
            }
            return response.json();
         })
         .then(data => {
            if (data.error) {
               throw new Error(data.error);
            }
            updateEmployeesTable(data.data);
         })
         .catch(error => {
            console.error('Error:', error);
            employeesTable.clear().draw();
            employeesTable.rows.add([['Error loading employees', '', '', '', '']]).draw();
         });
   }

   function updateEmployeesTable(employees) {
      if (!employeesTable) return;

      employeesTable.clear();

      if (employees.length === 0) {
         employeesTable.rows.add([['No employees found for this role', '', '', '', '']]).draw();
         return;
      }

      employees.forEach(function (employee) {
         var actionsHtml = '<div class="table-actions">' +
            '<button class="btn btn-view btn-sm" data-id="' + employee.id + '" title="View">' +
            '<i class="fas fa-eye"></i>' +
            '</button>' +
            '<button class="btn btn-delete btn-sm" data-id="' + employee.id + '" title="Delete">' +
            '<i class="fas fa-trash"></i>' +
            '</button>' +
            '</div>';

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

   function deleteRole(roleId) {
      if (confirm('Are you sure you want to delete this role?')) {
         fetch('departments/roles/delete', {
            method: 'DELETE',
            headers: {
               'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: roleId })
         })
            .then(response => response.json())
            .then(data => {
               if (data.success) {
                  alert('Role deleted successfully!');
                  loadDepartmentRolesData(departmentId);
               } else {
                  alert('Error deleting role: ' + data.error);
               }
            })
            .catch(error => {
               console.error('Error:', error);
               alert('Error deleting role: ' + error.message);
            });
      }
   }

   function deleteEmployee(employeeId) {
      if (confirm('Are you sure you want to delete this employee? This action cannot be undone.')) {
         const deleteBtn = $(`.btn-delete[data-id="${employeeId}"]`);
         const originalHtml = deleteBtn.html();
         deleteBtn.html('<i class="fas fa-spinner fa-spin"></i>');
         deleteBtn.prop('disabled', true);

         fetch('employees/delete', {
            method: 'DELETE',
            headers: {
               'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: employeeId })
         })
            .then(response => response.json())
            .then(data => {
               if (data.success) {
                  loadDepartmentRolesData(departmentId);

                  const activeRoleId = $('.carousel-item.active').data('role-id');
                  loadEmployeesForRole(activeRoleId);

                  showNotification('Employee deleted successfully!', 'success');
               } else {
                  throw new Error(data.error || 'Failed to delete employee');
               }
            })
            .catch(error => {
               console.error('Error:', error);
               showNotification('Error deleting employee: ' + error.message, 'error');
            })
            .finally(() => {
               deleteBtn.html(originalHtml);
               deleteBtn.prop('disabled', false);
            });
      }
   }

   function attachRoleEventListeners() {
      $('.edit-role-btn').on('click', function (e) {
         e.stopPropagation();
         const roleId = $(this).data('role-id');
         window.location.href = `departments/roles/update?id=${roleId}&department_id=${departmentId}`;
      });

      $('.delete-role-btn').on('click', function (e) {
         e.stopPropagation();
         const roleId = $(this).data('role-id');
         deleteRole(roleId);
      });
   }

   function showNotification(message, type) {
      const notification = $(`<div class="alert alert-${type} alert-dismissible fade show" role="alert">
         ${message}
         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
         </button>
      </div>`);
      
      $('.container').prepend(notification);
      setTimeout(() => notification.alert('close'), 3000);
   }

   $(document).ready(function () {
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

      const menuItems = document.querySelectorAll('.menu-item, #navbarMobileMenu .nav-link');
      menuItems.forEach(item => {
         item.classList.remove('active');
         if (item.getAttribute('data-menu') === 'departments') {
            item.classList.add('active');
         }
      });

      localStorage.setItem('activeMenu', 'departments');

      const urlParams = new URLSearchParams(window.location.search);
      departmentId = urlParams.get('id'); 

      if (!departmentId) {
         showError('Department ID is missing in the URL.');
         return;
      }

      // Update the "New Role" link with the departmentId.
      const newRoleBtn = document.querySelector('.new-role-btn');
      if (newRoleBtn && departmentId) {
         const link = newRoleBtn.closest('a');
         link.href = `departments/roles/create?department_id=${departmentId}`;
         console.log('New Role link updated to:', link.href);
      }

      loadDepartmentRolesData(departmentId);

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
   });
   
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