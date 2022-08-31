<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Food Delivery | <?= $this->renderSection('titulo') ?></title>
  <!-- plugins:css -->
  <link rel="stylesheet" href=" <?php echo site_url('admin/vendors/mdi/css/materialdesignicons.min.css') ?> ">
  <link rel="stylesheet" href="<?php echo site_url('admin/vendors/base/vendor.bundle.base.css') ?> ">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <link rel="stylesheet" href="<?php echo site_url('admin/vendors/datatables.net-bs4/dataTables.bootstrap4.css') ?> ">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="<?php echo site_url('admin/css/style.css') ?> ">
  <!-- endinject -->
  <link rel="shortcut icon" href="<?php echo site_url('admin/images/favicon.png') ?> " />

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
 
 
  <!-- Renderiza estilos especificos -->
  <?= $this->renderSection('estilos') ?>
</head>

<body>



  
  <div class="container-scroller">

    <!-- Essa section renderiza o conteudo especifico da view que estende esse Layout -->
    <?= $this->renderSection('conteudo') ?>




    
    <
  </div>




  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="<?php echo site_url('admin/') ?>vendors/base/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- inject:js -->
  <script src="<?php echo site_url('admin/') ?>js/off-canvas.js"></script>
  <script src="<?php echo site_url('admin/') ?>js/hoverable-collapse.js"></script>
  <script src="<?php echo site_url('admin/') ?>js/template.js"></script>
  <!-- endinject -->

    <!-- Renderiza scripts especificos -->
    <?= $this->renderSection('scripts') ?>

    
</body>

</html>
