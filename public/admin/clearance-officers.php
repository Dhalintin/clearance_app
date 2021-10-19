<?php

use App\Actions\ClearanceOfficerActions;

require_once "../../vendor/autoload.php";

if (checkAdminLogin()) {
    $officers = (new ClearanceOfficerActions)->getAllOfficers();
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" />

        <!-- MDB -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.css" rel="stylesheet" />

        <title>AE-FUNAI Clearance Portal | Admin</title>
    </head>

    <body>
        <?php include "navbar.php"; ?>
        <!-- Jumbotron -->
        <div class="p-5 text-center bg-light">
            <h3 class="my-4 text-primary">Admin | Clearance Officers</h3>
        </div>
        <!-- Jumbotron -->

        <div class="container">
            <?php if (isset($_SESSION['success'])) : ?>
                <div id="alert" class="px-2 pt-5 mx-auto col-md-6">
                    <div class="px-4 py-4 mx-auto d-flex rounded-5 alert-success col-md-12">
                        <h5 class="order-2 d-flex justify-content-end">
                            <i onclick="document.getElementById('alert').classList.add('d-none')" class="fas pe-auto fa-times" role="button"></i>
                        </h5>
                        <h5 style="flex: 1;" class="pt-4"><?php echo $_SESSION['success']; ?></h5>
                    </div>
                </div>
            <?php
                unset($_SESSION['success']);
            endif
            ?>
            <div class="py-5">
                <div class="mb-5 d-flex justify-content-end">
                    <a class="btn btn-primary" href="add-clearance-officer.php" role="button">add clearance officer</a>
                </div>
                <table id="officers" class="table table-bordered table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Full Name</th>
                            <th>Office</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($officers as $officer) : ?>
                            <tr>
                                <td><?php echo $officer->username; ?></td>
                                <td><?php echo $officer->fullname; ?></td>
                                <td><?php echo $officer->office; ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js"></script>
        <script>
            $(document).ready(function() {
                $('#officers').DataTable();
            });
        </script>
    </body>

    </html>
<?php
} else {
    header("Location: login.php");
    exit();
}
