<?php $this->layout('_theme'); ?>


<div class="container">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Nova Cobertura</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="<?= url("/speciality/{$speciality->slug}/roofing/create"); ?>" method="post" enctype="multipart/form-data">
            <?= csrf_input(); ?>
            <div class="card-body">
                <div class="form-group">
                    <label for="number">Número</label>
                    <input type="text" class="form-control" name="number" id="number">
                </div>
                <div class="form-group">
                    <label for="name">Nome</label>
                    <input type="text" class="form-control" name="name" id="name">
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Cadastrar</button>
            </div>
        </form>
    </div>
</div>