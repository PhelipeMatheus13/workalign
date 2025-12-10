<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="/workalign/">
    <link rel="stylesheet" href="public/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <title>WorkAlign - <?= $pageTitle ?? 'Dashboard' ?></title>
    <?= $styles ?? '' ?>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="dashboard">
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
                    <a class="nav-link" href="dashboard" data-menu="dashboard">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="employees" data-menu="employees">
                        <i class="fas fa-users"></i> Employees
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="departments" data-menu="departments">
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
            <!-- Menu lateral -->
            <div class="col-md-3 menu d-none d-md-block">
                <ul class="menu">
                    <li>
                        <a href="dashboard" class="menu-item" data-menu="dashboard">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="employees" class="menu-item" data-menu="employees">
                            <i class="fas fa-users"></i>
                            <span>Employees</span>
                        </a>
                    </li>
                    <li>
                        <a href="departments" class="menu-item" data-menu="departments">
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

            <!-- Conteúdo principal -->
            <div class="col-md-9 main-content">
                <?= $content ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="public/js/script.js"></script>
    <?= $scripts ?? '' ?>
    <?= $inlineScript ?? '' ?>
</body>
</html>