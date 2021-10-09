<?php

require_once "../../vendor/autoload.php";

use App\Actions\ClearanceOfficerActions;

if (!checkBursaryLogin()) {
    /* if (checkStudentLogin()) {
        header("Location: ../student/dashboard.php");
        exit();
    } */
    $data = [
        'username' => '',
        'password' => ''
    ];
    $errors = [];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = filter_input_array(INPUT_POST);
        $action = new ClearanceOfficerActions();
        $clearanceOfficer = $action->login($data ?? ['username' => '', 'password' => '']);
        $errors = $action->getErrors();
        if ($clearanceOfficer) {
            header("Location: dashboard.php");
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
        <link rel="stylesheet" href="../css/main.css" />
        <title>AE-FUNAI Clearance Portal | Bursary Office Login</title>
    </head>

    <body>
        <?php include "navbar.php"; ?>
        <section class="vh-100">
            <div class="container-fluid h-custom">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-md-9 col-lg-6 col-xl-5">
                        <img src="../images/auth.png" class="img-fluid" alt="Sample image">
                    </div>
                    <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                        <form method="POST" action="login.php">
                            <div class="flex-row d-flex align-items-center justify-content-center justify-content-lg-start">
                                <h2 class="mb-4 me-3">Login | Bursary Office</h2>
                            </div>

                            <?php foreach ($errors as $error) : ?>
                                <div class="mb-3 text-danger">
                                    <?php echo $error; ?>
                                </div>
                            <?php endforeach ?>
                            <!-- username -->
                            <div class="mb-4 form-outline">
                                <input value="<?php echo $data['username']; ?>" type="text" name="username" id="form3Example3" class="form-control form-control-lg" placeholder="Enter your Username" />
                                <label class="form-label" for="form3Example3">Username</label>
                            </div>

                            <!-- Password input -->
                            <div class="mb-3 form-outline">
                                <input value="<?php echo $data['password']; ?>" type="password" name="password" id="form3Example4" class="form-control form-control-lg" placeholder="Enter password" />
                                <label class="form-label" for="form3Example4">Password</label>
                            </div>

                            <div class="pt-2 mt-4 text-center text-lg-start">
                                <button type="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- MDB -->
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js"></script>
    </body>

    </html>
<?php
} else {
    header("Location: dashboard.php");
    exit();
}
