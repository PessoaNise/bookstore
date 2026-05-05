<?php

session_start();
if (isset($_SESSION['usuario']) && $_SESSION['tipo_usuario'] === 'administrador') {

    $PageTitle = "Librería Pessoa - Todos los Pedidos";

    include '../resources/db/PedidoDB.php';
    include '../resources/db/ItemPedidoDB.php';

    include '../resources/templates/head.php';
    ?>
    <body>
    <?php
    include '../resources/templates/svg-icons.php';
    include '../resources/templates/header.php';
    ?>

    <section class="padding-large bg-light-gray">
        <div class="container">
            <h3 class="mb-4">Gestión de Pedidos</h3>

            <?php
            $ordenes = PedidoDB::getOrdenes();
            
            if (empty($ordenes)): ?>
                <div class="card border-0 shadow-sm rounded-3 p-5 text-center">
                    <h4 class="text-black-50">No hay pedidos registrados</h4>
                </div>
            <?php else: ?>
                <div class="accordion" id="accordionPedidosAdmin">
                    <?php
                    $i = 1;
                    foreach ($ordenes as $orden): ?>

                        <div class="accordion-item border-0 shadow-sm rounded-3 mb-3">
                            <h2 class="accordion-header">
                                <button class="accordion-button <?php if ($i != 1) print('collapsed') ?> rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapse-<?= $i ?>"
                                        aria-expanded="<?php ($i == 1) ? print('true') : print('false') ?>"
                                        aria-controls="collapse-<?= $i ?>">
                                    <div class="d-flex flex-wrap gap-4">
                                        <span><strong>Pedido #<?= $orden['id'] ?></strong></span>
                                        <span><strong>Cliente:</strong> <?= isset($orden['nombre']) ? $orden['nombre'] . ' ' . $orden['a_paterno'] : 'N/A' ?></span>
                                        <span><strong>Fecha:</strong> <?= $orden['creada'] ?></span>
                                        <span class="badge bg-<?= $orden['estado'] == 'Completa' ? 'success' : ($orden['estado'] == 'Cancelada' ? 'danger' : 'warning') ?> d-flex align-items-center"><?= $orden['estado'] ?></span>
                                        <span><strong>Total:</strong> <span class="text-primary">$<?= $orden['total'] ?></span></span>
                                    </div>
                                </button>
                            </h2>
                            <div id="collapse-<?= $i ?>" class="accordion-collapse collapse <?php if ($i == 1) print('show') ?>" data-bs-parent="#accordionPedidosAdmin">
                                <div class="accordion-body">
                                    <?php
                                    $items = ItemPedidoDB::getDatosItemsOrdenPorIdOrden($orden['id']);
                                    foreach ($items as $item): ?>
                                        <div class="row align-items-center border-bottom py-3">
                                            <div class="col-md-2 text-center">
                                                <img src="../resources/uploads/<?= $item['nombre_archivo'] ?>" alt="" width="70" class="rounded-3 shadow-sm">
                                            </div>
                                            <div class="col-md-5">
                                                <p class="mb-1"><strong><?= $item['titulo'] ?></strong></p>
                                                <p class="mb-0 text-black-50">Cantidad: <?= $item['cantidad'] ?></p>
                                            </div>
                                            <div class="col-md-5 text-md-end">
                                                <p class="mb-1">Precio: $<?= $item['precio_venta'] ?></p>
                                                <p class="mb-0 fw-bold text-primary">Subtotal: $<?= $item['cantidad'] * $item['precio_venta'] ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        $i++;
                    endforeach ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <?php
    include '../resources/templates/footer.php';

} else {
    header("Location:login_error.php");
    exit();
}
