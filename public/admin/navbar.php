<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="px-4 container-fluid">
        <a class="navbar-brand">AE-FUNAI Clearance Portal</a>
        <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php if (checkAdminLogin()) : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../clearance-officer/bursary/dashboard.php">Bursary Office</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../clearance-officer/library/dashboard.php">Library Office</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php else : ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                <?php endif ?>
            </ul>
        </div>
    </div>
</nav>