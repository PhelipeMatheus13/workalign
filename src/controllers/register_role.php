<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <title>WorkAlign - New Role</title>
    <style>
        /* Conteúdo principal centralizado */
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

        /* Ajustes para mobile */
        @media (max-width: 768px) {
            .col-md-9 {
                padding: 10px;
            }
            
            .alert {
                padding: 20px;
            }
            
            .btn-back {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="../../public/index.html">
            <i class="fa-solid fa-users-gear" style="color: #ffffff;"></i> WorkAlign
        </a>

        <!-- Botão do menu mobile -->
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
            <!-- MENU LATERAL -->
            <div class="col-md-3 menu d-none d-md-block">
                <ul class="menu">
                    <li>
                        <a href="../../public/index.html" class="menu-item" data-menu="dashboard">
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

            <!-- CONTEÚDO PRINCIPAL -->
            <div class="col-md-9">
               <div class="alert-container">
                  <?php
                  // Habilitar exibição de erros para debug (remover em produção)
                  error_reporting(E_ALL);
                  ini_set('display_errors', 1);

                  require_once "../../config/database.php";

                  // Verificar se o formulário foi submetido
                  if ($_SERVER["REQUEST_METHOD"] == "POST") {
                     
                     // Coletar dados
                     $name = $_POST['role_name'] ?? '';
                     $description = $_POST['role_description'] ?? '';
                     $department_id = $_POST['department_id'] ?? '';

                     // Validar se department_id existe
                     if (empty($department_id)) {
                        echo '<div class="alert alert-danger">';
                        echo '<div class="alert-icon"><i class="fas fa-exclamation-triangle"></i></div>';
                        echo '<div class="alert-title">Error!</div>';
                        echo '<div class="alert-message">Department ID is missing.</div>';
                        echo '</div>';
                        echo '<a href="javascript:history.back()" class="btn btn-secondary btn-back">Go Back</a>';
                        exit();
                     }

                     try {
                         // Preparar e executar a query usando PDO
                         $sql = "INSERT INTO `roles` (`name`, `description`, `department_id`) 
                                 VALUES (:name, :description, :department_id)";
                         $stmt = $pdo->prepare($sql);
                         $stmt->execute([
                             ':name' => $name,
                             ':description' => $description,
                             ':department_id' => $department_id
                         ]);

                         echo '<div class="alert alert-success">';
                         echo '<div class="alert-icon"><i class="fas fa-check-circle"></i></div>';
                         echo '<div class="alert-title">Success!</div>';
                         echo '<div class="alert-message">Role <strong>' . htmlspecialchars($name) . '</strong> successfully registered!</div>';
                         echo '</div>';
                         
                         // Botão para voltar para a página do departamento com o ID correto
                         echo '<a href="../views/departments_roles.html?department_id=' . $department_id . '" class="btn btn-primary btn-back">Back to Roles</a>';
                         
                         // Redirecionar automaticamente após 3 segundos
                         echo '<script>setTimeout(function() { window.location.href = "../views/departments_roles.html?department_id=' . $department_id . '"; }, 3000);</script>';
                     } catch (PDOException $e) {
                         echo '<div class="alert alert-danger">';
                         echo '<div class="alert-icon"><i class="fas fa-exclamation-triangle"></i></div>';
                         echo '<div class="alert-title">Error!</div>';
                         echo '<div class="alert-message">Role <strong>' . htmlspecialchars($name) . '</strong> not registered.</div>';
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
                     
                     // Tentar obter department_id da referência ou usar valor padrão
                     $department_id = isset($_GET['department_id']) ? $_GET['department_id'] : '';
                     if ($department_id) {
                        echo '<a href="../views/departments_roles.html?department_id=' . $department_id . '" class="btn btn-primary btn-back">Back to Roles</a>';
                     } else {
                        echo '<a href="../views/departments.html" class="btn btn-primary btn-back">Back to Departments</a>';
                     }
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
        document.addEventListener('DOMContentLoaded', function () {
            // Marcar o menu de departamentos como ativo
            const menuItems = document.querySelectorAll('.menu-item, #navbarMobileMenu .nav-link');
            menuItems.forEach(item => {
                item.classList.remove('active');
                if (item.getAttribute('data-menu') === 'departments') {
                    item.classList.add('active');
                }
            });

            // Salvar no localStorage que estamos na página de departamentos
            localStorage.setItem('activeMenu', 'departments');
        });
    </script>
</body>
</html>