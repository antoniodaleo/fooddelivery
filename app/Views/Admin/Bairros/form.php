<div class="form-row">

    <?php if(!$bairro ->id): ?>
        <div class="form-group col-md-3">
            <label for="cep">CEP</label>
            <input type="text" class="cep form-control"  name="cep" value="<?php echo old('cep', esc($bairro->cep)); ?>">
            <div id="cep"></div>
        </div>
    <?php endif; ?>
    
    <div class="form-group col-md-3">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo old('nome', esc($bairro->nome)); ?>" readonly="" >
    </div>
    <div class="form-group col-md-3">
        <label for="cidade">Cidade</label>
        <input type="text" class="form-control" id="cidade" name="cidade" value="<?php echo old('cidade', esc($bairro->cidade)); ?>" readonly="" >
    </div>

    <?php if(!$bairro ->id): ?>
        <div class="form-group col-md-3">
            <label for="estado">Estado</label>
            <input type="text" class="uf form-control" id="estado" name="estado"  readonly="" >
        </div>
    <?php endif; ?>

    <div class="form-group col-md-2"rf>
        <label for="valor_entrega">Valor de entrega</label>
        <input type="text" class="money form-control" id="valor_entrega" name="valor_entrega" value="<?php echo old('valor_entrega', esc(number_format($bairro->valor_entrega, 2))); ?>">
    </div>

 
   
</div>

<div class="form-check form-check-flat form-check-primary mb-4">
    <label for="is_admin" class="form-check-label">
        <input type="hidden" name="ativo" value="0" >

        <input type="checkbox" class="form-check-input" id="ativo" name="ativo" value="1" <?php if(old('ativo', $bairro->ativo)) : ?> checked="" <?php endif; ?> >
        Ativo
    </label>
</div>

<button id="btn-salvar" type="submit" class="btn btn-primary mr-2">
    <i class="mdi mdi-checkbox-marked-circle  btn-icon-prepend"></i>
    Salvar
</button>





