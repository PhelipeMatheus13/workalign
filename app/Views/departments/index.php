<?php
$pageTitle = "Departments";
$styles = <<<'HTML'
<style>
    html, body {
        margin: 0;
        padding: 0;
        height: 100%;
        overflow: hidden; /* Prevent body scroll */
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
        height: 100%;
        padding: 0;
        display: flex;
        flex-direction: column;
        overflow-y: auto; /* Enable vertical scrolling */
    }

    .carousel-container {
        max-width: 900px;
        width: 100%;
        margin: 0 auto;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .carousel {
        height: 100%;
    }

    .carousel-inner {
        height: 100%;
        border-radius: 10px;
    }

    .carousel-item {
        height: 100%;
        padding: 30px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        display: none;
    }

    .carousel-item.active {
        display: block;
    }

    .department-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        border-bottom: 1px solid #e9ecef;
        padding-bottom: 15px;
    }

    .department-title {
        color: #2c3e50;
        font-weight: 600;
        font-size: 1.8rem;
        margin: 0;
    }

    .department-actions {
        display: flex;
        gap: 10px;
    }

    .department-info {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .info-card {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 15px;
        text-align: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .info-card h4 {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 5px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .info-card p {
        color: #2c3e50;
        font-size: 1.8rem;
        font-weight: 700;
        margin: 0;
    }

    .department-description {
        margin-bottom: 20px;
        color: #495057;
        line-height: 1.6;
    }

    .view-role-btn {
        display: block;
        width: 100%;
        padding: 12px;
        background: #3498db;
        color: white;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        transition: background 0.3s ease;
        cursor: pointer;
    }

    .view-more-btn:hover {
        background: #2980b9;
    }

    .carousel-controls {
        display: flex;
        justify-content: space-between;
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        transform: translateY(-50%);
        pointer-events: none;
        z-index: 10;
    }

    .carousel-control {
        background-color: #2c3e50;
        color: white;
        border: none;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        pointer-events: all;
        transition: background-color 0.3s ease;
        z-index: 15;
    }

    .carousel-control:hover {
        background-color: #3498db;
    }

    .carousel-indicators {
        bottom: -50px;
    }

    .carousel-indicators li {
        background-color: #bdc3c7;
        width: 12px;
        height: 12px;
        border-radius: 50%;
    }

    .carousel-indicators .active {
        background-color: #3498db;
    }

    .btn-create {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
    }

    .btn-sm {
        padding: 0.4rem 0.8rem;
        font-size: 0.875rem;
        border-radius: 4px;
    }

    .create-department-btn-container {
        display: flex;
        justify-content: flex-end;
        margin: 10px auto 20px;
        max-width: 900px;
        width: 100%;
        padding: 0 30px;
    }

    .carousel-item {
        transition: none !important;
    }

    .carousel-inner {
        transition: none !important;
    }

    @media (max-width: 768px) {
        .col-md-9 {
            height: calc(100vh - 56px);
        }

        .content-area {
            padding: 10px;
        }

        .carousel-container {
            padding: 0;
        }

        .carousel-item {
            padding: 20px;
            min-height: 450px;
        }

        .department-info {
            grid-template-columns: 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .department-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 20px;
        }

        .department-actions {
            align-self: flex-end;
            width: 100%;
            justify-content: space-between;
        }

        .department-title {
            font-size: 1.5rem;
        }

        .info-card {
            padding: 12px;
        }

        .info-card p {
            font-size: 1.5rem;
        }

        .new-department-container {
            justify-content: center;
        }

        .create-department-btn-container {
            padding: 0 20px;
            margin: 10px auto 15px;
        }

        .carousel-controls {
            position: relative;
            justify-content: center;
            margin-top: 20px;
            transform: none;
            top: auto;
        }

        .carousel-control {
            position: static;
            margin: 0 10px;
        }

        .carousel-indicators {
            bottom: -30px;
        }
    }
</style>
HTML;

$content = <<<'HTML'
<div class="create-department-btn-container">
    <a href="departments/create">
        <button type="button" class="btn btn-primary btn-sm btn-create">
            <i class="fas fa-plus"></i> New Department
        </button>
    </a>
</div>

<div class="carousel-container">
    <div id="departmentsCarousel" class="carousel slide" data-ride="carousel" data-interval="false">
        <!-- Indicators will be generated dynamically. -->
        <ol class="carousel-indicators" id="carouselIndicators">
        </ol>

        <div class="carousel-inner" id="carouselInner">
            <!-- Dynamic content-->
        </div>

        <!-- Carousel controls -->
        <div class="carousel-controls">
            <button class="carousel-control prev" data-target="#departmentsCarousel" data-slide="prev">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="carousel-control next" data-target="#departmentsCarousel" data-slide="next">
                <i class="fas fa-chevron-right"></i>
            </button>
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
        console.log('Departments Page');
        
        document.querySelectorAll('.carousel-control').forEach(control => {
            control.addEventListener('click', function () {
                const target = this.getAttribute('data-target');
                const direction = this.getAttribute('data-slide');
                $(target).carousel(direction);
            });
        });

        showLoadingState();
        loadDepartments();
    });

    // ============================================
    // UI STATE MANAGEMENT FUNCTIONS
    // ============================================

    function showLoadingState() {
        const carouselInner = document.getElementById('carouselInner');
        const carouselIndicators = document.getElementById('carouselIndicators');
        
        carouselInner.innerHTML = '';
        carouselIndicators.innerHTML = '';
        
        const loadingItem = document.createElement('div');
        loadingItem.className = 'carousel-item active';
        loadingItem.innerHTML = `
            <div class="department-header">
                <h3 class="department-title">Loading Departments</h3>
            </div>
            
            <div class="department-info" style="grid-template-columns: 1fr;">
                <div class="info-card" style="background: transparent; border: none; min-height: 200px; display: flex; align-items: center; justify-content: center;">
                    <div style="text-align: center;">
                        <i class="fas fa-spinner fa-spin fa-3x" style="color: #3498db; margin-bottom: 20px;"></i>
                        <h4 style="color: #3498db;">Loading departments...</h4>
                        <p>Please wait while we load the department information.</p>
                    </div>
                </div>
            </div>
        `;
        
        carouselInner.appendChild(loadingItem);
    }

    function showErrorState(friendlyMessage) {
        const carouselInner = document.getElementById('carouselInner');
        const carouselIndicators = document.getElementById('carouselIndicators');
        
        carouselInner.innerHTML = '';
        carouselIndicators.innerHTML = '';
        
        const errorItem = document.createElement('div');
        errorItem.className = 'carousel-item active';
        errorItem.innerHTML = `
            <div class="department-header">
                <h3 class="department-title" style="color: #e74c3c; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-exclamation-triangle"></i> Error
                </h3>
            </div>
            
            <div class="department-info" style="grid-template-columns: 1fr;">
                <div class="info-card" style="background: linear-gradient(135deg, #ffeaea 0%, #ffcccc 100%); border: 2px solid #ff9999; min-height: 200px; display: flex; align-items: center; justify-content: center;">
                    <div style="text-align: center; width: 100%;">
                        <i class="fas fa-exclamation-circle fa-3x" style="color: #e74c3c; margin-bottom: 20px;"></i>
                        <h4 style="color: #c0392b; font-size: 1.2rem; margin-bottom: 10px;">Unable to Load Departments</h4>
                        <p style="color: #7f8c8d; font-size: 0.9rem; margin-bottom: 15px;">${escapeHtml(friendlyMessage)}</p>
                    </div>
                </div>
            </div>
            
            <div class="department-actions" style="justify-content: center; margin-top: 20px;">
                <button class="btn btn-primary retry-btn" style="padding: 10px 20px;">
                    <i class="fas fa-redo"></i> Try Again
                </button>
            </div>
        `;
        
        carouselInner.appendChild(errorItem);
        
        // Add button functionality
        setTimeout(() => {
            document.querySelector('.retry-btn')?.addEventListener('click', function() {
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Trying...';
                this.disabled = true;
                showLoadingState();
                setTimeout(() => loadDepartments(), 1000);
            });
        }, 100);
    }
    
    function showDepartmentsEmptyState() {
        const carouselInner = document.getElementById('carouselInner');
        const carouselIndicators = document.getElementById('carouselIndicators');
        
        carouselInner.innerHTML = '';
        carouselIndicators.innerHTML = '';
        
        const emptyItem = document.createElement('div');
        emptyItem.className = 'carousel-item active';
        emptyItem.innerHTML = `
            <div class="department-header">
                <h3 class="department-title">No Departments Found</h3>
            </div>
            
            <div class="department-info" style="grid-template-columns: 1fr;">
                <div class="info-card" style="background: #f0f8ff; border: 1px solid #d1e7ff;">
                    <h4>Status</h4>
                    <p style="font-size: 1.2rem; color: #3498db;">No departments available</p>
                </div>
            </div>
            
            <div class="department-description">
                <p>There are no departments in the system yet. Click the button below to create your first department.</p>
            </div>
            
            <div class="department-actions" style="justify-content: center; margin-top: 20px;">
                <a href="departments/create">
                    <button class="btn btn-primary" style="padding: 10px 20px;">
                        <i class="fas fa-plus"></i> Create First Department
                    </button>
                </a>
            </div>
        `;
        
        carouselInner.appendChild(emptyItem);
    }

    // ============================================
    // API CALL FUNCTIONS 
    // ============================================
    function loadDepartments() {
        const FUNCTION_NAME = 'loadDepartments';
        const ENDPOINT = 'departments/list';
        const TIMEOUT_MS = 10000;
        
        console.log(`[${FUNCTION_NAME}] Loading departments...`);
        
        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), TIMEOUT_MS);
        
        // fetch in new promise chain
        return fetch(ENDPOINT, {
            method: 'GET',
            headers: { 'Content-Type': 'application/json' },
            signal: controller.signal
        })
        .then(function handleResponse(response) {
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
                dataLength: responseBody.data?.length || 0
            });
            
            if (!responseBody || !responseBody.success || !responseBody.data) {
                console.error(`[${FUNCTION_NAME}] Invalid response structure!`, responseBody);
                showErrorState(responseBody?.friendly_message || 'Invalid server response. Please try again.');
                return;
            }
            
            if (responseBody.data.length === 0) {
                console.log(`[${FUNCTION_NAME}] No data found. Showing empty state...`);
                showDepartmentsEmptyState();
                return;
            }
            
            console.log(`[${FUNCTION_NAME}] ${responseBody.data.length} loaded departments. Rendering carousel...`);
            return renderCarousel(responseBody.data);
        })
        .catch(function handleFetchError(err) {
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

    function deleteDepartment(departmentID) {
        const FUNCTION_NAME = 'deleteDepartment';
        const ENDPOINT = 'departments/delete';
        const TIMEOUT_MS = 10000;

        console.log(`[${FUNCTION_NAME}] Deleting department ID: ${departmentID}`);

        const controller = new AbortController();
        const timeoutId = setTimeout(() => controller.abort(), TIMEOUT_MS);

        // fetch in new promise chain
        return fetch(ENDPOINT, {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id: departmentID }),
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
            if (!responseBody || !responseBody.success)  {
                console.error(`[${FUNCTION_NAME}] Invalid response structure!`, responseBody);
                alert(`Error deleting department: ${responseBody?.friendly_message || 'Invalid server response.'}`);
                return;
            }
            
            alert('Department deleted successfully.');
            console.log(`[${FUNCTION_NAME}] Department deleted successfully. Reloading departments...`);
            showLoadingState();
            return loadDepartments(); // new promise chain
        })
        .catch(function handleFetchError(err){
            clearTimeout(timeoutId); 

            if (err && err.name === 'AbortError') {
                console.error(`[${FUNCTION_NAME}] Timeout after ${TIMEOUT_MS}ms`);
                alert('Request timed out. Please try again.');
                return;
            }
            if (err.type && (err.type === 'HTTP_ERROR' || err.type === 'API_ERROR')) {
                console.error(`[${FUNCTION_NAME}] Error occurred | Status: ${err.status} | Type: ${err.type}`);
                alert(err.friendlyMessage || 'Error deleting department.');
                return;
            }            

            console.error(`[${FUNCTION_NAME}] Unexpected error:`, {
                name: err.name,
                message: err.message,
            });
            alert('An unexpected error occurred. Please try again.');
        })
        .finally(() => {
            clearTimeout(timeoutId);
            console.log(`[${FUNCTION_NAME}] Completed`);
        });
    }

    // ============================================
    // DATA MANAGEMENT FUNCTIONS
    // ============================================

    function renderCarousel(departments) {
        FUNCTION_NAME = 'renderCarousel';
        console.log(`[${FUNCTION_NAME}] Rendering carousel with data.`, departments);
        const carouselInner = document.getElementById('carouselInner');
        const carouselIndicators = document.getElementById('carouselIndicators');

        carouselInner.innerHTML = '';
        carouselIndicators.innerHTML = '';

        // A loop that dynamically creates carousel items
        departments.forEach((dept, index) => {
            // create indicator
            const indicator = document.createElement('li');
            indicator.setAttribute('data-target', '#departmentsCarousel');
            indicator.setAttribute('data-slide-to', index);
            if (index === 0) indicator.classList.add('active');
            carouselIndicators.appendChild(indicator);

            // Create carousel item
            const carouselItem = document.createElement('div');
            carouselItem.className = `carousel-item ${index === 0 ? 'active' : ''}`;
            carouselItem.innerHTML = `
                <div class="department-header">
                    <h3 class="department-title">${escapeHtml(dept.name)}</h3>
                    <div class="department-actions">
                        <button class="btn btn-outline-primary btn-sm edit-btn" data-dept-id="${dept.id}">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button class="btn btn-outline-danger btn-sm delete-btn" data-dept-id="${dept.id}">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </div>
                </div>

                <div class="department-info">
                    <div class="info-card">
                        <h4>Employees</h4>
                        <p>${dept.employees_count}</p>
                    </div>
                    <div class="info-card">
                        <h4>Average Salary</h4>
                        <p>$${dept.avg_salary}</p>
                    </div>
                    <div class="info-card">
                        <h4>Roles</h4>
                        <p>${dept.roles_count}</p>
                    </div>
                    <div class="info-card">
                        <h4>Monthly Budget</h4>
                        <p>$${dept.monthly_budget}</p>
                    </div>
                </div>

                <div class="department-description">
                    <p>${escapeHtml(dept.description || 'No description available.')}</p>
                </div>

                <button class="view-role-btn view-roles-btn"  data-dept-id="${dept.id}" data-dept-name="${escapeHtml(dept.name)}">
                    <i class="fas fa-info-circle"></i> View Details
                </button>
            `;

            carouselInner.appendChild(carouselItem);
        });

        // At the end of rendering, initialize carousel and attach events
        $('#departmentsCarousel').carousel({ interval: false, wrap: true });
        attachEventListeners();
        console.log(`[${FUNCTION_NAME}] Carousel rendering complete with ${departments.length} departments.`);
    }

    function attachEventListeners() {
        // Force re-attachment of events after a short delay.
        setTimeout(() => {
            // Button Edit
            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const deptId = this.getAttribute('data-dept-id');
                    window.location.href = `departments/update?id=${deptId}`;
                });
            });

            // Button delete
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function (e) {
                    e.stopPropagation();
                    const deptId = this.getAttribute('data-dept-id');
                    if (confirm('Are you sure you want to delete this department?')) {
                        deleteDepartment(deptId);
                    }
                });
            });

            // Button view
            document.querySelectorAll('.view-roles-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const deptId = this.getAttribute('data-dept-id');
                    const deptName = this.getAttribute('data-dept-name');

                    const params = new URLSearchParams({
                        id: deptId,
                        name: deptName
                    });

                    window.location.href = `departments/show?${params.toString()}`;
                });
            });
        }, 150);
    }

    // ============================================
    // UTILITY FUNCTIONS
    // ============================================

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