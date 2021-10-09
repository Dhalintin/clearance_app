<?php

require_once "../../vendor/autoload.php";

use App\Actions\BursaryClearanceActions;

if (checkBursaryLogin()) {
    $session = $_GET['session'];
    if (!$session) {
        header("Location: dashboard.php");
        exit();
    }
    $students = (new BursaryClearanceActions)->getStudentsBySession($session);
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" />
        <title>AE-FUNAI Clearance Portal | Bursary Office</title>
    </head>

    <body>
        <?php include "navbar.php"; ?>
        <!-- Jumbotron -->
        <div class="p-5 text-center bg-light">
            <h3 class="my-4 text-primary">Bursary office | Student records</h3>
        </div>
        <!-- Jumbotron -->

        <div class="container">
            <div class="p-4">
                <h3 class="mb-5 text-center"><?php echo $session; ?> session</h3>
                <div class="mb-5 d-flex justify-content-end">
                    <button class="btn btn-primary">
                        add student
                    </button>
                </div>
                <table id="students" class="table table-bordered table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>REG NO.</th>
                            <th>Session</th>
                            <th>Clearance Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student) : ?>
                            <tr>
                                <td><?php echo $student->reg_no; ?></td>
                                <td><?php echo $student->session; ?></td>
                                <td><?php echo $student->clearance_status; ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#students').DataTable();
            });
        </script>
    </body>

    </html>
<?php
} else {
    header("Location: login.php");
    exit();
}
