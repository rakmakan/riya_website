<footer class="footer py-5" style="background-color: var(--card-bg); color: var(--primary-text);">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-4">
                <h3 class="h4 mb-4">Let's Connect</h3>
                <p class="mb-4">Ready to turn your ideas into reality? Let's create something amazing together.</p>
                <div class="social-links">
                    <a href="https://www.linkedin.com/in/riya-uppal01/" class="me-3" style="color: var(--secondary-text);" target="_blank"><i class="fab fa-linkedin-in"></i></a>
                    <a href="https://www.instagram.com/riya279/" style="color: var(--secondary-text);" target="_blank"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
            <div class="col-lg-4">
                <h3 class="h4 mb-4">Quick Links</h3>
                <ul class="list-unstyled footer-links">
                    <li><a href="<?php echo strpos($_SERVER['PHP_SELF'], 'views/') !== false ? '' : 'views/'; ?>about.php" class="text-decoration-none mb-2 d-inline-block" style="color: var(--secondary-text);">About</a></li>
                    <li><a href="<?php echo strpos($_SERVER['PHP_SELF'], 'views/') !== false ? '' : 'views/'; ?>work.php" class="text-decoration-none mb-2 d-inline-block" style="color: var(--secondary-text);">Work</a></li>
                    <li><a href="<?php echo strpos($_SERVER['PHP_SELF'], 'views/') !== false ? '' : 'views/'; ?>case-studies.php" class="text-decoration-none mb-2 d-inline-block" style="color: var(--secondary-text);">Case Studies</a></li>
                    <li><a href="<?php echo strpos($_SERVER['PHP_SELF'], 'views/') !== false ? '' : 'views/'; ?>skills.php" class="text-decoration-none mb-2 d-inline-block" style="color: var(--secondary-text);">Skills</a></li>
                    <li><a href="<?php echo strpos($_SERVER['PHP_SELF'], 'views/') !== false ? 'contact.php' : 'views/contact.php'; ?>" class="text-decoration-none mb-2 d-inline-block" style="color: var(--secondary-text);">Contact</a></li>
                </ul>
            </div>
            <div class="col-lg-4">
                <h3 class="h4 mb-4">Get in Touch</h3>
                <p class="mb-2"><i class="fas fa-envelope me-2"></i> riyauppal777@gmail.com</p>
                <p class="mb-2"><i class="fas fa-phone me-2"></i> +19029897510</p>
                <p class="mb-0"><i class="fas fa-map-marker-alt me-2"></i> Toronto, Canada</p>
            </div>
        </div>
        <hr class="my-4" style="background-color: var(--border-color); opacity: 0.5;">
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0">&copy; <?php echo date('Y'); ?> Portfolio. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-end mt-3 mt-md-0">
                <p class="mb-0">Designed with <i class="fas fa-heart" style="color: var(--muted-gold);"></i> by Riya</p>
            </div>
        </div>
    </div>
</footer>

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- AOS JS -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<!-- Custom JS -->
<script src="<?php echo strpos($_SERVER['PHP_SELF'], 'views/') !== false ? '../assets/js/main.js' : 'assets/js/main.js'; ?>"></script>

</body>
</html>