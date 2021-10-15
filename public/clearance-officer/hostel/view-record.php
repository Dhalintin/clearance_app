<?php

require_once "../../../vendor/autoload.php";

use App\Actions\BursaryClearanceActions;

if (checkClearanceOfficerLogin('bursary')) {
    $office = 'bursary';
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

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" />
        <title>AE-FUNAI Clearance Portal | Bursary Office</title>
    </head>

    <body>
        <?php include "../navbar.php"; ?>
        <!-- Jumbotron -->
        <div class="p-5 text-center bg-light">
            <h3 class="my-4 text-primary">Bursary office | Student records</h3>
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
                <h3 class="mb-5 text-center"><?php echo $session; ?> session</h3>
                <div class="mb-5 d-flex justify-content-end">
                    <a class="btn btn-primary" href="add-record.php?session=<?php echo $session; ?>" role="button">add students</a>
                </div>
                <table id="students" class="table table-bordered table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>REG NO.</th>
                            <th>Session</th>
                            <th>Clearance Status</th>
                            <th>Approve/Set as pending</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $student) : ?>
                            <tr>
                                <td><?php echo $student->reg_no; ?></td>
                                <td><?php echo $student->session; ?></td>
                                <td><?php echo $student->clearance_status; ?></td>
                                <td>
                                    <?php if ($student->clearance_status === 'cleared') : ?>
                                        <a href="set-status.php?regNo=<?php echo $student->reg_no . '&status=pending';?>" title="set as pending" class="btn-sm btn btn-danger" role="button">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    <?php else : ?>
                                        <a href="set-status.php?regNo=<?php echo $student->reg_no . '&status=cleared';?>" title="approve" class="btn btn-sm btn-success" role="button">
                                            <i class="fas fa-check"></i>
                                        </a>
                                    <?php endif ?>
                                </td>
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
                $('#students').DataTable();
            });
        </script>
    </body>

    </html>
<?php
} else {
    header("Location: ../login.php");
    exit();
}
