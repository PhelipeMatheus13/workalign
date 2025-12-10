<?php
$pageTitle = "Edit Department";
$styles = <<<'HTML'
<style>
   html,
   body {
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

   .department-card {
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

   .form-control,
   .form-select {
      border: 1px solid #ced4da;
      border-radius: 4px;
      padding: 8px 12px;
      font-size: 1rem;
      color: #2c3e50;
   }

   .form-control:focus,
   .form-select:focus {
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

      .info-grid-compact {
         grid-template-columns: 1fr;
         gap: 15px;
      }

      .department-card {
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
      <h1 class="page-title">Edit Department</h1>
      <div class="header-actions">
         <a href="departments">
            <button type="button" class="btn btn-back btn-sm">
               <i class="fas fa-arrow-left"></i> Back to Departments
            </button>
         </a>
      </div>
   </div>

   <!-- Edit department card -->
   <div class="department-card" id="departmentCard">
      <div class="loading" id="loadingState">
         <div class="loading-spinner"></div>
         <p>Loading department data...</p>
      </div>

      <form id="departmentForm" style="display: none;">
         <!-- Basic information -->
         <div class="info-section">
            <h3 class="section-title">Department Information</h3>
            <div class="info-grid-compact">
               <div class="info-item">
                  <div class="info-label">Department Name *</div>
                  <input type="text" class="form-control" id="name" name="name" required>
               </div>
               <div class="info-item">
                  <div class="info-label">Short Name</div>
                  <input type="text" class="form-control" id="shortName" name="short_name">
               </div>
               <div class="info-item">
                  <div class="info-label">Status *</div>
                  <select class="form-select" id="status" name="status" required>
                     <option value="">Select Status</option>
                     <option value="active">Active</option>
                     <option value="inactive">Inactive</option>
                     <option value="under_reconstruction">Under Reconstruction</option>
                  </select>
               </div>
            </div>
         </div>

         <!-- Description -->
         <div class="info-section">
            <h3 class="section-title">Description</h3>
            <div class="info-item">
               <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
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

      // Get department ID from URL
      const urlParams = new URLSearchParams(window.location.search);
      const departmentId = urlParams.get('id');

      if (departmentId) {
         loadDepartmentData(departmentId);
      } else {
         showError('Department ID is missing in the URL.');
      }

      // Event listeners
      document.getElementById('cancelBtn').addEventListener('click', function () {
         if (confirm('Are you sure you want to cancel? Any unsaved changes will be lost.')) {
            window.location.href = 'departments';
         }
      });

      document.getElementById('departmentForm').addEventListener('submit', function (e) {
         e.preventDefault();
         saveDepartmentChanges(departmentId);
      });

      // Load department data
      function loadDepartmentData(departmentId) {
         fetch(`departments/get?id=${departmentId}`)
            .then(response => {
               if (!response.ok) {
                  // If the response is not ok, we try to read the error message from the JSON.
                  return response.json().then(errorData => {
                     throw new Error(errorData.error || `HTTP ${response.status}: ${response.statusText}`);
                  });
               }
               return response.json();
            })
            .then(response => {
               if (response.success) {
                  populateDepartmentForm(response.data);
               } else {
                  throw new Error(response.error || 'Failed to load department data');
               }
            })
            .catch(error => {
               console.error('Error:', error);
               showError('Error loading department data: ' + error.message);
            });
      }

      // Populate department form
      function populateDepartmentForm(department) {
         document.getElementById('loadingState').style.display = 'none';
         document.getElementById('departmentForm').style.display = 'block';

         document.getElementById('name').value = department.name || '';
         document.getElementById('shortName').value = department.short_name || '';
         document.getElementById('description').value = department.description || '';
         document.getElementById('status').value = department.status || '';
      }

      // Save department changes
      function saveDepartmentChanges(departmentId) {
         if (!confirm('Are you sure you want to save these changes?')) {
            return;
         }

         const form = document.getElementById('departmentForm');
         const formData = new FormData(form);
         const saveBtn = document.getElementById('saveBtn');
         const cancelBtn = document.getElementById('cancelBtn');

         // Validate data before sending.
         const name = formData.get('name').trim();
         const shortName = formData.get('short_name').trim();
         const status = formData.get('status');
         const description = formData.get('description').trim();

         if (!name || !status || !description) {
            showError('Please fill in all required fields');
            return;
         }

         const departmentData = {
            id: parseInt(departmentId),
            name: name,
            short_name: shortName,
            description: description,
            status: status
         };

         const originalSaveText = saveBtn.innerHTML;

         // Immediate visual feedback
         saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving Changes...';
         saveBtn.disabled = true;

         // Hide the cancel button after confirming changes. 
         cancelBtn.style.display = 'none';

         console.log('Sending data:', departmentData);

         // CORREÇÃO: Enviar para a rota correta do controller
         fetch('departments/update', {
            method: 'PUT',
            headers: {
               'Content-Type': 'application/json',
            },
            body: JSON.stringify(departmentData)
         })
         .then(response => {
            // Primeiro, verificar se a resposta é HTML
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
            let errorMessage = 'Error updating department: ';
            
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
         const departmentCard = document.getElementById('departmentCard');
         departmentCard.innerHTML = `<div class="error-message">${message}</div>`;
      }

      function showSuccess(message) {
         const departmentCard = document.getElementById('departmentCard');
         const successDiv = document.createElement('div');
         successDiv.className = 'success-message';
         successDiv.innerHTML = `<i class="fas fa-check-circle"></i> ${message}`;
         departmentCard.insertBefore(successDiv, departmentCard.firstChild);
      }
   });
</script>
HTML;

include __DIR__ . '/../layouts/main.php';