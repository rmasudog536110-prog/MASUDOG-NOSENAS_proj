<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <h3>FitClub</h3>
                <p>Transform your body and mind with our premium fitness programs. Join thousands of satisfied members worldwide.</p>
                <div class="social-links">
                    <a href="#" class="social-link">Facebook</a>
                    <a href="#" class="social-link">Instagram</a>
                    <a href="#" class="social-link">Twitter</a>
                    <a href="#" class="social-link">YouTube</a>
                </div>
            </div>
            
            <div class="footer-section">
                <h4>Programs</h4>
                <ul class="footer-links">
                    <li><a href="programs.php">Training Programs</a></li>
                    <li><a href="exercises.php">Exercise Library</a></li>
                    <li><a href="../PHP/index.php#subscription-plans">Subscription Plans</a></li>
                    <?php if (SessionManager::isLoggedIn()): ?>
                        <li><a href="../PHP/dashboard.php">My Dashboard</a></li>
                    <?php endif; ?>
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
                    <p><strong>Phone:</strong> +63 912 345 6789</p>
                    <p><strong>Address:</strong> 123 Fitness Street, Makati City, Philippines</p>
                    <p><strong>Hours:</strong> 24/7 Online Support</p>
                </div>
            </div>
        </div>
        
        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <p>&copy; <?php echo date('Y'); ?> FitClub. All rights reserved.</p>
                <div class="payment-methods">
                    <span>We Accept:</span>
                    <img src="assets/images/gcash-logo.png" alt="GCash" class="payment-logo" onerror="this.style.display='none'">
                    <img src="assets/images/paymaya-logo.png" alt="PayMaya" class="payment-logo" onerror="this.style.display='none'">
                    <img src="assets/images/visa-logo.png" alt="Visa" class="payment-logo" onerror="this.style.display='none'">
                    <img src="assets/images/mastercard-logo.png" alt="Mastercard" class="payment-logo" onerror="this.style.display='none'">
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
.footer {
    background-color: var(--primary);
    color: var(--primary-foreground);
    padding: 3rem 0 1rem;
    margin-top: 5rem;
}

.footer-content {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-bottom: 2rem;
}

.footer-section h3,
.footer-section h4 {
    margin-bottom: 1rem;
    color: var(--primary-foreground);
}

.footer-section p {
    margin-bottom: 1rem;
    opacity: 0.9;
}

.footer-links {
    list-style: none;
    padding: 0;
}

.footer-links li {
    margin-bottom: 0.5rem;
}

.footer-links a {
    color: var(--primary-foreground);
    text-decoration: none;
    opacity: 0.8;
    transition: opacity 0.2s ease;
}

.footer-links a:hover {
    opacity: 1;
}

.social-links {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
}

.social-link {
    color: var(--primary-foreground);
    text-decoration: none;
    opacity: 0.8;
    transition: opacity 0.2s ease;
}

.social-link:hover {
    opacity: 1;
}

.contact-info p {
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.footer-bottom {
    border-top: 1px solid rgba(255, 255, 255, 0.2);
    padding-top: 1rem;
}

.footer-bottom-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.payment-methods {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
}

.payment-logo {
    height: 20px;
    opacity: 0.8;
}

@media (max-width: 768px) {
    .footer-content {
        grid-template-columns: 1fr;
        text-align: center;
    }
    
    .footer-bottom-content {
        text-align: center;
        flex-direction: column;
    }
    
    .social-links {
        justify-content: center;
    }
}
</style>