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
   // ============================================
   // INITIALIZATION
   // ============================================
    
   // Global variables
   let departmentID;

   document.addEventListener('DOMContentLoaded', function () {
      console.log('Edit Department Page');

      // Get department ID from URL
      const params = Object.fromEntries(new URLSearchParams(window.location.search));
      ({ id: departmentID } = params);

      if (!isValidParam(departmentID)) {
         showErrorState('Department ID is missing in the URL.');
         console.error('Department ID is missing in the URL:', departmentID);
         return;
      }

      console.log('Editing department ID:', departmentID);

      showLoadingState();
      loadDepartmentData(departmentID);

      // Event listeners
      document.getElementById('cancelBtn').addEventListener('click', function () {
         if (confirm('Are you sure you want to cancel? Any unsaved changes will be lost.')) {
            window.location.href = 'departments';
         }
      });

      document.getElementById('departmentForm').addEventListener('submit', function (e) {
         e.preventDefault();
         saveDepartmentChanges(departmentID);
      });
   });

   // ============================================
   // UI STATE MANAGEMENT FUNCTIONS
   // ============================================

   function showLoadingState() {
      const loadingState = document.getElementById('loadingState');
      const departmentForm = document.getElementById('departmentForm');
      
      if (loadingState) loadingState.style.display = 'block';
      if (departmentForm) departmentForm.style.display = 'none';
   }

   function showFormState() {
      const loadingState = document.getElementById('loadingState');
      const departmentForm = document.getElementById('departmentForm');
      
      if (loadingState) loadingState.style.display = 'none';
      if (departmentForm) departmentForm.style.display = 'block';
   }

   function showErrorState(message) {
      const departmentCard = document.getElementById('departmentCard');
      const loadingState = document.getElementById('loadingState');
      const departmentForm = document.getElementById('departmentForm');
      
      if (loadingState) loadingState.style.display = 'none';
      if (departmentForm) departmentForm.style.display = 'none';
      
      const errorDiv = document.createElement('div');
      errorDiv.className = 'error-message';
      errorDiv.innerHTML = `
         <i class="fas fa-exclamation-circle fa-2x" style="margin-bottom: 15px;"></i>
         <h4 style="color: #c0392b; margin-bottom: 10px;">Unable to Load Department Data</h4>
         <p>${escapeHtml(message)}</p>
         <button class="btn btn-primary retry-btn" style="margin-top: 15px;">
               <i class="fas fa-redo"></i> Try Again
         </button>
      `;
      
      departmentCard.innerHTML = '';
      departmentCard.appendChild(errorDiv);
      
      // Add retry button functionality
      setTimeout(() => {
         document.querySelector('.retry-btn')?.addEventListener('click', function() {
            this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Trying...';
            this.disabled = true;
            showLoadingState();
            setTimeout(() => loadDepartmentData(departmentID), 1000);
         });
      }, 100);
   }

   function showSaveSuccessState(message) {
      const departmentCard = document.getElementById('departmentCard');
      const loadingState = document.getElementById('loadingState');
      const departmentForm = document.getElementById('departmentForm');
      
      if (loadingState) loadingState.style.display = 'none';
      if (departmentForm) departmentForm.style.display = 'none';
      
      const successDiv = document.createElement('div');
      successDiv.className = 'success-message';
      successDiv.innerHTML = `
         <i class="fas fa-check-circle fa-2x" style="margin-bottom: 15px;"></i>
         <h4 style="color: #155724; margin-bottom: 10px;">Success!</h4>
         <p>${escapeHtml(message)}</p>
         <p style="font-size: 0.9rem; margin-top: 15px; color: #6c757d;">
            You will be redirected to departments page in <span id="countdown">3</span> seconds...
         </p>
      `;
      
      departmentCard.innerHTML = '';
      departmentCard.appendChild(successDiv);
      
      // Start countdown
      let seconds = 3; // Redirect timer
      const countdownElement = document.getElementById('countdown');
      const countdownInterval = setInterval(() => {
         seconds--;
         if (countdownElement) {
            countdownElement.textContent = seconds;
         }
         
         if (seconds <= 0) {
            clearInterval(countdownInterval);
            window.location.href = 'departments';
         }
      }, 1000);
   }

   // ============================================
   // API CALL FUNCTIONS (Standard Pattern)
   // ============================================

   function loadDepartmentData(departmentID) {
      const FUNCTION_NAME = 'loadDepartmentData';
      const ENDPOINT = `departments/get?id=${departmentID}`;
      const TIMEOUT_MS = 10000;
      
      console.log(`[${FUNCTION_NAME}] Loading department ID: ${departmentID}`);

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

         console.log(`[${FUNCTION_NAME}] Department data loaded successfully.`);
         return populateDepartmentForm(responseBody.data);
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

         console.error(`[${FUNCTION_NAME}] Unexpected error loading department data:`, {
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

   function saveDepartmentChanges(departmentID) {
      const FUNCTION_NAME = 'saveDepartmentChanges';
      const ENDPOINT = 'departments/update';
      const TIMEOUT_MS = 10000;
      
      console.log(`[${FUNCTION_NAME}] Saving changes for department ID: ${departmentID}`);

      // Validate data before sending
      const name = document.getElementById('name').value.trim();
      const shortName = document.getElementById('shortName').value.trim();
      const status = document.getElementById('status').value;
      const description = document.getElementById('description').value.trim();

      if (!name || !status || !description) {
         alert('Please fill in all required fields');
         return;
      }

      if (!confirm('Are you sure you want to save these changes?')) {
         return;
      }

      const departmentData = {
         id: parseInt(departmentID),
         name: name,
         short_name: shortName,
         description: description,
         status: status
      };

      const saveBtn = document.getElementById('saveBtn');
      const cancelBtn = document.getElementById('cancelBtn');
      const originalSaveText = saveBtn.innerHTML;

      // Visual feedback
      saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving Changes...';
      saveBtn.disabled = true;
      cancelBtn.style.display = 'none';

      const controller = new AbortController();
      const timeoutId = setTimeout(() => controller.abort(), TIMEOUT_MS);

      console.log(`[${FUNCTION_NAME}] Sending data:`, departmentData);

      return fetch(ENDPOINT, {
         method: 'PUT',
         headers: { 'Content-Type': 'application/json' },
         body: JSON.stringify(departmentData),
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
                        friendlyMessage: `Erro ${response.status}: ${response.statusText}`
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
                        friendlyMessage: errJson.friendly_message || `Erro: ${errJson.error}`
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
         
         console.log(`[${FUNCTION_NAME}] Department updated successfully.`);
         showSaveSuccessState(responseBody.message || 'Department successfully updated.');
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
            
            // Show error message in form context
            const errorMessage = err.friendlyMessage || 'Error updating department.';
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

   function populateDepartmentForm(department) {
      const FUNCTION_NAME = 'populateDepartmentForm';
      console.log(`[${FUNCTION_NAME}] Populating form with department data:`, department);

      const loadingState = document.getElementById('loadingState');
      const departmentForm = document.getElementById('departmentForm');
      
      if (loadingState) loadingState.style.display = 'none';
      if (departmentForm) departmentForm.style.display = 'block';

      document.getElementById('name').value = department.name || '';
      document.getElementById('shortName').value = department.short_name || '';
      document.getElementById('description').value = department.description || '';
      document.getElementById('status').value = department.status || '';
      
      console.log(`[${FUNCTION_NAME}] Form populated successfully`);
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
</script>
HTML;

include __DIR__ . '/../layouts/main.php';