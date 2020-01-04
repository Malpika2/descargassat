<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Title -->
  <title>RECADOS DIGITALES OFISA</title>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <!-- Favicon -->
  <link rel="shortcut icon" href="../../favicon.ico">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <!-- CSS Global Compulsory -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/icon-awesome/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/icon-line-pro/style.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/animate.css">

  <!-- CSS Unify -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/unify-core.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/unify-components.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/unify-globals.css">

  <!-- CSS Customization -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css">
</head>

<body>
  <main>
    <!-- Login -->
    <section class="g-min-height-100vh g-flex-centered g-bg-lightblue-radialgradient-circle">
      <div class="container g-py-100">
        <div class="row justify-content-center">
          <div class="col-sm-8 col-lg-5">
            <div class="u-shadow-v24 g-bg-white rounded g-py-40 g-px-30">
              <header class="text-center mb-4">
                <h2 class="h2 g-color-black g-font-weight-600">OFISA DIGITAL  </h2>
              </header>
              <?php if(isset($_SESSION['error_login'])) {
                  echo $_SESSION['error_login'];
              }  ?>
              <!-- Form -->
              <form class="g-py-15" action="<?php echo base_url('digital');?>" method="POST">
                <div class="mb-4">
                  <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Usuario:</label>
                  <input autocomplete="new-text" class="form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15" name="username" type="text" placeholder="Nombre usuario">
                </div>

                <div class="g-mb-35">
                  <div class="row justify-content-between">
                    <div class="col align-self-center">
                      <label class="g-color-gray-dark-v2 g-font-weight-600 g-font-size-13">Contraseña:</label>
                    </div>
                    <div class="col align-self-center text-right">
                      <!-- <a class="d-inline-block g-font-size-12 mb-2" href="#!">Forgot password?</a> -->
                    </div>
                  </div>
                  <input autocomplete="new-password" name="password" class="form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15 mb-3" type="password" placeholder="Contraseña">
                  <div class="row justify-content-between">
                    <!-- <div class="col-8 align-self-center"> -->
                      <!-- <label class="form-check-inline u-check g-color-gray-dark-v5 g-font-size-12 g-pl-25 mb-0">
                        <input class="g-hidden-xs-up g-pos-abs g-top-0 g-left-0" type="checkbox">
                        <div class="u-check-icon-checkbox-v6 g-absolute-centered--y g-left-0">
                          <i class="fa" data-check-icon="&#xf00c"></i>
                        </div>
                         Keep signed in 
                      </label> -->
                    <!-- </div> -->
                    <div class="col-12 align-self-center text-center">
                      <button class="btn btn-md u-btn-primary rounded g-py-13 g-px-25" type="submit">INICIAR SESIÓN</button>
                    </div>
                  </div>
                </div>
              </form>
              <!-- End Form -->

              <footer class="text-center">
              <!--   <p class="g-color-gray-dark-v5 g-font-size-13 mb-0">Don't have an account? <a class="g-font-weight-600" href="page-signup-6.html">signup</a>
                </p> -->
              </footer>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Login -->
  </main>

  <div class="u-outer-spaces-helper"></div>


  <!-- JS Global Compulsory -->
  <script src="<?php echo base_url(); ?>assets/vendor/jquery/jquery.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/jquery-migrate/jquery-migrate.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/popper.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/bootstrap/bootstrap.min.js"></script>


  <!-- JS Unify -->
  <script src="<?php echo base_url(); ?>assets/js/hs.core.js"></script>

  <!-- JS Customization -->
  <script src="<?php echo base_url(); ?>assets/js/custom.js"></script>







</body>

</html>
