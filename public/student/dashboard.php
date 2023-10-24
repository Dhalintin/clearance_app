<?php

use App\Actions\BursaryClearanceActions;
use App\Actions\LibraryClearanceActions;
use App\Actions\HostelClearanceActions;

require_once "../../vendor/autoload.php";

if (checkStudentLogin()) {
    $bursaryClearance = (new BursaryClearanceActions)->findStudent($_SESSION['student']);
    $bursaryClearanceStatus = $bursaryClearance->clearance_status ?? $bursaryClearance;
    $libraryClearance = (new LibraryClearanceActions)->findStudent($_SESSION['student']);
    $libraryClearanceStatus = $libraryClearance->clearance_status ?? $libraryClearance;
    $hostelClearance = (new HostelClearanceActions)->findStudentRecords($_SESSION['student']);
    $hostelClearanceStatus = 'upload receipts';
    // (empty($hostelClearance)) ? null : $hostelClearance[0]->clearance_status;
    $clearanceCount = count($hostelClearance);
    if ($clearanceCount > 0) {
        if ($clearanceCount > count(array_filter(array_column($hostelClearance, 'receipt_image')))) {
            $hostelClearanceStatus = 'upload receipts';
        }
    }
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

            <?php if ($bursaryClearanceStatus === 'cleared' && $libraryClearanceStatus === 'cleared' &&  $hostelClearanceStatus === 'cleared') : ?>
                <div class="flex-wrap gap-4 px-4 py-5 mx-auto d-flex justify-content-center col-md-10 flex-column flex-sm-row">
                    <div class=" col-md-10">
                        <a href="#" id="printButton" type="button" class="btn btn-primary" role="button">
                            Print Prove Of Clearance
                        </a>
                    </div>
                </div>
            <?php else : ?>
                <div class="flex-wrap gap-4 px-4 py-5 mx-auto d-flex justify-content-center col-md-10 flex-column flex-sm-row">
                    <div class=" col-md-10">
                        <a type="button" class="btn btn-primary" role="button" onclick="alert('You have a pending clearance to complete')">
                            Print Prove Of Clearance
                        </a>
                    </div>
                </div>
            <?php endif ?>

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
                        <h3>Falculty Clearance</h3>
                    </div>
                    <div>
                        <?php if ($bursaryClearanceStatus === 'cleared') : ?>
                            <div class="text-white shadow-none btn btn-success pe-none">
                                <i class="fas fa-check"></i> Cleared
                            </div>
                        <?php elseif ($bursaryClearanceStatus === 'pending') : ?>
                            <div class="text-white shadow-none btn btn-info pe-none">
                                pending
                            </div>
                        <?php else : ?>
                            <a href="bursary-verification.php" class="btn btn-primary" role="button">
                                Start
                            </a>
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
                            <div class="text-white shadow-none btn btn-info pe-none">
                                pending
                            </div>
                        <?php else : ?>
                            <a class="btn btn-primary" href="library-clearance.php" role="button">Start</a>
                        <?php endif ?>
                    </div>
                </div>

                <div class="p-4 col-md-5 shadow-1 rounded-6 bg-dark">
                    <div class="mb-4 text-white">
                        <h3>Department Clearance</h3>
                    </div>
                    <div>
                        <?php if ($hostelClearanceStatus === 'cleared') : ?>
                            <div class="text-white shadow-none btn btn-success pe-none">
                                <i class="fas fa-check"></i> Cleared
                            </div>
                        <?php elseif ($hostelClearanceStatus === 'upload receipts') : ?>
                            <a href="hostel-clearance.php" class="btn btn-primary" role="button">
                                Upload Receipts
                            </a>
                        <?php elseif ($hostelClearanceStatus === 'pending') : ?>
                            <div class="text-white shadow-none btn btn-info pe-none">
                                pending verification
                            </div>
                        <?php elseif ($hostelClearanceStatus === null) : ?>
                            <div class="text-white shadow-none btn btn-warning pe-none">
                                No department records found
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js"></script>
    </body>
    <script>
        document.getElementById("printButton").addEventListener("click", function() {
            printDocument();
        });

        function printDocument() {
            // Replace 'document-url.pdf' with the URL or path to your specific document
            var documentUrl = './print.pdf';

            // Open the document in a new window
            var newWindow = window.open(documentUrl, '_blank');

            // Add an event listener to print the document when it finishes loading
            newWindow.onload = function() {
                newWindow.print();
                newWindow.onafterprint = function() {
                    newWindow.close(); // Close the new window after printing
                };
            };
        }
    </script>

    </html>
<?php
} else {
    header("Location: login.php");
    exit();
}
