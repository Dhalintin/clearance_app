<?php

use App\Actions\BursaryClearanceActions;
use App\Actions\LibraryClearanceActions;

require_once "../../vendor/autoload.php";

if (checkStudentLogin()) {
    $bursaryClearance = (new BursaryClearanceActions)->findStudent($_SESSION['student']);
    $bursaryClearanceStatus = $bursaryClearance->clearance_status ?? $bursaryClearance;
    $libraryClearance = (new LibraryClearanceActions)->findStudent($_SESSION['student']);
    $libraryClearanceStatus = $libraryClearance->clearance_status ?? $libraryClearance;
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>AE-FUNAI Clearance Portal | Student Dashboard</title>
        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
        <!-- MDB -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="../css/main.css" />

    </head>

    <body>
        <?php include "navbar.php"; ?>
        <!-- Jumbotron -->
        <div class="p-5 text-center bg-light">
            <h1 class="my-4 text-primary">Welcome to AE-FUNAI clearance portal</h1>
            <h5>Logged in as: <?php echo $_SESSION['student']; ?></h5>
        </div>
        <!-- Jumbotron -->
        <div class="container">
            <?php if (isset($_SESSION['clearanceRequestCreated'])) : ?>
                <div id="alert" class="px-2 pt-5 mx-auto col-md-10">
                    <div class="px-4 py-4 mx-auto d-flex rounded-5 alert-success col-md-10">
                        <h5 class="order-2 d-flex justify-content-end">
                            <i onclick="document.getElementById('alert').classList.add('d-none')" class="fas pe-auto fa-times" role="button"></i>
                        </h5>
                        <h5 class="pt-4"><?php echo $_SESSION['clearanceRequestCreated']; ?></h5>
                    </div>
                </div>
            <?php
                unset($_SESSION['clearanceRequestCreated']);
            endif
            ?>
            <div class="flex-wrap gap-4 px-4 py-5 mx-auto d-flex justify-content-center col-md-10 flex-column flex-sm-row">
                <div class="p-4 col-md-5 shadow-1 rounded-6 bg-dark">
                    <div class="mb-4 text-white">
                        <h3>Course Clearance</h3>
                    </div>
                    <div>
                        <div class="text-white shadow-none btn btn-success pe-none">
                            <i class="fas fa-check"></i> Cleared
                        </div>
                    </div>
                </div>

                <div class="p-4 col-md-5 shadow-2 rounded-6 bg-dark">
                    <div class="mb-4 text-white">
                        <h3>Bursary Clearance</h3>
                    </div>
                    <div>
                        <?php if ($bursaryClearanceStatus === 'cleared') : ?>
                            <div class="text-white shadow-none btn btn-success pe-none">
                                <i class="fas fa-check"></i> Cleared
                            </div>
                        <?php elseif ($bursaryClearanceStatus === 'pending') : ?>
                            <div class="text-white shadow-none btn btn-warning pe-none">
                                pending
                            </div>
                        <?php else : ?>
                            <button id="bursary" class="btn btn-primary" onclick="bursaryVerify(event.target)" role="button">
                                Start
                            </button>
                        <?php endif ?>
                    </div>
                </div>

                <div class="p-4 col-md-5 shadow-1 rounded-6 bg-dark">
                    <div class="mb-4 text-white">
                        <h3>Library Clearance</h3>
                    </div>
                    <div>
                        <?php if ($libraryClearanceStatus === 'cleared') : ?>
                            <div class="text-white shadow-none btn btn-success pe-none">
                                <i class="fas fa-check"></i> Cleared
                            </div>
                        <?php elseif ($libraryClearanceStatus === 'pending') : ?>
                            <div class="text-white shadow-none btn btn-warning pe-none">
                                pending
                            </div>
                        <?php else : ?>
                            <a class="btn btn-primary" href="library-clearance.php" role="button">Start</a>
                        <?php endif ?>
                    </div>
                </div>

                <div class="p-4 col-md-5 shadow-1 rounded-6 bg-dark">
                    <div class="mb-4 text-white">
                        <h3>Hostel Clearance</h3>
                    </div>
                    <div>
                        <a class="btn btn-primary" href="hostel-clearance.php" role="button">Start</a>
                    </div>
                </div>
            </div>
        </div>
        <script>
            function bursaryVerify(button) {
                let student;
                button.innerText = 'Verifying payments...';
                bursaryVerification().then((response) => {
                    location.reload()
                }).catch((error) => console.error(error));
            }
        </script>
        <script defer src="https://unpkg.com/alpinejs@3.4.2/dist/cdn.min.js" defer></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js"></script>
        <script src="../js/student-clearance.js"></script>
    </body>

    </html>
<?php
} else {
    header("Location: login.php");
    exit();
}
