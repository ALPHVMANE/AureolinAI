<style>
    html, body {
    height: 100%;
    margin: 0;
    display: flex;
    flex-direction: column;
}

/* Push content to take up remaining space */
.main-content {
    flex: 1;
}

/* Footer styles */
.footer {
    background-color: #9EB1C5;
    color: #84572f;
    text-align: center;
    padding: 15px 0;
    width: 100%;
    margin-top: auto; /* Push footer to bottom */
}

.footer-container {
    max-width: 1200px;
    margin: 0 auto;
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 10px 0 0;
    display: flex;
    justify-content: center;
    gap: 15px;
}

.footer-links li {
    display: inline;
}

.footer-links a {
    color: #84572f;
    text-decoration: none;
    font-size: 14px;
}

.footer-links a:hover {
    color: #FFD700;
}
</style>

<footer class="footer">
    <div class="footer-container">
        <p>&copy; <?php echo date("Y"); ?> Aureolin Learning. All rights reserved.</p>
        <ul class="footer-links">
            <li><a href="asc_dashboard.php">Home</a></li>
            <li><a href="#">Privacy Policy</a></li>
            <li><a href="#">Terms of Service</a></li>
            <li><a >Contact Us</a></li>
        </ul>
    </div>
</footer>