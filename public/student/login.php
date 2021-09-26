<?php

if (!$_SESSION['student']) {
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Font Awesome -->
        <link
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
        rel="stylesheet"
        />
        <!-- Google Fonts -->
        <link
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"
        rel="stylesheet"
        />
        <!-- MDB -->
        <link
        href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.css"
        rel="stylesheet"
        />
        <link rel="stylesheet" href="/css/main.css" />
    </head>
    <body>
        <section class="vh-100">
            <div class="container-fluid h-custom">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-md-9 col-lg-6 col-xl-5">
                        <img src="https://mdbootstrap.com/img/Photos/new-templates/bootstrap-login-form/draw2.png" class="img-fluid"
                        alt="Sample image">
                        <div class="text-center mb-4">
                            Sign In
                        </div>
                    </div>
                    <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                        <form>
                            <!-- Clearance Pin -->
                            <div class="form-outline mb-4">
                                <input type="text" id="form3Example3" class="form-control form-control-lg"
                                placeholder="Enter your clearance pin" />
                                <label class="form-label" for="form3Example3">Clearance Pin</label>
                            </div>

                            <!-- RegNo -->
                            <div class="form-outline mb-4">
                                <input type="text" id="form3Example3" class="form-control form-control-lg"
                                placeholder="Enter your REG NO." />
                                <label class="form-label" for="form3Example3">REG NO.</label>
                            </div>

                            <!-- Password input -->
                            <div class="form-outline mb-3">
                                <input type="password" id="form3Example4" class="form-control form-control-lg"
                                placeholder="Enter password" />
                                <label class="form-label" for="form3Example4">Password</label>
                            </div>

                            <div class="text-center text-lg-start mt-4 pt-2">
                                <button type="button" class="btn btn-primary btn-lg"
                                    style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                                <p class="small fw-bold mt-2 pt-1 mb-0">
                                    Don't have an account? <a href="#!"
                                        class="link-danger">Register</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </section>
        <!-- MDB -->
        <script
            type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/3.6.0/mdb.min.js"
            ></script>
    </body>
</html>
<?php
} else {}