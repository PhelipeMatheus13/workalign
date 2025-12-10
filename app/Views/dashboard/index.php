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
   document.addEventListener('DOMContentLoaded', function () {
      // Mark the panel menu as active.
      const menuItems = document.querySelectorAll('.menu-item, #navbarMobileMenu .nav-link');
      menuItems.forEach(item => {
            item.classList.remove('active');
            if (item.getAttribute('data-menu') === 'dashboard') {
               item.classList.add('active');
            }
      });

      // Save to localStorage
      localStorage.setItem('activeMenu', 'dashboard');

      // Add click functionality to action cards
      document.querySelectorAll('.quick-action-card').forEach(card => {
            if (card.getAttribute('onclick')) {
               card.style.cursor = 'pointer';
            }
      });

      loadDashboardData();
   });

   /**
    * Fetch dashboard data from the server and normalize it for the view.
    * Uses a timeout (AbortController) to avoid hanging requests.
    */
   function loadDashboardData() {
      console.log('Loading dashboard data...');

      const controller = new AbortController();
      const TIMEOUT_MS = 10000; // 10 seconds timeout
      const timeoutId = setTimeout(() => controller.abort(), TIMEOUT_MS);

      fetch('dashboard/get', { signal: controller.signal, cache: 'no-store' })
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
               // If OK, parse JSON body.
               return response.json();
            })
            .then(payload => {
               const valid = payload && payload.success && payload.data;
               if (!valid) {
                  console.error('API returned an error payload:', payload);
                  showErrorState();
                  return; 
               }

               const normalized = normalizeDashboardData(payload.data);
               updateDashboard(normalized);
            })
            .catch(err => {
               // Handle aborts, HTTP errors and other failures.
               // Timeout
               if (err && err.name === 'AbortError') {
                  console.error('Dashboard request timed out.');
                  showErrorState();
                  return;
               }
               
               // HTTP Errors
               const hasStatus = err && err.status;
               if (hasStatus) {
                  console.error('HTTP Error while loading dashboard data:', err);

                  const serverMsg = err.body && err.body.message;
                  if (serverMsg) {
                     console.error('Server message:', serverMsg);
                  }

                  showErrorState();
                  return;
               }

               console.error('Unexpected error loading dashboard data:', err);
               showErrorState();
            })
            .finally(() => {
               clearTimeout(timeoutId);
            });
   }

   /**
    * Normalize server response for the view.
    * Ensures numbers are typed and arrays exist.
    * Note: API response field names must match exactly what the view expects.
    */
   function normalizeDashboardData(data) {
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

      return data;
   }

   function updateDashboard(data) {
      updateGeneralInfo(data.general_info);
      updateDepartmentChart(data.department_distribution);
      updateBirthdayList(data.upcoming_birthdays);
   }

   
   function updateGeneralInfo(generalInfo) {
      console.log('Updating general info with:', generalInfo);

      
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

      console.log('General info cards found:', generalCards.length);

      if (generalCards.length >= 4) {
            // Update in the correct order.
            generalCards[0].querySelector('.card-value').textContent = generalInfo.total_departments;
            generalCards[1].querySelector('.card-value').textContent = generalInfo.total_employees;
            generalCards[2].querySelector('.card-value').textContent = '$' + formatNumber(generalInfo.average_salary);
            generalCards[3].querySelector('.card-value').textContent = '$' + formatNumber(generalInfo.total_salary);
      }
   }

   function updateDepartmentChart(departmentData) {
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
   }

   function updateBirthdayList(birthdayData) {
      const birthdayContainer = document.getElementById('birthdayList');
      if (!birthdayContainer) return;

      
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
                  <div class="birthday-name">${person.employee_name}</div>
                  <div class="birthday-date">${dateText} - ${deptName}</div>
               </div>
            `;

            birthdayContainer.appendChild(birthdayItem);
      });
   }

   function formatNumber(number) {
      return number.toLocaleString('en-US', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
      });
   }

   function showErrorState() {
      console.error('Failed to load dashboard data');

      // Update card status to show error.
      document.querySelectorAll('.card-value').forEach(el => {
            el.classList.remove('loading');
            el.textContent = 'Error';
      });

      // Display error message in graph
      const barChart = document.getElementById('departmentChart');
      if (barChart) {
            barChart.innerHTML = `
               <div class="text-center py-5">
                  <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                  <div class="mt-2 text-danger">Failed to load data</div>
               </div>
            `;
      }

      // Display error message in the birthday list
      const birthdayContainer = document.getElementById('birthdayList');
      if (birthdayContainer) {
            birthdayContainer.innerHTML = `
               <div class="text-center py-5">
                  <i class="fas fa-exclamation-triangle fa-2x text-danger"></i>
                  <div class="mt-2 text-danger">Failed to load data</div>
               </div>
            `;
      }
   }
</script> 
HTML;

include __DIR__ .'/../layouts/main.php';