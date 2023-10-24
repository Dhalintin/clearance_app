<?php

use App\Actions\ClearanceOfficerActions;

require_once "../../vendor/autoload.php";


if (checkAdminLogin()) {
    $errors = [];
    $validOffices = [
        'faculty',
        'department',
        'library'
    ];
    $data = [
        'office' => 'faculty',
        'username' => '',
        'password' => '',
        'fullname' => ''
    ];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = filter_input_array(INPUT_POST) ?? $data;
        $action = new ClearanceOfficerActions;
        $add = $action->createClearanceOfficer($data);
        $errors = $action->getErrors();

        if ($add) {
            $_SESSION['success'] = "Officer created successfully";
            header("Location: clearance-officers.php");
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

        <title>AE-FUNAI Clearance Portal | Admin</title>
    </head>

    <body>
        <?php include "navbar.php"; ?>
        <!-- Jumbotron -->
        <div class="p-5 text-center bg-light">
            <h3 class="my-4 text-primary">Admin | Add Clearance Officer</h3>
        </div>
        <!-- Jumbotron -->

        <div class="container py-5">
            <div class="p-4 mx-auto col-md-6 shadow-2">
                <form action="" method="POST">
                    <?php foreach ($errors as $key => $error) : ?>
                        <div class="mb-3 text-danger">
                            <?php echo $error; ?>
                        </div>
                    <?php endforeach ?>

                    <!-- office -->
                    <div class="mb-4">
                        <label class="form-label select-label" for="form3Example3">Office</label>
                        <select required name="office" id="form3Example3" class="form-select">
                            <?php foreach ($validOffices as $office) :  ?>
                                <option <?php if ($data['office'] === $office) echo 'selected'; ?> value="<?php echo $office ?>"><?php echo $office ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="mb-4 form-outline">
                        <input value="<?php echo $data['fullname']; ?>" name="fullname" type="text" id="form3Example0" class="form-control form-control-lg" placeholder="Enter Full Name" />
                        <label class="form-label" for="form3Example0">Full Name</label>
                    </div>

                    <div class="mb-4 form-outline">
                        <input value="<?php echo $data['username']; ?>" name="username" type="text" id="form3Example1" class="form-control form-control-lg" placeholder="Enter username" />
                        <label class="form-label" for="form3Example1">Username</label>
                    </div>

                    <div class="mb-4 form-outline">
                        <input name="password" value="<?php echo $data['password']; ?>" type="password" id="form3Example2" class="form-control form-control-lg" placeholder="Enter default password." />
                        <label class="form-label" for="form3Example2">Default password</label>
                    </div>

                    <div class="pt-2 mt-4 text-center text-lg-start">
                        <button type="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Add</button>
                    </div>
                </form>
            </div>
        </div>
        <script defer src="https://unpkg.com/alpinejs@3.4.2/dist/cdn.min.js" defer></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js" defer></script>
    </body>

    </html>
<?php
} else {
    header("Location: login.php");
    exit();
}
