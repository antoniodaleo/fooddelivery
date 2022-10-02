<?php echo $this->extend('layout/principal_web');  ?>

<?php echo $this->section('titulo');  ?><?php echo $titulo; ?><?php echo $this->endSection();  ?>

<?php echo $this->section('estilos');  ?>

    <link rel="stylesheet" href="<?php echo site_url("web/src/assets/css/produto.css"); ?>">

<?php echo $this->endSection();  ?>




<?php echo $this->section('conteudo');  ?>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />
<div class="container">
    <!-- product -->
    <div class="product-content product-wrap clearfix product-deatil">
        <div class="row">

             <h2 class="name">
                <?php echo esc($titulo); ?>
            </h2>

            <?php echo form_open("carrinho/especial"); ?>

            <div class="row" style="min-height: 300px">

                <div class="col-md-12" style="margin-bottom:2em ;">
                    <?php if(session()->has('errors_model')):  ?>
                        
                        <ul style="margin-left: -1.6em !important; list-style: decimal">

                            <?php foreach(session('errors_model') as $error):  ?>

                                <li class="text-danger"><?php echo $error; ?></li>

                            <?php endforeach;  ?>

                        </ul>

                    <?php endif;   ?>
                </div>

                <div class="col-md-6">
                    <label for="">Primeira metade</label>
                    <select id="primeira_metade"  class="form-control"  name="primeira_metade">
                        <option value="">Escolha seu produto...</option>
                        <?php foreach($opcoes as $opcao):  ?>
                            <option value="<?php echo $opcao->id; ?>"> <?php echo esc($opcao->nome); ?> </option>
                        <?php endforeach;  ?>

                    </select>
                </div>
                <div class="col-md-6">
                    <label >Segunda metade</label>
                    <select id="segunda_metade" class="form-control" name="segunda_metade" >
                        <!-- Aqui serão renderizadas as opcoes para compor a segunda metade, via js -->
                        


                    </select>
                </div>

                
            </div>
            <div class="row">
                <div class="col-sm-2 ">
                    <input id="btn-adiciona" type="submit" class="btn btn-success" value="Adicionar">
                </div>

                

                <div class="col-sm-2 ">
                    <a href="<?php echo site_url("produto/detalhes/$produto->slug") ?>" class="btn btn-info ">Voltar</a>
                </div>
            </div>
            <?php echo form_close(); ?>

        </div>


    </div>
    <!-- end product -->
</div>




       

      
<?php echo $this->endSection();  ?>





<?php echo $this->section('scripts');  ?>

<script>

    $(document).ready(function(){

        $("#btn-adiciona").prop("disabled",true); 
        $("#btn-adiciona").prop("value","Selecione um tamanho"); 


        $("#primeira_metade").on('change', function(){
            
            var primeira_metade = $(this).val(); 

            var categoria_id = '<?php echo $produto->categoria_id ?>'; 

            if(primeira_metade){
                
                $.ajax({
                    
                    type: 'get', 
                    url: '<?php echo site_url('produto/procurar'); ?>', 
                    dataType: 'json', 
                    data: {

                        primeira_metade: primeira_metade, 
                        categoria_id : categoria_id, 

                    },  
                    beforeSend: function(data){
                       
                        $("#segunda_metade").html('');

                    }, 

                    success: function(data){
                       
                        if(data.produtos){

                            $("#segunda_metade").html('<option>Escolha a segunda metade</option>');

                            $(data.produtos).each(function()  {

                                var option = $('<option />'); 

                                option.attr('value', $this.id).text(this.nome); 

                                $("#segunda_metade").append(option); 

                            });


                        }else{

                            $("#segunda_metade").html('<option>Não encontramos opções de customização</option>');

                        }

                    }, 

                });


            }else{
                /*Cliente não escolheu */


            }


            //alert('catego'+ categoria_id); 
        });

       
    })

</script>                 


<?php echo $this->endSection();  ?>


