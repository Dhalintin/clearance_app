<?php

use App\Actions\HostelClearanceActions;

require_once "../../vendor/autoload.php";

if (checkStudentLogin()) {
    $action = new HostelClearanceActions;
    $studentRecords = $action->findStudentRecords($_SESSION['student']);

    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $_POST = filter_input_array(INPUT_POST);
        $store = $action->storeReceipt($_FILES["receiptImage"], $_POST['session']);
        $errors = $action->getErrors();
        if ($store) {
            header("Location: hostel-clearance.php");
            exit();
        }
    }
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

        <title>AE-FUNAI Clearance Portal | Student Dashboard</title>
    </head>

    <body>
        <?php include "navbar.php"; ?>
        <!-- Jumbotron -->
        <div class="p-5 text-center bg-light">
            <h3 class="my-3 text-primary">Department Clearance</h3>
        </div>

        <div class="container py-5">
            <?php if (isset($_SESSION['clearanceRequestCreated'])) : ?>
                <div id="alert" class="px-2 mx-auto col-md-10">
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
            <?php if (isset($errors)) : ?>
                <?php foreach ($errors as $error) : ?>
                    <div class="mb-3 text-danger">
                        <?php echo $error; ?>
                    </div>
                <?php endforeach ?>
            <?php endif ?>
            <div class="row">
                <!-- <?php foreach ($studentRecords as $key => $record) : ?> -->
                <div class="col-md-4">
                    <div class="card">
                        <?php if ($record->receipt_image) : ?>
                            <img style="object-fit: scale-down; height: 300px;" class="w-100 card-img-top" src=".././uploads/hostel-receipts/<?php echo $record->receipt_image; ?>" alt="receipt" />
                        <?php else : ?>
                            <div class="p-4 text-center">
                                <i style="font-size: 120px;" class="fas fa-image"></i>
                            </div>
                            <div class="text-center">
                                no receipt
                            </div>
                        <?php endif ?>
                        <div class="px-4 py-4 card-body">
                            <h6 class="mb-2 card-title"><?php echo $record->accomodation_session; ?> session</h6>
                            <?php if (!$record->receipt_image) : ?>
                                <button class="btn btn-sm btn-primary" data-mdb-toggle="modal" data-mdb-target="#exampleModal<?php echo $key; ?>">Upload Receipt</button>

                                <div class="modal fade" id="exampleModal<?php echo $key; ?>" tabindex="-1" aria-labelledby="exampleModalLabel<?php echo $key; ?>" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel<?php echo $key; ?>">Upload Receipt: <?php echo $record->accomodation_session; ?> session</h5>
                                                <button type="button" class="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="" method="POST" enctype="multipart/form-data">
                                                    <input type="hidden" name="session" value="<?php echo $record->accomodation_session; ?>" />
                                                    <div class="mb-4">
                                                        <label class="form-label" for="customFile">Receipt Picture</label>
                                                        <input name="receiptImage" onchange="previewImage(event.target.files[0])" type="file" accept="image/*" class="form-control" id="customFile" />
                                                        <!-- <div class="mt-2">
                                                                Max. 100KB
                                                            </div> -->
                                                    </div>
                                                    <img style="object-fit: scale-down; height: 320px;" id="preview" class="mb-4 w-100 d-none">
                                                    <div class="pt-2 mt-4 text-center text-lg-start">
                                                        <button type="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Upload</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary" data-mdb-dismiss="modal">
                                                    Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
            </div>
        </div>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js" defer></script>
        <script>
            function previewImage(file) {
                let image = document.getElementById('preview');
                if (file) {
                    var reader = new FileReader();
                    reader.onload = function() {
                        image.src = reader.result;
                        image.classList.remove('d-none');
                    }
                    reader.readAsDataURL(file);
                }
            }
        </script>
    </body>

    </html>
<?php
} else {
    header("Location: login.php");
    exit();
}
