<?php

require_once "../../vendor/autoload.php";

if (checkStudentLogin()) {

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
        <title>AE-FUNAI Clearance Portal | Student Dashboard</title>
    </head>

    <body>
        <?php include "navbar.php"; ?>
        <!-- Jumbotron -->
        <div class="p-5 text-center bg-light">
            <h3 class="my-3 text-primary">Library Clearance</h3>
        </div>

        <div class="container py-5">
            <div class="p-4 mx-auto border border-light rounded-5 col-md-7 shadow-2">
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
                    <div class="mb-4">
                        <label class="form-label" for="customFile">Library Card Picture</label>
                        <input name="libraryCard" onchange="previewImage(event.target.files[0])" type="file" accept="image/*" class="form-control" id="customFile" />
                    </div>
                    <img id="preview" class="mb-4 w-100 d-none">
                    <div class="pt-2 mt-4 text-center text-lg-start">
                        <button type="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Upload</button>
                    </div>
                </form>
            </div>
        </div>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js"></script>
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
