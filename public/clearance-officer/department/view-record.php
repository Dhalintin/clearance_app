<?php

require_once "../../../vendor/autoload.php";

use App\Actions\HostelClearanceActions;

if (checkClearanceOfficerLogin('department')) {
    $office = 'department';
    $session = $_GET['session'];
    if (!$session) {
        header("Location: dashboard.php");
        exit();
    }
    $students = (new HostelClearanceActions)->getStudentsBySession($session);
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
        <title>AE-FUNAI Clearance Portal | Department Office</title>
    </head>

    <body>
        <?php include "../navbar.php"; ?>
        <!-- Jumbotron -->
        <div class="p-5 text-center bg-light">
            <h3 class="my-4 text-primary">Department office | Student records</h3>
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
                <h3 class="mb-5 text-center">Accomodation Session: <?php echo $session; ?></h3>
                <div class="mb-5 d-flex justify-content-end">
                    <a class="btn btn-primary" href="add-record.php?session=<?php echo $session; ?>" role="button">add students</a>
                </div>
                <table id="students" class="table table-bordered table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>REG NO.</th>
                            <th>Department Receipts</th>
                            <th>Clearance Status</th>
                            <th>Approve/Set as pending</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($students as $studentKey => $student) : $receipts = array_filter(array_column($student, 'receipt_image'));
                            $emptyReceipts = empty($receipts); ?>
                            <tr>
                                <td><?php echo $student[0]['reg_no']; ?></td>
                                <td>
                                    <?php if ($emptyReceipts) : ?>
                                        <div class="text-info">no receipts uploaded!</div>
                                    <?php else : ?>
                                        <button data-mdb-toggle="modal" data-mdb-target="#exampleModal<?php echo $studentKey; ?>" class="btn btn-primary btn-sm">view receipts</button>
                                        <div class="modal fade" id="exampleModal<?php echo $studentKey; ?>" tabindex="-1" aria-labelledby="exampleModalLabel<?php echo $studentKey; ?>" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="flex modal-title align-items-center" id="exampleModalLabel<?php echo $studentKey; ?>">
                                                            <?php echo $student[0]['reg_no']; ?>
                                                            <?php if (count($student) > count($receipts)) : ?>
                                                                <span style="font-size: 10px;" class="px-2 py-1 ml-5 text-center text-white bg-danger rounded-8">incomplete receipts!</span>
                                                            <?php endif ?>
                                                        </h5>
                                                        <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <!-- Carousel wrapper -->
                                                        <div id="carouselBasicExample<?php echo $studentKey; ?>" class="text-center carousel slide carousel-dark" data-mdb-ride="carousel">
                                                            <?php if (count($student) > 1) : ?>
                                                                <!-- Controls -->
                                                                <div class="mb-4 d-flex justify-content-center">
                                                                    <button class="carousel-control-prev position-relative" type="button" data-mdb-target="#carouselBasicExample<?php echo $studentKey; ?>" data-mdb-slide="prev">
                                                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                                        <span class="visually-hidden">Previous</span>
                                                                    </button>
                                                                    <button class="carousel-control-next position-relative" type="button" data-mdb-target="#carouselBasicExample<?php echo $studentKey; ?>" data-mdb-slide="next">
                                                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                                        <span class="visually-hidden">Next</span>
                                                                    </button>
                                                                </div>
                                                            <?php endif ?>

                                                            <!-- Inner -->
                                                            <div class="py-4 carousel-inner">
                                                                <!-- Single item -->
                                                                <?php foreach ($student as $key => $receipt) : ?>
                                                                    <!-- slide-->
                                                                    <div class="carousel-item <?php if ($key === 0) echo 'active'; ?>">
                                                                        <div class="card">
                                                                            <?php if ($receipt['receipt_image']) : ?>
                                                                                <img style="object-fit: scale-down; height: 360px;" class="w-100 card-img-top" src="../../uploads/hostel-receipts/<?php echo $receipt['receipt_image']; ?>" alt="receipt" />
                                                                            <?php else : ?>
                                                                                <div class="flex justify-content-center">
                                                                                    <i style="font-size: 120px;" class="fas fa-image"></i>
                                                                                </div>
                                                                                <div class="text-center">
                                                                                    no receipt
                                                                                </div>
                                                                            <?php endif ?>
                                                                            <div class="pb-0 card-body">
                                                                                <h6 class="card-title"><?php echo $receipt['accomodation_session']; ?> session</h6>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <!--/. slide-->
                                                                <?php endforeach ?>
                                                            </div>
                                                            <!-- Inner -->
                                                        </div>
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
                                    <?php endif ?>
                                </td>
                                <td><?php echo $student[0]['clearance_status']; ?></td>
                                <td>
                                    <?php if ($student[0]['clearance_status'] === 'cleared') : ?>
                                        <a href="set-status.php?regNo=<?php echo $student[0]['reg_no'] . '&status=pending'; ?>" title="set as pending" class="btn-sm btn btn-danger" role="button">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    <?php else : ?>
                                        <?php if ($emptyReceipts) : ?>
                                            <div class="text-info">no receipts uploaded!</div>
                                        <?php elseif (count($student) > count($receipts)) : ?>
                                            <div class="text-danger">incomplete receipts!</div>
                                        <?php else : ?>
                                            <a href="set-status.php?regNo=<?php echo $student[0]['reg_no'] . '&status=cleared'; ?>" title="approve" class="btn btn-sm btn-success" role="button">
                                                <i class="fas fa-check"></i>
                                            </a>
                                        <?php endif ?>
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
