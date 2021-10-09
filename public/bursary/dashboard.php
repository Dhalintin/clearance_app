<?php

require_once "../../vendor/autoload.php";

use App\Actions\BursaryClearanceActions;

if (checkBursaryLogin()) {
    $sessions = (new BursaryClearanceActions)->getAllSessions();
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
        <!-- MDB -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.css" rel="stylesheet" />
        <link rel="stylesheet" href="../css/main.css" />
        <title>AE-FUNAI Clearance Portal | Bursary Office</title>
    </head>

    <body>
        <?php include "navbar.php"; ?>
        <!-- Jumbotron -->
        <div class="p-5 text-center bg-light">
            <h1 class="my-4 text-primary">Bursary office</h1>
            <h5>Logged in as: <?php echo $_SESSION['bursaryOfficer']; ?></h5>
        </div>
        <!-- Jumbotron -->

        <div class="container px-4 py-5">
            <div class="p-4 text-white bg-dark">
                <h3>Graduating Student Records</h3>
            </div>
            <div class="p-4 border border-dark">
                <div class="gap-4 d-flex flex-column">
                    <?php foreach ($sessions as $session) : ?>
                        <a href="view-record.php?session=<?php echo $session['session']; ?>">
                            <h4 class="p-3 bg-light">
                                <?php echo $session['session']; ?>
                            </h4>
                        </a>
                    <?php endforeach ?>
                    <div>
                        <a class="btn btn-primary" href="add-record.php" role="button">add record</a>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js"></script>
    </body>

    </html>
<?php
} else {
    header("Location: login.php");
    exit();
}
