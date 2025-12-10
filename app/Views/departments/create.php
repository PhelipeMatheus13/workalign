<?php
$pageTitle = "New Department";
$styles = <<<'HTML'
<style>        
   html, body {
      margin: 0;
      padding: 0;
      height: 100%;
      overflow: hidden;
      background: #f6f9fb;
   }

   .col-md-9 {
      height: calc(100vh - 56px);
      padding: 20px;
      overflow-y: auto;
      background-color: #f8f9fa;
   }

   .form-card {
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
      padding: 30px;
      max-width: 800px;
      margin: 0 auto;
   }

   .form-title {
      color: #2c3e50;
      font-weight: 600;
      margin-bottom: 25px;
      padding-bottom: 15px;
      border-bottom: 1px solid #e9ecef;
   }

   .form-group label {
      color: #2c3e50;
      font-weight: 500;
      margin-bottom: 8px;
   }

   .form-control {
      border: 1px solid #ced4da;
      border-radius: 6px;
      padding: 10px 12px;
      transition: border-color 0.3s ease, box-shadow 0.3s ease;
   }

   .form-control:focus {
      border-color: #3498db;
      box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
   }

   textarea.form-control {
      min-height: 120px;
      resize: vertical;
   }

   .form-actions {
      display: flex;
      justify-content: flex-end;
      gap: 10px;
      margin-top: 30px;
      padding-top: 20px;
      border-top: 1px solid #e9ecef;
   }

   .btn {
      padding: 10px 20px;
      border-radius: 6px;
      font-weight: 600;
      transition: all 0.3s ease;
   }

   .btn-primary {
      background-color: #3498db;
      border-color: #3498db;
   }

   .btn-primary:hover {
      background-color: #2980b9;
      border-color: #2980b9;
   }

   .btn-secondary {
      background-color: #6c757d;
      border-color: #6c757d;
      color: white;
   }

   .btn-secondary:hover {
      background-color: #5a6268;
      border-color: #545b62;
   }

   .required::after {
      content: " *";
      color: #e74c3c;
   }

   @media (max-width: 768px) {
      .col-md-9 {
            padding: 10px;
      }

      .form-card {
            padding: 20px;
      }

      .form-actions {
            flex-direction: column;
      }

      .btn {
            width: 100%;
      }
   }
</style>
HTML;

$content = <<<'HTML'
<div class="form-card">
   <h3 class="form-title">Register New Department</h3>
   <form id="departmentForm" action="departments/create" method="POST">
      <!-- Department Name -->
      <div class="form-group">
            <label for="name" class="required">Name</label>
            <input type="text" class="form-control" id="department_name" name="name"
               placeholder="Enter department name" required>
      </div>

      <!-- Short name -->
      <div class="form-group">
            <label for="short_name">Short name</label>
            <input type="text" class="form-control" id="department_short_name"
               name="department_short_name" placeholder="Enter department short name (optional)">
      </div>

      <!-- Description -->
      <div class="form-group">
            <label for="description" class="required">Description</label>
            <textarea class="form-control" id="department_description" name="description"
               placeholder="Enter department description" required></textarea>
      </div>

      <!-- Status -->
      <div class="form-group">
            <label for="status">Status</label>
            <select class="form-control" id="department_status" name="status">
               <option value="active">Active</option>
               <option value="inactive">Inactive</option>
               <option value="under_reconstruction">Reconstruction</option>
            </select>
      </div>

         <!-- Form actions -->
      <div class="form-actions">
            <button type="button" class="btn btn-secondary"
               onclick="window.history.back()">Cancel</button>
            <button type="submit" class="btn btn-primary">Register Department</button>
      </div>
   </form>
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

      // Form submission - Validation only, no preventative default.
      document.getElementById('departmentForm').addEventListener('submit', function (e) {
            // Validation of required fields
            const name = document.getElementById('department_name').value;
            const shortName = document.getElementById('department_short_name').value;
            const description = document.getElementById('department_description').value;

            if (!name || !description) {
               e.preventDefault();
               alert('Please fill all required fields');
               return false;
            }

            // If all fields are filled in, the form will be sent to the PHP file normally without JavaScript intervention.
            return true;
      });
   });
</script>
HTML;

include __DIR__ .'/../layouts/main.php';