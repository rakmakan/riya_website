<?php
require_once '../database/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thank You - Riya</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- AOS CSS -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="../assets/css/style.css" rel="stylesheet">
    <style>
        .thank-you-section {
            padding: 100px 0;
            text-align: center;
        }
        
        .thank-you-container {
            background-color: white;
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            padding: 3rem;
            margin-bottom: 2rem;
        }
        
        .thank-you-icon {
            width: 100px;
            height: 100px;
            background-color: #e9f9f0;
            color: #28a745;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 3rem;
            margin: 0 auto 2rem;
        }
        
        .dark-mode .thank-you-container {
            background-color: #2d3436;
        }
        
        .dark-mode .thank-you-icon {
            background-color: rgba(40, 167, 69, 0.1);
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <!-- Thank You Section -->
    <section class="thank-you-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="thank-you-container" data-aos="fade-up">
                        <div class="thank-you-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        
                        <h1 class="mb-4">Thank You!</h1>
                        <p class="lead mb-4">Your message has been sent successfully. I appreciate you reaching out!</p>
                        
                        <p class="mb-5">I'll review your message and get back to you as soon as possible, typically within 24-48 hours.</p>
                        
                        <div class="mt-5">
                            <a href="../index.php" class="btn btn-primary me-3">
                                <i class="fas fa-home me-2"></i> Back to Home
                            </a>
                            <a href="case-studies.php" class="btn btn-outline-primary">
                                <i class="fas fa-briefcase me-2"></i> View Case Studies
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include '../includes/footer.php'; ?>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS JS -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Custom JS -->
    <script src="../assets/js/main.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize AOS animation
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true
            });
        });
    </script>
</body>
</html>