<?php $this->layout('_theme'); ?>

<div class="container">
    <div class="row py-5">
        <div class="col-4">
            <a href="<?= url('/especialidades/cadastrar'); ?>" class="btn btn-block btn-primary btn-lg" role="button">Cadastrar
                Especialidade</a>
        </div>
        <div class="col-4">
            <a href="<?= url('/especialidades'); ?>" class="btn btn-block btn-primary btn-lg" role="button">Ver
                Especialidades</a>
        </div>
        <div class="col-4">
            <a href="<?= url('/especialidades'); ?>" class="btn btn-block btn-primary btn-lg" role="button">Importar
                JSON</a>
        </div>
    </div>
</div>