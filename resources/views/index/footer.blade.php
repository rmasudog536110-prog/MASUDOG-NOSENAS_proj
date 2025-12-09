<!-- index.footer -->
<link rel="stylesheet" href="{{ asset('css/footer.css') }}">

<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h3>FitClub</h3>
                <p>Transform your body and mind with our premium fitness programs. Join thousands of satisfied members worldwide.</p>
                <div class="social-links">
                    <a href="#" class="social-link "><i class="fa-brands fa-facebook"></i>Facebook</a>
                    <a href="#" class="social-link"><i class="fa-brands fa-instagram"></i>Instagram</a>
                    <a href="#" class="social-link"><i class="fa-brands fa-x-twitter"></i>Twitter</a>
                    <a href="#" class="social-link"><i class="fa-brands fa-youtube"></i>YouTube</a>
                </div>
            </div>
            
            <div class="footer-section">
                <h4>Programs</h4>
                <ul class="footer-links">
                    <li><a href="programs">Training Programs</a></li>
                    <li><a href="exercises">Exercise Library</a></li>
                    <li><a href="../PHP/index.php#subscription-plans">Subscription Plans</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h4>Support</h4>
                <ul class="footer-links">
                    <li><a href="help.php">Help Center</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
                    <li><a href="faq.php">FAQ</a></li>
                    <li><a href="terms.php">Terms of Service</a></li>
                    <li><a href="privacy.php">Privacy Policy</a></li>
                </ul>
            </div>
            
            <div class="footer-section">
                <h4>Contact Info</h4>
                <div class="contact-info">
                    <p><strong>Email:</strong> support@fitclub.com</p>
                    <p><strong>Phone:</strong> +63 928 459 4158</p>
                    <p><strong>Address:</strong> Matina Gravahan, Davao City, Philippines</p>
                    <p><strong>Hours:</strong> 24/7 Online Support</p>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <p>&copy; <?php echo date('Y'); ?> FitClub. All rights reserved.</p>
                <div class="payment-methods">
                    <span>We Accept:</span>
                        <img src="{{ asset('imgs/gcash-logo.jpg') }}" alt="GCash" class="payment-logo">
                        <img src="{{ asset('imgs/paymaya-logo.png') }}" alt="PayMaya" class="payment-logo">
                        <img src="{{ asset('imgs/mastercard-logo.jpg') }}" alt="Mastercard" class="payment-logo">

                </div>
            </div>
        </div>
    </div>
</footer>
