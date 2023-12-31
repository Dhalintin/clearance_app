<?php

require_once "../../../vendor/autoload.php";

use App\Actions\LibraryClearanceActions;

if (checkClearanceOfficerLogin('library')) {
    $office = 'library';
    $session = $_GET['session'];
    if (!$session) {
        header("Location: dashboard.php");
        exit();
    }
    $students = (new LibraryClearanceActions)->getStudentsBySession($session);
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Font Awesome -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet" />
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" />

        <!-- MDB -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.css" rel="stylesheet" />
        <title>AE-FUNAI Clearance Portal | Library Office</title>
    </head>

    <body>
        <?php include "../navbar.php"; ?>
        <!-- Jumbotron -->
        <div class="p-5 text-center bg-light">
            <h3 class="my-4 text-primary">Library office | Student records</h3>
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
                <table id="students" class="table table-bordered table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>REG NO.</th>
                            <th>Library Card</th>
                            <th>Clearance Status</th>
                            <th>Approve/Set as pending</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $key => $student) : ?>
                            <tr>
                                <td><?php echo $student->reg_no; ?></td>
                                <td>
                                    <img role="button" style="object-fit: scale-down; height: 80px;" class="w-100" data-mdb-toggle="modal" data-mdb-target="#exampleModal<?php echo $key; ?>" src="../../uploads/library-cards/<?php echo $student->library_card_image; ?>">
                                    <div class="modal fade" id="exampleModal<?php echo $key; ?>" tabindex="-1" aria-labelledby="exampleModalLabel<?php echo $key; ?>" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel<?php echo $key; ?>"><?php echo $student->reg_no; ?></h5>
                                                    <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <img style="object-fit: scale-down; height: 320px;" class="w-100" src="../../uploads/library-cards/<?php echo $student->library_card_image; ?>">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-sm btn-secondary" data-mdb-dismiss="modal">
                                                        Close
                                                    </button>
                                                    <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td><?php echo $student->clearance_status; ?></td>
                                <td>
                                    <?php if ($student->clearance_status === 'cleared') : ?>
                                        <a href="set-status.php?regNo=<?php echo $student->reg_no . '&status=pending'; ?>" title="set as pending" class="btn-sm btn btn-danger" role="button">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    <?php else : ?>
                                        <a href="set-status.php?regNo=<?php echo $student->reg_no . '&status=cleared'; ?>" title="approve" class="btn btn-sm btn-success" role="button">
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
        <script defer src="https://unpkg.com/alpinejs@3.4.2/dist/cdn.min.js" defer></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js" defer></script>
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
