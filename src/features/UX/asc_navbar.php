<div class="navbar-wrapper">
    <nav class="navbar">
        <div class="logo">
            <a href="../../features/UX/asc_dashboard.php">
            <?php
            // Dynamically adjust logo path depending on where this file is included from
            $logo_path = isset($page_context) && $page_context === 'imgGen'
                ? '../public/images/FullNameLogo.png'
                : '../../../public/images/FullNameLogo.png';
            ?>
            <img src="<?php echo $logo_path; ?>" alt="Aureolin Logo">
                <span class="logo-text"></span>
            </a>
        </div>

        <ul class="nav-links">
            <li><a href="../../../templates/imgGen.php">Image Generation</a></li>
            <!-- <li class="dropdown">
                <a href="#">Stats ▼</a>
                <ul class="dropdown-menu">
                    <li><a href="../../features/UX/asc_stats.php?username=<?php echo $_SESSION['username'] ?? ''; ?>">Stats</a></li>
                    <li><a href="../../../features/UX/asc_leaderboards.php">Leaderboards</a></li>
                </ul>
            </li> -->
            <li class="dropdown">
                <a href="#">Learning ▼</a>
                <ul class="dropdown-menu">
                    <li><a href="../../features/UX/asc_gamestart.php">New Game</a></li>
                </ul>
            </li>
            <li><a href="../../../src/features/faceid/setupfaceid.php">Set Up Face ID</a></li>
            <li><a href="../../../templates/faceLogin.html">Login</a></li>
            <li><a href="../../../public/index.php">Sign Out</a></li>
        </ul>

        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </nav>
</div>