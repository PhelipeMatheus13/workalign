<?php
$pageTitle = "Edit Role";
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

   .role-card {
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      padding: 30px;
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

   .form-control {
      border: 1px solid #ced4da;
      border-radius: 4px;
      padding: 8px 12px;
      font-size: 1rem;
      color: #2c3e50;
   }

   .form-control:focus {
      border-color: #007bff;
      box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
   }

   textarea.form-control {
      min-height: 120px;
      resize: vertical;
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

      .role-card {
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
      <h1 class="page-title">Edit Role</h1>
      <div class="header-actions">
         <a href="app/Views/departments_roles.php" id="backLink">
            <button type="button" class="btn btn-back btn-sm">
               <i class="fas fa-arrow-left"></i> Back to Roles
            </button>
         </a>
      </div>
   </div>

   <!-- Role editing card -->
   <div class="role-card" id="roleCard">
      <div class="loading" id="loadingState">
         <div class="loading-spinner"></div>
         <p>Loading role data...</p>
      </div>

      <form id="roleForm" style="display: none;">
         <!-- Basic information -->
         <div class="info-section">
            <h3 class="section-title">Role Information</h3>
            <div class="info-item">
               <div class="info-label">Role Name *</div>
               <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="info-item">
               <div class="info-label">Description *</div>
               <textarea class="form-control" id="description" name="description" rows="4"
                  required></textarea>
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
         if (item.getAttribute('data-menu') === 'departments') {
            item.classList.add('active');
         }
      });

      localStorage.setItem('activeMenu', 'departments');

      // Get role ID from URL
      const urlParams = new URLSearchParams(window.location.search);
      const roleId = urlParams.get('id');
      const departmentId = urlParams.get('department_id');

      document.getElementById('backLink').href = departmentId
         ? `departments/show?id=${departmentId}`
         : 'departments';

      // Update back link to include department_id
      if (departmentId) {
         document.getElementById('backLink').href = `departments/show?id=${departmentId}`;
      }

      if (roleId) {
         loadRoleData(roleId);
      } else {
         showError('Role ID is missing in the URL.');
      }

      // Event listeners
      document.getElementById('cancelBtn').addEventListener('click', function () {
         if (confirm('Are you sure you want to cancel? Any unsaved changes will be lost.')) {
            if (departmentId) {
               window.location.href = `departments/show?id=${departmentId}`;
            } else {
               window.location.href = 'departments';
            }
         }
      });

      document.getElementById('roleForm').addEventListener('submit', function (e) {
         e.preventDefault();
         saveRoleChanges();
      });

      // Load role data
      function loadRoleData(roleId) {
         fetch(`departments/roles/get?id=${roleId}`)
            .then(response => {
               if (!response.ok) {
                  return response.json().then(errorData => {
                     throw new Error(errorData.error || `HTTP ${response.status}: ${response.statusText}`);
                  });
               }
               return response.json();
            })
            .then(response => {
               if (response.success) {
                  populateRoleForm(response.data);
               } else {
                  throw new Error(response.error || 'Failed to load role data');
               }
            })
            .catch(response => {
               console.error('Error:', response.error);
               showError('Error loading role data: ' + response.message);
            });
      }

      // Populate role form
      function populateRoleForm(role) {
         document.getElementById('loadingState').style.display = 'none';
         document.getElementById('roleForm').style.display = 'block';

         document.getElementById('name').value = role.name || '';
         document.getElementById('description').value = role.description || '';
      }

      // Save role changes
      function saveRoleChanges() {
         if (!confirm('Are you sure you want to save these changes?')) {
            return;
         }

         const form = document.getElementById('roleForm');
         const formData = new FormData(form);
         const saveBtn = document.getElementById('saveBtn');
         const cancelBtn = document.getElementById('cancelBtn');

         // Validate data before sending.
         const name = formData.get('name').trim();
         const description = formData.get('description').trim();

         if (!name) {
            showError('Please fill in the role name');
            return;
         }

         if (!description) {
            showError('Please fill in the role description');
            return;
         }

         const roleData = {
            id: parseInt(roleId),
            department_id: parseInt(departmentId),
            name: name,
            description: description
         };

         const originalSaveText = saveBtn.innerHTML;

         // Immediate feedback
         saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving Changes...';
         saveBtn.disabled = true;

         // Hide the cancel button after confirming changes.
         cancelBtn.style.display = 'none';

         console.log('Sending data:', roleData);

         fetch('departments/roles/update', {
            method: 'PUT',
            headers: {
                  'Content-Type': 'application/json',
            },
            body: JSON.stringify(roleData)
         })
         .then(response => {
            const contentType = response.headers.get('content-type');
            
            if (contentType && contentType.includes('text/html')) {
                  return response.text();
            } else {
                  return response.text().then(text => {
                     throw new Error(`Unexpected response type. Expected HTML, got: ${contentType}`);
                  });
            }
         })
         .then(html => {
            document.open();
            document.write(html);
            document.close();
         })
         .catch(error => {
            console.error('Error:', error);
            let errorMessage = 'Error updating role: ';
            
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

      function showError(message) {
         document.getElementById('loadingState').style.display = 'none';
         const roleCard = document.getElementById('roleCard');
         roleCard.innerHTML = `<div class="error-message">${message}</div>`;
      }

      function showSuccess(message) {
         const roleCard = document.getElementById('roleCard');
         const successDiv = document.createElement('div');
         successDiv.className = 'success-message';
         successDiv.innerHTML = `<i class="fas fa-check-circle"></i> ${message}`;
         roleCard.insertBefore(successDiv, roleCard.firstChild);
      }
   });
</script>
HTML;

include __DIR__ . '/../../layouts/main.php';