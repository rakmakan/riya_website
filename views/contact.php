<?php
require_once '../database/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Me - Riya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <style>
        .contact-header {
            background: linear-gradient(to right, var(--primary-bg), var(--card-bg));
            padding: 6rem 0 4rem;
            color: var(--primary-text);
            margin-bottom: 3rem;
            position: relative;
        }
        
        .contact-header::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            height: 50px;
            background: linear-gradient(to right bottom, transparent 49%, var(--card-bg) 50%);
        }
        
        .contact-form-container {
            background-color: var(--card-bg);
            border-radius: 1rem;
            box-shadow: 0 10px 30px var(--shadow-color);
            padding: 3rem;
            margin-bottom: 5rem;
        }
        
        .contact-info-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 2rem;
        }
        
        .contact-icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background-color: var(--light-gray);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            color: var(--primary-color);
            font-size: 1.25rem;
            flex-shrink: 0;
        }
        
        .form-control {
            padding: 0.8rem 1.2rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }
        
        .contact-submit-btn {
            padding: 0.8rem 2rem;
            border-radius: 50px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .contact-submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .response-message {
            display: none;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-top: 1rem;
        }
        
        /* Dark mode overrides */
        .dark-mode .contact-form-container {
            background-color: var(--card-bg);
        }
        
        .dark-mode .contact-icon {
            background-color: rgba(255,255,255,0.05);
        }
    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>

    <!-- Contact Header -->
    <section class="contact-header">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <h1 class="display-4 fw-bold mb-4">Get In Touch</h1>
                    <p class="lead">I'd love to hear from you. Whether you have a project in mind or just want to say hello,
                        drop me a message and I'll get back to you as soon as possible.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Content -->
    <section class="contact-content section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="contact-form-container">
                        <div class="row">
                            <div class="col-md-5">
                                <h3 class="mb-4">Contact Information</h3>
                                
                                <div class="contact-info-item">
                                    <div class="contact-icon">
                                        <i class="fas fa-envelope"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Email</h5>
                                        <p class="mb-0">riyauppal777@gmail.com</p>
                                    </div>
                                </div>
                                
                                <div class="contact-info-item">
                                    <div class="contact-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Location</h5>
                                        <p class="mb-0">Toronto, Canada</p>
                                    </div>
                                </div>
                                
                                <div class="contact-info-item">
                                    <div class="contact-icon">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1">Working Hours</h5>
                                        <p class="mb-0">Mon - Fri: 9AM - 6PM</p>
                                    </div>
                                </div>
                                
                                <div class="mt-5">
                                    <h5 class="mb-3">Follow Me</h5>
                                    <div class="d-flex gap-3">
                                        <a href="https://www.linkedin.com/in/riya-uppal01/" class="text-decoration-none">
                                            <i class="fab fa-linkedin fa-lg"></i>
                                        </a>
                                        <a href="https://www.instagram.com/riya279/" class="text-decoration-none">
                                            <i class="fab fa-instagram fa-lg"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-7">
                                <h3 class="mb-4">Send Me a Message</h3>
                                
                                <form id="contactForm" action="../services/process_contact.php" method="POST">
                                    <div class="form-group">
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <textarea class="form-control" id="message" name="message" rows="5" placeholder="Your Message" required></textarea>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary contact-submit-btn">
                                        <span>Send Message</span>
                                        <i class="fas fa-paper-plane ms-2"></i>
                                    </button>
                                </form>
                                
                                <div class="alert alert-success response-message" id="successMessage">
                                    Thank you for your message. I will get back to you soon!
                                </div>
                                
                                <div class="alert alert-danger response-message" id="errorMessage">
                                    Sorry, there was an error sending your message. Please try again.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php include '../includes/footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="../assets/js/main.js"></script>
    <script>
        $(document).ready(function() {
            // Reset message displays on new submission
            function resetMessages() {
                $('#successMessage').hide();
                $('#errorMessage').hide();
            }
            
            // Contact form submission
            $('#contactForm').on('submit', function(e) {
                e.preventDefault();
                resetMessages();
                
                const button = $(this).find('button[type="submit"]');
                const originalButtonText = button.html();
                button.html('<i class="fas fa-spinner fa-spin"></i> Sending...');
                button.prop('disabled', true);
                
                $.ajax({
                    type: 'POST',
                    url: '../services/process_contact.php',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            $('#successMessage').fadeIn();
                            $('#contactForm')[0].reset();
                            button.html('<i class="fas fa-check"></i> Message Sent!');
                            setTimeout(() => {
                                window.location.href = 'thank-you.php';
                            }, 2000);
                        } else {
                            $('#errorMessage').fadeIn().text(response.message || 'An error occurred. Please try again.');
                            button.html(originalButtonText).prop('disabled', false);
                        }
                    },
                    error: function() {
                        $('#errorMessage').fadeIn().text('An error occurred. Please try again later.');
                        button.html(originalButtonText).prop('disabled', false);
                    }
                });
            });
        });
    </script>
</body>
</html>