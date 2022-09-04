<div class="form-row">

    <div class="form-group col-md-6">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo old('nome', esc($medida->nome)); ?>">
    </div>

   
    <div class="form-group col-md-12">
        <label for="descricao">Descricao</label>
        <textarea class="form-control" name="descricao" rows="3" id="descricao"><?php echo old('descricao', esc($medida->descricao)); ?></textarea>
    </div>
   
</div>

<div class="form-check form-check-flat form-check-primary mb-4">
    <label for="is_admin" class="form-check-label">
        <input type="hidden" name="ativo" value="0" >

        <input type="checkbox" class="form-check-input" id="ativo" name="ativo" value="1" <?php if(old('ativo', $medida->ativo)) : ?> checked="" <?php endif; ?> >
        Ativo
    </label>
</div>

<button type="submit" class="btn btn-primary mr-2">
    <i class="mdi mdi-checkbox-marked-circle  btn-icon-prepend"></i>
    Salvar
</button>





