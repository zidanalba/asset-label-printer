<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Asset Label Printer') - Asset Management System</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <style>
        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 280px;
            background: #2c3e50;
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
        }

        .sidebar.collapsed {
            width: 70px;
        }

        .sidebar-header {
            padding: 1rem;
            border-bottom: 1px solid #34495e;
            text-align: center;
        }

        .sidebar-brand {
            color: white;
            font-size: 1.25rem;
            font-weight: bold;
            text-decoration: none;
        }

        .sidebar-brand:hover {
            color: #ecf0f1;
        }

        .sidebar-brand.collapsed {
            display: none;
        }

        .sidebar-nav {
            padding: 1rem 0;
        }

        .nav-item {
            margin-bottom: 0.25rem;
        }

        .nav-link {
            color: #bdc3c7;
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: white;
            background: #34495e;
        }

        .nav-link.active {
            color: white;
            background: #3498db;
        }

        .nav-link i {
            margin-right: 0.75rem;
            width: 20px;
            text-align: center;
        }

        .nav-link.collapsed i {
            margin-right: 0;
        }

        .nav-link.collapsed span {
            display: none;
        }

        .submenu {
            padding-left: 2.5rem;
            background: #34495e;
            display: none;
        }

        .submenu.show {
            display: block;
        }

        .submenu .nav-link {
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
        }

        .submenu.collapsed {
            padding-left: 0;
        }

        .submenu.collapsed .nav-link {
            padding: 0.5rem;
            text-align: center;
        }

        .submenu.collapsed .nav-link span {
            display: none;
        }

        .toggle-icon {
            margin-left: auto;
            transition: transform 0.3s ease;
        }

        .toggle-icon.rotated {
            transform: rotate(90deg);
        }

        .toggle-icon.collapsed {
            display: none;
        }

        /* Main Content */
        .main-content {
            margin-left: 280px;
            transition: margin-left 0.3s ease;
            min-height: 100vh;
            background: #f8f9fa;
        }

        .main-content.expanded {
            margin-left: 70px;
        }

        .content-wrapper {
            padding: 2rem;
        }

        /* Top Bar */
        .top-bar {
            background: white;
            padding: 1rem 2rem;
            border-bottom: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sidebar-toggle {
            background: none;
            border: none;
            font-size: 1.25rem;
            color: #6c757d;
            cursor: pointer;
        }

        .sidebar-toggle:hover {
            color: #495057;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .main-content.expanded {
                margin-left: 0;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="#" class="sidebar-brand" id="sidebarBrand">
                <i class="bi bi-printer"></i> Asset Label Printer
            </a>
        </div>
        
        <div class="sidebar-nav">
            <!-- Data Master -->
            <div class="nav-item">
                <a href="#dataMasterSubmenu" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="dataMasterSubmenu">
                    <i class="bi bi-database"></i>
                    <span>Data Master</span>
                    <i class="bi bi-chevron-right toggle-icon"></i>
                </a>
                <div class="collapse submenu" id="dataMasterSubmenu">
                    <a href="{{ route('assets.index') }}" class="nav-link {{ request()->routeIs('assets.*') ? 'active' : '' }}">
                        <i class="bi bi-box"></i>
                        <span>Assets</span>
                    </a>
                </div>
            </div>

            <!-- Inventory -->
            <div class="nav-item">
                <a href="#inventorySubmenu" class="nav-link" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="inventorySubmenu">
                    <i class="bi bi-boxes"></i>
                    <span>Inventory</span>
                    <i class="bi bi-chevron-right toggle-icon"></i>
                </a>
                <div class="collapse submenu" id="inventorySubmenu">
                    <a href="{{ route('print.index') }}" class="nav-link {{ request()->routeIs('print.*') ? 'active' : '' }}">
                        <i class="bi bi-printer"></i>
                        <span>Label Printing</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Bar -->
        <div class="top-bar">
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
            
            <div class="user-menu">
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle"></i> Account
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle"></i> {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('info'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="bi bi-info-circle"></i> {{ session('info') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="{{ asset('js/app.js') }}"></script>
    
    <script>
        // Sidebar Toggle Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarBrand = document.getElementById('sidebarBrand');
            const navLinks = document.querySelectorAll('.nav-link');
            const submenus = document.querySelectorAll('.submenu');
            const toggleIcons = document.querySelectorAll('.toggle-icon');

            // Toggle sidebar
            sidebarToggle.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('expanded');
                sidebarBrand.classList.toggle('collapsed');
                
                // Update nav links
                navLinks.forEach(link => {
                    link.classList.toggle('collapsed');
                });
                
                // Update submenus
                submenus.forEach(submenu => {
                    submenu.classList.toggle('collapsed');
                });
                
                // Update toggle icons
                toggleIcons.forEach(icon => {
                    icon.classList.toggle('collapsed');
                });
            });

            // Handle submenu toggles
            const submenuToggles = document.querySelectorAll('[data-bs-toggle="collapse"]');
            submenuToggles.forEach(toggle => {
                toggle.addEventListener('click', function() {
                    const icon = this.querySelector('.toggle-icon');
                    if (icon) {
                        icon.classList.toggle('rotated');
                    }
                });
            });

            // Mobile sidebar toggle
            if (window.innerWidth <= 768) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }
        });
    </script>
    
    @stack('scripts')
</body>
</html> 