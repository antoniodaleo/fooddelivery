<div class="form-row">
    <div class="form-group col-md-3">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome" value="<?php echo old('nome', esc($entregador->nome)); ?>">
    </div>

    <div class="form-group col-md-3">
        <label for="cpf">CPF</label>
        <input type="text" class="form-control cpf" id="cpf" name="cpf" value="<?php echo old('cpf', esc($entregador->cpf)); ?>">
    </div>
    <div class="form-group col-md-3">
        <label for="cpf">CNH</label>
        <input type="text" class="form-control cnh" id="cpf" name="cnh" value="<?php echo old('cnh', esc($entregador->cnh)); ?>">
    </div>

    <div class="form-group col-md-3">
        <label for="telefone">Telefone</label>
        <input type="text" class="form-control phone_with_ddd" id="telefone" name="telefone" value="<?php echo old('telefone', esc($entregador->telefone)); ?>">
    </div>
    <div class="form-group col-md-4">
        <label for="email">Email address</label>
        <input type="email" class="form-control" id="email" name="email" value="<?php echo old('email', esc($entregador->email)); ?>" >
    </div>

    <div class="form-group col-md-3">
        <label for="veiculo">Veiculo</label>
        <input type="text" class="form-control" id="veiculo" name="veiculo" value="<?php echo old('veiculo', esc($entregador->veiculo)); ?>" >
    </div>
    <div class="form-group col-md-3">
        <label for="placa">Placa</label>
        <input type="text" class="form-control placa" id="placa" name="placa" value="<?php echo old('placa', esc($entregador->placa)); ?>" >
    </div>
    <div class="form-group col-md-12">
        <label for="endereco">Endereço</label>
        <input type="text" class="form-control " id="endereco" name="endereco" value="<?php echo old('endereco', esc($entregador->endereco)); ?>" >
    </div>
</div>


<div class="form-check form-check-flat form-check-primary mb-4">
    <label for="is_admin" class="form-check-label">
        <input type="hidden" name="ativo" value="0" >
        <input type="checkbox" class="form-check-input" id="ativo" name="ativo" value="1" <?php if(old('ativo', $entregador->ativo)) : ?> checked="" <?php endif; ?> >
        Ativo
    </label>
</div>

<button type="submit" class="btn btn-primary mr-2">
    <i class="mdi mdi-checkbox-marked-circle  btn-icon-prepend"></i>
    Salvar
</button>
