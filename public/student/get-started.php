<?php

require_once "../../vendor/autoload.php";

use App\Actions\StudentActions;

if (!checkStudentLogin()) {
    $errors = [];
    $data = [
        'clearancePin' => '',
        'regNo' => '',
        'session' => '2018/2019',
        'password' => ''
    ];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = filter_input_array(INPUT_POST);
        $action = new StudentActions();
        $register = $action->register($data ?? ['regNo' => '', 'password' => '', 'clearancePin' => '', 'session' => '']);
        $errors = $action->getErrors();
        if ($register) {
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
        <title>AE-FUNAI Clearance Portal | Student Get Started</title>
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
                        <form action="" method="POST">
                            <div class="flex-row d-flex align-items-center justify-content-center justify-content-lg-start">
                                <h2 class="mb-4 me-3">Get Started</h2>
                            </div>

                            <?php foreach ($errors as $error) : ?>
                                <div class="mb-3 text-danger">
                                    <?php echo $error; ?>
                                </div>
                            <?php endforeach ?>

                            <!-- Clearance Pin -->
                            <div class="mb-4 form-outline">
                                <input value="<?php echo $data['clearancePin']; ?>" name="clearancePin" type="text" id="form3Example1" class="form-control form-control-lg" placeholder="Enter your clearance pin" />
                                <label class="form-label" for="form3Example1">Clearance Pin</label>
                            </div>

                            <!-- RegNo -->
                            <div class="mb-4 form-outline">
                                <input name="regNo" value="<?php echo $data['regNo']; ?>" type="text" id="form3Example2" class="form-control form-control-lg" placeholder="Enter your REG NO." />
                                <label class="form-label" for="form3Example2">REG NO.</label>
                            </div>

                            <!-- Academic Session -->
                            <div class="pb-2 mb-4">
                                <label class="form-label select-label" for="form3Example3">Academic Session</label>
                                <select required name="session" id="form3Example3" class="form-select">
                                    <option <?php if ($data['session'] === '2018/2019') echo 'selected'; ?> value="2018/2019">2018/2019</option>
                                    <option <?php if ($data['session'] === '2019/2020') echo 'selected'; ?> value="2019/2020">2019/2020</option>
                                    <option <?php if ($data['session'] === '2020/2021') echo 'selected'; ?> class="2020/2021">2020/2021</option>
                                </select>
                            </div>

                            <!-- Password input -->
                            <div class="mb-3 form-outline">
                                <input value="<?php echo $data['password']; ?>" name="password" type="password" id="form3Example4" class="form-control form-control-lg" placeholder="Enter password" />
                                <label class="form-label" for="form3Example4">Password</label>
                            </div>

                            <div class="pt-2 mt-4 text-center text-lg-start">
                                <button type="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Get Started</button>
                                <p class="pt-1 mt-2 mb-0 small fw-bold">
                                    Already have an account? <a href="login.php" class="link-danger">login</a>
                                </p>
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
