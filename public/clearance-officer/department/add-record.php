<?php

require_once "../../../vendor/autoload.php";

use App\Actions\HostelClearanceActions;

if (checkClearanceOfficerLogin('department')) {
    $office = 'department';
    $errors = [];
    $validSessions = [
        '2022/2023',
        '2023/2024',
        '2024/2025'
    ];
    $data = [
        'session' => (in_array($_GET['session'], $validSessions)) ? $_GET['session'] : '2022/2023',
        'regNos' => []
    ];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = filter_input_array(INPUT_POST);
        $data['regNos'] = (array_key_exists('regNos', $data) && is_array($data['regNos'])) ? array_values(array_filter($data['regNos'])) : [];
        $action = new HostelClearanceActions();
        $add = $action->addBatchRecord($data);
        $errors = $action->getErrors();

        if ($add) {
            $_SESSION['success'] = 'Students record uploaded successfully.';
            header("Location: view-record.php?session=" . $data['session']);
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

        <title>AE-FUNAI Clearance Portal | Department Office</title>
    </head>

    <body>
        <?php include "../navbar.php"; ?>
        <!-- Jumbotron -->
        <div class="p-5 text-center bg-light">
            <h3 class="my-4 text-primary">Department office | Add record</h3>
        </div>
        <!-- Jumbotron -->

        <div class="container py-5" x-data='{ numberOfStudents: <?php echo (count($data['regNos']) > 0) ? count($data['regNos']) : 12; ?>, regNos: <?php echo json_encode($data["regNos"]); ?> }'>
            <div class="p-4 mx-auto col-md-12 shadow-2">
                <form action="" method="POST">
                    <?php foreach ($errors as $key => $error) : ?>
                        <?php if ($key === 'duplicates') : ?>
                            <div class="mb-3 text-danger">
                                Some records already exist:
                                <?php foreach ($errors['duplicates'] as $duplicate) : ?>
                                    <div class="mb-2 text-dark">
                                        <?php echo $duplicate->reg_no; ?> in <?php echo $data['session']; ?> session.
                                    </div>
                                <?php endforeach ?>
                            </div>
                        <?php continue;
                        endif ?>
                        <div class="mb-3 text-danger">
                            <?php echo $error; ?>
                        </div>
                    <?php endforeach ?>

                    <!-- Academic Session -->
                    <div class="pb-2 mb-4 col-sm-6">
                        <label class="form-label select-label" for="form3Example3">Academic Session</label>
                        <select required name="session" id="form3Example3" class="form-select">
                            <?php foreach ($validSessions as $session) :  ?>
                                <option <?php if ($data['session'] === $session) echo 'selected'; ?> value="<?php echo $session ?>"><?php echo $session ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="mt-3 mb-4 form-outline col-sm-6">
                        <input x-model="numberOfStudents" max="200" type="number" id="number" class="form-control form-control-lg" placeholder="Number Of Students" />
                        <label class="form-label" for="number">How Many Students?</label>
                    </div>

                    <div x-show="numberOfStudents >= 1">
                        <div class="flex-wrap col-12 d-flex">
                            <template x-for="i in 200">
                                <div x-show="numberOfStudents >= i" class="mb-4 col-6 col-lg-4">
                                    <h6 class="mb-3" x-text="'Student ' + i"></h6>
                                    <div class="form-outline">
                                        <input x-bind:disabled="(i > numberOfStudents) ? true : false" name="regNos[]" x-bind:value="(regNos[i - 1] != undefined) ? regNos[i - 1] : ''" type="text" :id="'regNo' + i" class="border-collapse form-control form-control-lg" placeholder="Enter Student's REG NO." />
                                        <label class="form-label" :for="'regNo' + i">REG NO.</label>
                                    </div>
                                </div>
                            </template>
                        </div>
                    </div>

                    <div class="pt-2 mt-4 text-center text-lg-start">
                        <button type="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Add Record</button>
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
    header("Location: ../login.php");
    exit();
}
