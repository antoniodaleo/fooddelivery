<?php  echo $this->extend('admin/layout/principal'); ?>

<?php echo  $this->section('titulo'); ?> <?php echo  $titulo; ?><?php echo  $this->endSection(); ?>



<?php echo  $this->section('estilos'); ?> 

<link rel="stylesheet" href="<?php echo  site_url('admin/vendors/select2/select2.min.css');  ?>">

<?php echo  $this->endSection(); ?>




<?php echo  $this->section('conteudo'); ?>
  <div class="row">         
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card">

          

        <div class="card-header bg-primary pb-0 pt-4 ">

          <!-- Escape -> todos elementos string -->
          <h4 class="card-title text-white"><?php echo esc($titulo); ?></h4>
        </div>

        <div class="card-body">

          <?php if(session()->has('errors_model')):  ?>
            
              <ul>

                <?php foreach(session('errors_model') as $error):  ?>

                  <li class="text-danger"><?php echo $error; ?></li>

                <?php endforeach;  ?>

              </ul>

          <?php endif;   ?>


          <?php echo form_open("admin/produtos/cadastrarespecificacoes/$produto->id"); ?>

            <div class="form-row">


              <div class="form-group col-md-4">
                <label>Escolha a medida do produto (opcional)</label>
                <select class="form-control js-example-basic-single" name="extra_id">
                  <option value="">Escolha...</option>
                  <?php foreach($medidas as $medida):  ?>
                    <option value="<?php echo $medida->id ?>"> <?php echo esc($medida->nome) ; ?> </option>
                  <?php endforeach;  ?>
                </select>
              
              </div>

              <div class="form-group col-md-4">
                  <label for="preco">Preço</label>
                  <input type="text" class="money form-control" id="preco" name="preco" value="<?php echo old('preco'); ?>">
              </div>

              <div class="form-group col-md-4">
                <label>Produto customizavel <a href="javascript:void" class="" data-toggle="popover" title="Medida do produto" data-content="Exemplo de uso para pizza: Pizza grande, pizza media, pizza familia">Enteda</a></label> 
                <select class="form-control " name="customizavel">
                  <option value="">Escolha...</option>
                  <option value="1">Sim</option>
                  <option value="0">Não</option>

                </select>
              
              </div>

            </div>


 
 
            
            <button type="submit" class="btn btn-primary mr-2">
                <i class="mdi mdi-checkbox-marked-circle  btn-icon-prepend"></i>
                Inserir medida
            </button>
            

            <a href="<?php echo site_url("admin/produtos/show/$produto->id"); ?>" class="btn btn-info btn-sm " title="Voltar"> 
                <i class="mdi mdi-arrow-left btn-icon-prepend"></i>    
            </a>

           

          <?php echo form_close();  ?>
          <hr class="mt-5 mb-3">

          
          <div class="form-row ">
            
            <div class="col-md-8">
              <?php if(empty($produtoEspecificacoes)):  ?>     
                <div class="alert alert-warning" role="alert">
                  <h4 class="alert-heading">Atenção!</h4>
                  <p>Esse produto não possui especificacoes até o momento. Portanto ele <strong>não será exibido</strong> como 
                    opção de compra na area publica
                  </p>
                  <hr>
                  <p class="mb-0">Aproveite para cadastrar pelo menos uma especificação para o produto. <strong><?php echo esc($produto->nome); ?></strong></p>
                </div>
                
                  
              <?php else:  ?>

                <h4 class="card-title">Especificações do produto</h4>
                  <p class="card-description">
                    <code>Aproveite para gerenciar as Especificações</code>
                  </p>
                  <div class="table-responsive">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Medida</th>
                          <th>Preço</th>
                          <th>Customizavel</th>
                          <th class="text-center">Remover</th>
                          
                        </tr>
                      </thead>

                      <tbody>
                        <?php foreach($produtoEspecificacoes as $especificacao): ?>
                        <tr>
                          <td><?php echo esc($especificacao->medida); ?></td>
                          <td>R$&nbsp;<?php echo esc(number_format($especificacao->preco, 2)); ?></td>
                          
                          <td><?php echo ($especificacao->customizavel? '<label class="badge badge-primary">Sim</label>': '<label class="badge badge-warning">Não</label>') ?>  </td>


                          <td class="text-center">
                            <button type="submit" class="btn badge badge-danger" >&nbsp;X&nbsp;</button>
                
                          </td>

                        </tr>
                        <?php endforeach; ?>
                        


                      </tbody>
                    </table>

                    <div class="mt-3">
                      <?php echo $pager->links(); ?> 
                    </div>
                  </div>

              <?php endif;   ?>

            </div>
          </div>

        </div>
      </div>
    </div> 
  </div>


<?php echo  $this->endSection(); ?>



<?php echo  $this->section('scripts'); ?> 

  <script src="<?php echo site_url('admin/vendors/select2/select2.min.js') ?>">  </script>
  <script src="<?php echo site_url('admin/vendors/mask/jquery.mask.min.js') ?>">  </script>
  <script src="<?php echo site_url('admin/vendors/mask/app.min.js') ?>">  </script>

  <script>
    // In your Javascript (external .js resource or <script> tag)
    $(document).ready(function() {

        $(function () {
          $('[data-toggle="popover"]').popover()
        })


        $('.js-example-basic-single').select2({

          placeholder: 'Digite o nome da medida...',
          allowClear: false, 
          
          "language": {
            "noResults": function(){
                return "Medida não encontrada &nbsp;&nbsp;<a class='btn btn-primary btn-sm' href='<?php echo site_url('admin/medidas/criar'); ?>'>Cadastrar</a>";
            }
          }, 

          escapeMarkup: function(markup){
            return markup; 
          }

        });
    });
  </script>

<?php echo  $this->endSection(); ?>