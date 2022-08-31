<?php  echo $this->extend('Admin/layout/principal_autenticacao'); ?>




<?php echo  $this->section('estilos'); ?> 
  <!-- Aqui enviamos os estilos do template principal -->



<?php echo  $this->endSection(); ?>




<?php echo  $this->section('conteudo'); ?>
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">

              <?php if(session()->has('sucesso')): ?>
                
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                  <strong>Informação!</strong> <?php echo session('sucesso');  ?>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

              <?php endif; ?>

              <?php if(session()->has('info')): ?>

                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>Informação!</strong> <?php echo session('info');  ?>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

              <?php endif; ?>

              <?php if(session()->has('atencao')): ?>

                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>Informação!</strong> <?php echo session('atencao');  ?>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

              <?php endif; ?>

              <?php if(session()->has('error')): ?>

                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>Erro!</strong> <?php echo session('error');  ?>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>

              <?php endif; ?>




              <div class="brand-logo">
                <img src="<?php echo site_url('admin/images/logo.svg')?>" alt="logo">
              </div>
              <h4>Esqueci a minha senha</h4>
              <h6 class="font-weight-light mb-3"></h6>


              <?php echo form_open('password/processaEsqueci'); ?>


                <div class="form-group">
                  <input type="email" name="email" value="<?php echo old('email'); ?>" class="form-control form-control-lg" id="exampleInputEmail1" placeholder="Digite o seu e-mail">
                </div>
              
                <div class="mt-3">
                  <input id="btn-reset-senha" type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn" value="Recuperar senha" >Recuperar senha</button>
                </div>

                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
          
                  </div>
                  <a  href="<?php echo site_url('login') ?>" class="auth-link text-black">Lembrei a minha senha</a>
                </div>

              
              <?php echo form_close(); ?>

            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>


<?php echo  $this->endSection(); ?>



<?php echo  $this->section('scripts'); ?> 
  <!-- Aqui enviamos os scripts do template principal -->


<script>

  $("form").submit(function(){

    $(this).find(":submit").attr('disabled' ,'disabled'); 
    $("#btn-reset-senha").val("Enviando e-mail de recuperação..");

  });

</script>


<?php echo  $this->endSection(); ?>