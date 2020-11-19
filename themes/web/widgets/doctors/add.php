<?php $this->layout('_theme'); ?>


<div class="container">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Novo Atos Médico</h3>
        </div>
        <!-- /.card-header -->
        <!-- form start -->
        <form action="<?= url("/speciality/{$speciality->slug}/doctors/create"); ?>" method="post" enctype="multipart/form-data">
            <?= csrf_input(); ?>
            <div class="card-body">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label for="code">Código</label>
                            <input type="text" class="form-control" name="code" id="code">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="name">Nome</label>
                            <input type="text" class="form-control" name="name" id="name">
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label for="value">Valor</label>
                            <input type="text" class="form-control" name="value" id="value">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="commentary">Comentários</label>
                    <textarea name="commentary" id="commentary" class="form-control"></textarea>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="group">Grupo</label>
                            <input type="text" class="form-control" name="group" id="group">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="subgroup">Sub-grupo</label>
                            <input type="text" class="form-control" name="subgroup" id="subgroup">
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card-body -->

            <div class="card-footer text-right">
                <button type="submit" class="btn btn-primary create">Cadastrar</button>
            </div>
        </form>
    </div>
</div>