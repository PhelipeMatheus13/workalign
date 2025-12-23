<?php
$pageTitle = "Dashboard";
$styles = <<<'HTML'
<style>
   html,
   body {
      height: 100%;
      overflow: hidden;   /* Prevent body scroll */
      margin: 0;
      padding: 0;
   }

   .container-fluid,
   .row {
      height: 100%;
      margin: 0;
      padding: 0;
   }

   .col-md-9 {
      height: calc(100vh - 56px);
      padding: 25px;
      overflow-y: auto; /* Enable vertical scrolling */
      background-color: #f8f9fa;
   }

   .section-title {
      font-weight: 500;
      color: #7f8c8d;
      font-size: 0.9rem;
      text-transform: uppercase;
      letter-spacing: 1px;
      padding-bottom: 5px;
      border-bottom: 1px solid #eaeaea;
   }

   .dashboard-card {
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      padding: 20px;
      height: 200px;
      display: flex;
      flex-direction: column;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      margin-bottom: 20px;
      border: 1px solid #f0f0f0;
   }

   .quick-action-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.12);
   }

   .card-header {
      display: flex;
      align-items: center;
      flex-direction: column;
   }

   .card-icon {
      width: 42px;
      height: 42px;
      border-radius: 10px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.0rem;
      color: white;
      margin-bottom: 5px;
   }

   .card-title {
      color: #2c3e50;
      font-weight: 600;
      font-size: 1rem;
   }


   .card-content {
      flex: 1;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
   }

   .card-value {
      font-size: 1.5rem;
      font-weight: 700;
      color: #2c3e50;
   }

   .card-description {
      font-size: 0.85rem;
      color: #7f8c8d;
   }

   .chart-container {
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      padding: 25px;
      margin-bottom: 20px;
      height: 350px;
      border: 1px solid #f0f0f0;
      overflow: hidden;
   }

   .chart-title {
      color: #2c3e50;
      font-weight: 600;
      margin-bottom: 20px;
      font-size: 1.1rem;
   }

   .bar-chart {
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      overflow: hidden;
   }

   .bar-item {
      display: flex;
      align-items: center;
      margin-bottom: 15px;
      height: 25px;
   }

   .bar-label {
      width: 120px;
      font-weight: 500;
      color: #2c3e50;
      font-size: 0.9rem;
   }

   .bar-container {
      flex: 1;
      height: 25px;
      background-color: #ecf0f1;
      border-radius: 5px;
      overflow: hidden;
      margin: 0 15px;
   }

   .bar-fill {
      height: 100%;
      border-radius: 5px;
      display: flex;
      align-items: center;
      justify-content: flex-end;
      padding-right: 10px;
      color: white;
      font-weight: 600;
      font-size: 0.8rem;
   }

   .bar-count {
      width: 30px;
      text-align: right;
      font-weight: 600;
      color: #2c3e50;
      font-size: 0.9rem;
   }

   .birthday-list {
      background: white;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
      padding: 25px;
      margin-bottom: 20px;
      height: 350px;
      display: flex;
      flex-direction: column;
      border: 1px solid #f0f0f0;
      overflow: hidden;
   }

   .birthday-items-container {
      flex: 1;
      overflow-y: auto;
      margin-bottom: 15px;
   }

   .birthday-item {
      display: flex;
      align-items: center;
      padding: 12px 0;
      border-bottom: 1px solid #ecf0f1;
   }

   .birthday-item:last-child {
      border-bottom: none;
   }

   .birthday-avatar {
      width: 38px;
      height: 38px;
      border-radius: 50%;
      background: #3498db;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;
      font-weight: 600;
      margin-right: 15px;
      font-size: 0.8rem;
   }

   .birthday-info {
      flex: 1;
   }

   .birthday-name {
      font-weight: 600;
      color: #2c3e50;
      font-size: 0.95rem;
   }

   .birthday-date {
      font-size: 0.8rem;
      color: #7f8c8d;
   }

   .btn-more {
      background-color: #3498db;
      color: white;
      border: none;
      border-radius: 6px;
      padding: 8px 15px;
      font-weight: 600;
      transition: background-color 0.3s ease;
      align-self: center;
      font-size: 0.85rem;
      width: 100%;
      margin-top: 10px;
   }

   .btn-more:hover {
      background-color: #2980b9;
   }

   .section-container {
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
   }

   .top-section {
      flex: 0 0 auto;
      margin-bottom: 30px;
   }

   .charts-section {
      flex: 0 0 auto;
   }

   .loading {
      opacity: 0.7;
   }

   .loading::after {
      content: " (Loading...)";
      font-size: 0.8em;
      color: #7f8c8d;
   }

   @media (max-width: 1250px) and (min-width: 992px) {
      .dashboard-card {
            height: 180px;
            padding: 15px;
      }

      .card-icon {
            width: 36px;
            height: 36px;
            font-size: 0.6rem;
      }

      .card-value {
            font-size: 1.3rem;
      }

      .card-title {
            font-size: 0.9rem;
      }

      .card-description {
            font-size: 0.8rem;
      }
   }

   @media (max-width: 991px) and (min-width: 768px) {
      .dashboard-card {
            height: auto;
            min-height: 160px;
            padding: 15px;
      }

      .card-icon {
            width: 34px;
            height: 34px;
            font-size: 0.85rem;
      }

      .card-value {
            font-size: 1.5rem;
      }

      .card-title {
            font-size: 0.85rem;
      }

      .card-description {
            font-size: 0.75rem;
            text-align: center;
      }

      .chart-container,
      .birthday-list {
            height: 320px;
            padding: 20px;
      }

      .bar-label {
            width: 100px;
            font-size: 0.8rem;
      }

      .bar-count {
            font-size: 0.8rem;
      }

      .birthday-avatar {
            width: 34px;
            height: 34px;
            font-size: 0.75rem;
      }

      .birthday-name {
            font-size: 0.85rem;
      }

      .birthday-date {
            font-size: 0.75rem;
      }
   }

   @media (max-width: 768px) {
      .col-md-9 {
            padding: 15px;
      }

      .dashboard-card {
            height: auto;
            min-height: 150px;
      }
   }
</style>
HTML;

$content = <<<'HTML'
<div class="section-container">
   <div class="top-section">
      <!-- Quick action cards -->
      <div>
            <h5 class="section-title">Quick Actions</h5>
            <div class="row">
               <div class="col-md-3">
                  <div class="dashboard-card quick-action-card"
                        onclick="window.location.href='employees/create'">
                        <div class="card-header">
                           <div class="card-icon" style="background-color: #3498db;">
                              <i class="fas fa-user-plus"></i>
                           </div>
                           <div class="card-title">New Employee</div>
                        </div>
                        <div class="card-content">
                           <div class="card-description">Add new employee.</div>
                        </div>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="dashboard-card quick-action-card"
                        onclick="window.location.href='departments/create'">
                        <div class="card-header">
                           <div class="card-icon" style="background-color: #2ecc71;">
                              <i class="fas fa-briefcase"></i>
                           </div>
                           <div class="card-title">New Department</div>
                        </div>
                        <div class="card-content">
                           <div class="card-description">Create a new department.</div>
                        </div>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="dashboard-card quick-action-card" onclick="window.location.href='employees'">
                        <div class="card-header">
                           <div class="card-icon" style="background-color: #e74c3c;">
                              <i class="fas fa-search"></i>
                           </div>
                           <div class="card-title">Search Employee</div>
                        </div>
                        <div class="card-content">
                           <div class="card-description">Search employees.</div>
                        </div>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="dashboard-card quick-action-card" onclick="window.location.href='#'">
                        <div class="card-header">
                           <div class="card-icon" style="background-color: #f39c12;">
                              <i class="fas fa-chart-bar"></i>
                           </div>
                           <div class="card-title">View Reports</div>
                        </div>
                        <div class="card-content">
                           <div class="card-description">Access reports.</div>
                        </div>
                  </div>
               </div>
            </div>
      </div>

      <!-- General information cards -->
      <div>
            <h5 class="section-title">General Information</h5>
            <div class="row">
               <div class="col-md-3">
                  <div class="dashboard-card">
                        <div class="card-header">
                           <div class="card-icon" style="background-color: #9b59b6;">
                              <i class="fas fa-building"></i>
                           </div>
                           <div class="card-title">Departments</div>
                        </div>
                        <div class="card-content">
                           <div class="card-value loading">0</div>
                           <div class="card-description">Active departments</div>
                        </div>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="dashboard-card">
                        <div class="card-header">
                           <div class="card-icon" style="background-color: #1abc9c;">
                              <i class="fas fa-users"></i>
                           </div>
                           <div class="card-title">Employees</div>
                        </div>
                        <div class="card-content">
                           <div class="card-value loading">0</div>
                           <div class="card-description">Active employees</div>
                        </div>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="dashboard-card">
                        <div class="card-header">
                           <div class="card-icon" style="background-color: #34495e;">
                              <i class="fas fa-dollar-sign"></i>
                           </div>
                           <div class="card-title">Average Salary</div>
                        </div>
                        <div class="card-content">
                           <div class="card-value loading">$0</div>
                           <div class="card-description">Average monthly salary</div>
                        </div>
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="dashboard-card">
                        <div class="card-header">
                           <div class="card-icon" style="background-color: #e67e22;">
                              <i class="fas fa-money-bill-wave"></i>
                           </div>
                           <div class="card-title">Total Expenses</div>
                        </div>
                        <div class="card-content">
                           <div class="card-value loading">$0</div>
                           <div class="card-description">Monthly salary expenses</div>
                        </div>
                  </div>
               </div>
            </div>
      </div>
   </div>

   <!-- Charts and birthdays section -->
   <div class="charts-section">
      <div class="row mt-4">
            <div class="col-md-8">
               <div class="chart-container">
                  <div class="chart-title">Employees by Department</div>
                  <div class="bar-chart" id="departmentChart">
                        <!-- Data will be loaded dynamically via JavaScript -->
                        <div class="text-center py-5">
                           <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                           <div class="mt-2 text-muted">Loading department data...</div>
                        </div>
                  </div>
               </div>
            </div>
            <div class="col-md-4">
               <div class="birthday-list">
                  <div class="chart-title">Upcoming Birthdays</div>
                  <div class="birthday-items-container" id="birthdayList">
                        <!-- Data will be loaded dynamically via JavaScript  -->
                        <div class="text-center py-5">
                           <i class="fas fa-spinner fa-spin fa-2x text-muted"></i>
                           <div class="mt-2 text-muted">Loading birthday data...</div>
                        </div>
                  </div>
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
      console.log('Dashboard Page');

      // Add click functionality to action cards
      document.querySelectorAll('.quick-action-card').forEach(card => {
         if (card.getAttribute('onclick')) {
               card.style.cursor = 'pointer';
         }
      });

      loadDashboardData();
   });

    // ============================================
    // UI STATE MANAGEMENT FUNCTIONS
    // ============================================
    
   function showErrorState(friendlyMessage) {
      // Update card status to show error.
      document.querySelectorAll('.card-value').forEach(el => {
         el.classList.remove('loading');
         el.textContent = 'Error'; // Simple error text for small cards
      });

      // Display friendly error message in graph section
      const barChart = document.getElementById('departmentChart');
      if (barChart) {
         barChart.innerHTML = `
               <div class="text-center py-5">
                  <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                  <div class="mt-2 text-danger">${escapeHtml(friendlyMessage) || 'Failed to load data'}</div>
               </div>
         `;
      }

      // Display simple error message in the birthday list (shorter to fit space)
      const birthdayContainer = document.getElementById('birthdayList');
      if (birthdayContainer) {
         birthdayContainer.innerHTML = `
               <div class="text-center py-5">
                  <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                  <div class="mt-2 text-danger">Failed to load birthdays </div>
               </div>
         `;
      }
   }

    // ============================================
    // API CALL FUNCTIONS (Standard Pattern)
    // ============================================

    // Fetch dashboard data from the server and normalize it for the view.
    // Uses a timeout (AbortController) to avoid hanging requests.
   function loadDashboardData() {
      const FUNCTION_NAME = 'loadDashboardData';
      const ENDPOINT = 'dashboard/get';
      const TIMEOUT_MS = 10000;

      console.log(`[${FUNCTION_NAME}] Loading dashboard data...`);

      const controller = new AbortController();
      const timeoutId = setTimeout(() => controller.abort(), TIMEOUT_MS);

      return fetch(ENDPOINT, {
         method: 'GET',
         headers: { 'Content-Type': 'application/json' },
         signal: controller.signal
      })
      .then(function handleResponse(response){
         clearTimeout(timeoutId); // Response received - cancel timeout

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
                     // Detailed API error log
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

         return response.json(); // If OK, parse JSON body.
      })
      .then(function handleSuccessData(responseBody) {
         console.log(`[${FUNCTION_NAME}] Response body:`, {
               success: responseBody.success,
               hasData: !!responseBody.data,
         });

         if (!responseBody || !responseBody.success || !responseBody.data) {
               console.error(`[${FUNCTION_NAME}] Completed`);
               showErrorState(responseBody?.friendly_message || 'Invalid server response. Please try again.');
               return;
         }
         
         console.log(`[${FUNCTION_NAME}] Normalizing dashboard data for view...`);
         const normalized = normalizeDashboardData(responseBody.data);
         console.log(`[${FUNCTION_NAME}] Rendering dashboard data.`);
         return updateDashboard(normalized);
      })
      .catch(err => {
         clearTimeout(timeoutId); // An error occurred - cancel timeout

         if (err && err.name === 'AbortError') {
               console.error(`[${FUNCTION_NAME}] Timeout after ${TIMEOUT_MS}ms`);
               showErrorState('Request timed out. Please try again.');
               return;
         }

         if (err.type && (err.type === 'HTTP_ERROR' || err.type === 'API_ERROR')) {
               console.error(`[${FUNCTION_NAME}] Error occurred | Status: ${err.status} | Type: ${err.type}`);
               showErrorState(err.friendlyMessage || 'Error loading departments.');
               return;
         }
         
         // Other unexpected errors
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

   // ============================================
   // DATA MANAGEMENT FUNCTIONS
   // ============================================
   
   /**
    * Normalize server response for the view.
    * Ensures numbers are typed and arrays exist.
    * Note: API response field names must match exactly what the view expects.
    */
   function normalizeDashboardData(data) {
      const FUNCTION_NAME = 'normalizeDashboardData';
      data = data || {};
      data.general_info = data.general_info || {};

      // Coerce numeric types and provide default values to avoid UI NaN issues.
      data.general_info.total_departments = Number(data.general_info.total_departments) || 0;
      data.general_info.total_employees = Number(data.general_info.total_employees) || 0;
      // API returns 'average_salary' (matching the view expectation)
      data.general_info.average_salary = Number(data.general_info.average_salary) || 0;
      data.general_info.total_salary = Number(data.general_info.total_salary) || 0;

      // Ensure arrays exist
      data.department_distribution = Array.isArray(data.department_distribution) ? data.department_distribution : [];
      data.upcoming_birthdays = Array.isArray(data.upcoming_birthdays) ? data.upcoming_birthdays : [];

      console.log(`[${FUNCTION_NAME}] Completed normalization:`, data);
      return data;
   }

   function updateDashboard(data) {
      console.log('[updateDashboard] Updating dashboard with new data...', data);
      updateGeneralInfo(data.general_info);
      updateDepartmentChart(data.department_distribution);
      updateBirthdayList(data.upcoming_birthdays);
      console.log('[updateDashboard] Dashboard update complete.');
   }

   function updateGeneralInfo(generalInfo) {
      const FUNCTION_NAME = 'updateGeneralInfo';

      // Remove loading indicator
      document.querySelectorAll('.card-value').forEach(el => {
         el.classList.remove('loading');
      });

      const allCards = document.querySelectorAll('.dashboard-card');
      const generalCards = [];

      allCards.forEach(card => {
         // Check if the card is in the General Information section
         const sectionTitle = card.closest('.row')?.previousElementSibling;
         if (sectionTitle && sectionTitle.classList.contains('section-title') &&
               sectionTitle.textContent.includes('General Information')) {
               generalCards.push(card);
         }
      });


      if (generalCards.length >= 4) {
         // Update in the correct order.
         generalCards[0].querySelector('.card-value').textContent = generalInfo.total_departments;
         generalCards[1].querySelector('.card-value').textContent = generalInfo.total_employees;
         generalCards[2].querySelector('.card-value').textContent = '$' + formatNumber(generalInfo.average_salary);
         generalCards[3].querySelector('.card-value').textContent = '$' + formatNumber(generalInfo.total_salary);
      }

      console.log(`[${FUNCTION_NAME}] General info updated.`);
   }

   function updateDepartmentChart(departmentData) {
      const FUNCTION_NAME = 'updateDepartmentChart';

      const barChart = document.getElementById('departmentChart');
      if (!barChart) return;

      // Clear existing data
      barChart.innerHTML = '';

      if (!departmentData || departmentData.length === 0) {
         barChart.innerHTML = `
               <div class="text-center py-5">
                  <i class="fas fa-chart-bar fa-2x text-muted"></i>
                  <div class="mt-2 text-muted">No department data available</div>
               </div>
         `;
         return;
      }

      // Find the maximum value for calculating percentages.
      const maxCount = Math.max(...departmentData.map(dept => Number(dept.employee_count) || 0));

      // Add each department to the chart.
      departmentData.forEach((dept, index) => {
         const count = Number(dept.employee_count) || 0;
         const percentage = maxCount > 0 ? (count / maxCount) * 100 : 0;

         const barItem = document.createElement('div');
         barItem.className = 'bar-item';

         // Define different colors for each bar.
         const colors = [
               '#3498db', '#2ecc71', '#e74c3c', '#f39c12',
               '#9b59b6', '#1abc9c', '#34495e', '#e67e22',
               '#16a085', '#27ae60', '#2980b9', '#8e44ad'
         ];
         const color = colors[index % colors.length];

         const label = dept.department_name || 'Unknown';

         barItem.innerHTML = `
               <div class="bar-label">${label}</div>
               <div class="bar-container">
                  <div class="bar-fill" style="width: ${percentage}%; background-color: ${color};">
                     ${count}
                  </div>
               </div>
               <div class="bar-count">${count}</div>
         `;

         barChart.appendChild(barItem);
      });
      console.log(`[${FUNCTION_NAME}] Department chart updated.`);
   }

   function updateBirthdayList(birthdayData) {
      const FUNCTION_NAME = 'updateBirthdayList';
      const birthdayContainer = document.getElementById('birthdayList');
      if (!birthdayContainer) return;

      // Clear existing data
      birthdayContainer.innerHTML = '';

      if (!birthdayData || birthdayData.length === 0) {
         birthdayContainer.innerHTML = `
               <div class="text-center py-5">
                  <i class="fas fa-birthday-cake fa-2x text-muted"></i>
                  <div class="mt-2 text-muted">No upcoming birthdays</div>
               </div>
         `;
         return;
      }

      birthdayData.forEach(person => {
         const birthdayItem = document.createElement('div');
         birthdayItem.className = 'birthday-item';

         // Generate initials for the avatar
         const names = (person.employee_name || '').split(' ');
         const initials = (names[0]?.charAt(0) || '') + (names[1]?.charAt(0) || '');
         const initialsText = initials.toUpperCase();

         // Calculate the days until the birthday.
         const daysUntil = Number(person.days_until_birthday) || 0;

         let dateText = '';

         if (daysUntil === 0) {
               dateText = 'Today';
         }

         if (daysUntil === 1) {
               dateText = 'Tomorrow';
         }

         if (daysUntil > 1) {
               dateText = `In ${daysUntil} days`;
         }

         const deptName = person.department_name || '';

         birthdayItem.innerHTML = `
               <div class="birthday-avatar">${initialsText}</div>
               <div class="birthday-info">
                  <div class="birthday-name">${escapeHtml(person.employee_name)}</div>
                  <div class="birthday-date">${dateText} - ${deptName}</div>
               </div>
         `;

         birthdayContainer.appendChild(birthdayItem);
      });

      console.log(`[${FUNCTION_NAME}] Birthday list updated.`);
   }

   // ============================================
   // UTILITY FUNCTIONS
   // ============================================
   
   function formatNumber(number) {
      return number.toLocaleString('en-US', {
         minimumFractionDigits: 2,
         maximumFractionDigits: 2
      });
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

include __DIR__ . '/../layouts/main.php';