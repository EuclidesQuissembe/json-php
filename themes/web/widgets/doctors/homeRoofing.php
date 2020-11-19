<?php $this->layout('_theme'); ?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Contacts</h1>
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
                <div class="card-body pb-0">
                    <div class="row d-flex align-items-stretch">
                        <?php if (!empty($doctors)): ?>
                            <?php foreach ($doctors as $doctor): ?>
                                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                                    <div class="card bg-light w-100">
                                        <div class="card-body">
                                            <p>Código: <?= $doctor->code; ?></p>
                                            <p>Nome: <?= $doctor->name; ?></p>
                                            <p>Valor: <?= $doctor->value; ?></p>
                                            <p>Grupo: <?= $doctor->group; ?></p>
                                            <p>Sub-grupo: <?= $doctor->subgroup; ?></p>
                                            <p>Comentário: <?= $doctor->commentary; ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <h1>Lista vazia</h1>
                        <?php endif; ?>
                    </div>
                </div>

                <!--            <div class="card-footer">-->
                <!--                <nav aria-label="Contacts Page Navigation">-->
                <!--                    <ul class="pagination justify-content-center m-0">-->
                <!--                        <li class="page-item active"><a class="page-link" href="#">1</a></li>-->
                <!--                        <li class="page-item"><a class="page-link" href="#">2</a></li>-->
                <!--                        <li class="page-item"><a class="page-link" href="#">3</a></li>-->
                <!--                        <li class="page-item"><a class="page-link" href="#">4</a></li>-->
                <!--                        <li class="page-item"><a class="page-link" href="#">5</a></li>-->
                <!--                        <li class="page-item"><a class="page-link" href="#">6</a></li>-->
                <!--                        <li class="page-item"><a class="page-link" href="#">7</a></li>-->
                <!--                        <li class="page-item"><a class="page-link" href="#">8</a></li>-->
                <!--                    </ul>-->
                <!--                </nav>-->
                <!--            </div>-->

            </div>
        </section>
    </div>
</div>
