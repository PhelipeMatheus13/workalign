<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <title>WorkAlign - New department</title>
    <style>        
         .col-md-9 {
               height: calc(100vh - 56px);
               padding: 20px;
               overflow-y: auto;
               background-color: #f8f9fa;
               display: flex;
               justify-content: center;
               align-items: center;
         }
         
         .alert-container {
               max-width: 500px;
               width: 100%;
               text-align: center;
         }
         
         .alert {
               margin: 20px 0;
               padding: 25px;
               border-radius: 10px;
               box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
         }
         
         .alert-success {
               background-color: #d4edda;
               border: 1px solid #c3e6cb;
               color: #155724;
         }
         
         .alert-danger {
               background-color: #f8d7da;
               border: 1px solid #f5c6cb;
               color: #721c24;
         }
         
         .btn-back {
               margin-top: 25px;
               min-width: 200px;
         }
         
         .alert-icon {
               font-size: 3rem;
               margin-bottom: 15px;
         }
         
         .alert-title {
               font-size: 1.5rem;
               font-weight: 600;
               margin-bottom: 10px;
         }
         
         .alert-message {
               font-size: 1.1rem;
               margin-bottom: 5px;
         }
      </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="../../public/index.html">
            <i class="fa-solid fa-users-gear" style="color: #ffffff;"></i> WorkAlign
        </a>
        
        <!-- Button of menu mobile -->
        <button class="navbar-toggler d-md-none" type="button" data-toggle="collapse" data-target="#navbarMobileMenu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu mobile (dropdown) -->
        <div class="collapse navbar-collapse d-md-none" id="navbarMobileMenu">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="../../public/index.html" data-menu="dashboard">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../views/employees.html" data-menu="employees">
                        <i class="fas fa-users"></i> Employees
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../views/departments.html" data-menu="departments">
                        <i class="fas fa-briefcase"></i> Departments
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-menu="reports">
                        <i class="fas fa-chart-bar"></i> Reports
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Side menu -->
            <div class="col-md-3 menu d-none d-md-block">
                <ul class="menu">
                    <li>
                        <a href="/public/index.html" class="menu-item" data-menu="dashboard">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="../views/employees.html" class="menu-item" data-menu="employees">
                            <i class="fas fa-users"></i>
                            <span>Employees</span>
                        </a>
                    </li>
                    <li>
                        <a href="../views/departments.html" class="menu-item active" data-menu="departments">
                            <i class="fas fa-briefcase"></i>
                            <span>Departments</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="menu-item" data-menu="reports">
                            <i class="fas fa-chart-bar"></i>
                            <span>Reports</span>
                        </a>
                    </li>
                </ul>
            </div>
            
            <!-- Main content -->
            <div class="col-md-9">
                <div class="alert-container">
                    <?php
                        error_reporting(E_ALL);
                        ini_set('display_errors', 1);
                        
                        require_once "../../config/database.php";
                        
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            
                            $firstName = $_POST['first_name'] ?? '';
                            $lastName = $_POST['last_name'] ?? '';
                            $birthday = $_POST['date_of_birth'] ?? '';
                            $email = $_POST['email'] ?? '';
                            $phone = $_POST['phone1'] ?? '';
                            $address = $_POST['address'] ?? '';
                            $salary = $_POST['salary'] ?? '';
                            $departmentId = $_POST['department_id'] ?? '';
                            $roleId = $_POST['role_id'] ?? '';

                            if (!array_key_exists('phone2', $_POST)) {
                                // missing field in request -> NULL
                                $secondPhone = null;
                            } else {
                                // present field (may be empty "")
                                $tmp = trim($_POST['phone2']);
                                // Normalize empty strings to NULL to avoid multiple empty-string conflicts.
                                $secondPhone = ($tmp === '') ? null : $tmp;
                            }

                            // Validations
                            $errors = [];
                            if (empty($firstName)) $errors[] = "First name is required";
                            if (empty($lastName)) $errors[] = "Last name is required";
                            if (empty($birthday)) $errors[] = "Date of birth is required";
                            if (empty($email)) $errors[] = "Email is required";
                            if (empty($phone)) $errors[] = "Primary phone is required";
                            if (empty($address)) $errors[] = "Address is required";
                            if (empty($salary)) $errors[] = "Salary is required";
                            if (empty($departmentId)) $errors[] = "Department is required";
                            if (empty($roleId)) $errors[] = "Role is required";

                            if (!empty($errors)) {
                                echo '<div class="alert alert-danger">';
                                echo '<div class="alert-icon"><i class="fas fa-exclamation-triangle"></i></div>';
                                echo '<div class="alert-title">Validation Error!</div>';
                                echo '<div class="alert-message">';
                                foreach ($errors as $error) {
                                    echo '<div>' . htmlspecialchars($error) . '</div>';
                                }
                                echo '</div>';
                                echo '</div>';
                                echo '<a href="javascript:history.back()" class="btn btn-secondary btn-back">Go Back</a>';
                                exit;
                            }

                            try {   
                                $sql = "INSERT INTO `employees` (`first_name`, `last_name`, `birthday`, `email`, `phone_number`, 
                                                                `second_phone_number`, `address`, `salary`, `department_id`, `role_id`) 
                                        VALUES (:firstName, :lastName, :birthday, :email, :phone, :secondPhone, :employeeAddress, :salary, :departmentId, :roleId)";
                                
                                $stmt = $pdo->prepare($sql);
                                
                                $stmt->execute([
                                    ':firstName' => $firstName,
                                    ':lastName' => $lastName,
                                    ':birthday' => $birthday,
                                    ':email' => $email,
                                    ':phone' => $phone,
                                    ':secondPhone' => $secondPhone,
                                    ':employeeAddress' => $address,
                                    ':salary' => floatval($salary),
                                    ':departmentId' => intval($departmentId),
                                    ':roleId' => intval($roleId)
                                ]);

                                echo '<div class="alert alert-success">';
                                echo '<div class="alert-icon"><i class="fas fa-check-circle"></i></div>';
                                echo '<div class="alert-title">Success!</div>';
                                echo '<div class="alert-message">Employee <strong>' . htmlspecialchars($firstName . ' ' . $lastName) . '</strong> successfully registered!</div>';
                                echo '</div>';
                                echo '<a href="../views/employees.html" class="btn btn-primary btn-back">Back to Employees</a>';
                                
                                echo '<script>setTimeout(function() { window.location.href = "../views/employees.html"; }, 3000);</script>';
                                
                            } catch (PDOException $e) {
                                echo '<div class="alert alert-danger">';
                                echo '<div class="alert-icon"><i class="fas fa-exclamation-triangle"></i></div>';
                                echo '<div class="alert-title">Error!</div>';
                                echo '<div class="alert-message">Employee <strong>' . htmlspecialchars($firstName . ' ' . $lastName) . '</strong> not registered.</div>';
                                echo '<div class="alert-message"><small>Error: ' . htmlspecialchars($e->getMessage()) . '</small></div>';
                                echo '</div>';
                                echo '<a href="javascript:history.back()" class="btn btn-secondary btn-back">Go Back</a>';
                            }
                        } else {
                            echo '<div class="alert alert-danger">';
                            echo '<div class="alert-icon"><i class="fas fa-exclamation-circle"></i></div>';
                            echo '<div class="alert-title">Invalid Request</div>';
                            echo '<div class="alert-message">Invalid request method.</div>';
                            echo '</div>';
                            echo '<a href="../views/employees.html" class="btn btn-primary btn-back">Back to Employees</a>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="../../public/js/script.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuItems = document.querySelectorAll('.menu-item, #navbarMobileMenu .nav-link');
            menuItems.forEach(item => {
                item.classList.remove('active');
                if (item.getAttribute('data-menu') === 'employees') {
                    item.classList.add('active');
                }
            });
            
            localStorage.setItem('activeMenu', 'employees');
        });
    </script>
</body>
</html>