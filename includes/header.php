<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Professional Portfolio - Creative Designer & Developer">
    <title>airyalps</title>
    
    <!-- Inter Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="<?php echo strpos($_SERVER['PHP_SELF'], 'views/') !== false ? '../assets/css/style.css' : 'assets/css/style.css'; ?>" rel="stylesheet">
</head>
<body>
<header class="header fixed-top">
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="<?php echo strpos($_SERVER['PHP_SELF'], 'views/') !== false ? '../index.php' : 'index.php'; ?>">
                <img src="<?php echo strpos($_SERVER['PHP_SELF'], 'views/') !== false ? '../assets/images/airy-alps-logo-7.png' : 'assets/images/airy-alps-logo-7.png'; ?>" alt="AIRYALPS" height="40">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo strpos($_SERVER['PHP_SELF'], 'views/') !== false ? '../index.php' : 'index.php'; ?>">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo strpos($_SERVER['PHP_SELF'], 'views/') !== false ? 'about.php' : 'views/about.php'; ?>">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo strpos($_SERVER['PHP_SELF'], 'views/') !== false ? 'skills.php' : 'views/skills.php'; ?>">Skills</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo strpos($_SERVER['PHP_SELF'], 'views/') !== false ? 'work.php' : 'views/work.php'; ?>">Work</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo strpos($_SERVER['PHP_SELF'], 'views/') !== false ? 'case-studies.php' : 'views/case-studies.php'; ?>">Case Studies</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo strpos($_SERVER['PHP_SELF'], 'views/') !== false ? 'contact.php' : 'views/contact.php'; ?>">Contact</a>
                    </li>
                    <li class="nav-item">
                        <button id="darkModeToggle" class="btn" aria-label="Toggle dark mode">
                            🌙
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>