<?php $this->layout('_theme'); ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1><?= $roof->name; ?></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Contacts</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <div class="container">
        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="card card-solid">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <a href="<?= url("/especialidades/coberturas/{$roof->slug}/atos-medicos"); ?>"
                               class="btn btn-block btn-primary btn-lg" role="button">Ver Atos
                                Médicos</a>
                        </div>
                        <div class="col-3">
                            <a href="<?= url("/especialidades/coberturas/{$roof->slug}/atos-medicos/cadastrar"); ?>"
                               class="btn btn-block btn-primary btn-lg" role="button">Cadastrar
                                Atos Médicos</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>