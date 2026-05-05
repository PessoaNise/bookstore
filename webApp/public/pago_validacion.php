<?php

session_start();
if (isset($_SESSION['usuario']) && $_SESSION['tipo_usuario'] === 'cliente') {

    include '../resources/db/PedidoDB.php';
    include '../resources/db/ItemPedidoDB.php';

    if (!empty($_REQUEST['id'])) {
        $order_id = base64_decode($_REQUEST['id']);
        $orderData = PedidoDB::getDatosPersonaOrdenPorIdOrden($order_id);
    }

    if (empty($orderData)) {
        header("Location: index.php");
        exit();
    }

    $PageTitle = "Librería Pessoa - Confirmación de Pago";

    include '../resources/templates/head.php';
    ?>
    <body>
    <?php
    include '../resources/templates/svg-icons.php';
    include '../resources/templates/header.php';
    ?>

    <section class="padding-large bg-light-gray">
        <div class="container">
            <h3 class="mb-4">Estado de la Orden</h3>
            <div class="col-12">
                <?php if (!empty($orderData)) : ?>
                    <div class="alert alert-success shadow-sm rounded-3">
                        <strong>¡Éxito!</strong> Tu orden ha sido procesada exitosamente.
                    </div>

                    <!-- Order info -->
                    <div class="card border-0 shadow-sm rounded-3 p-4 mb-4">
                        <h4 class="mb-3">Información de la orden</h4>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Número de referencia:</strong> #<?= $orderData['id']; ?></p>
                                <p><strong>Total:</strong> <span class="text-primary fw-bold fs-5">$<?= $orderData['total']; ?></span></p>
                                <p><strong>Fecha compra:</strong> <?= $orderData['creada']; ?></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Nombre cliente:</strong> <?= $orderData['nombre'] . ' ' . $orderData['a_paterno']; ?></p>
                                <p><strong>Email:</strong> <?= $orderData['correo_electronico']; ?></p>
                                <p><strong>Dirección:</strong> <?= $orderData['calle'] . ' #' . $orderData['numero']; ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Order items -->
                    <div class="card border-0 shadow-sm rounded-3 p-4 mb-4">
                        <h4 class="mb-3">Artículos del pedido</h4>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th width="10%"></th>
                                    <th width="40%">Libro</th>
                                    <th width="15%">Precio</th>
                                    <th width="15%">Cantidad</th>
                                    <th width="20%">Subtotal</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $items = ItemPedidoDB::getDatosItemsOrdenPorIdOrden($orderData['id']);
                                foreach ($items as $item) : ?>
                                    <tr>
                                        <td><img src="../resources/uploads/<?= $item["nombre_archivo"] ?>" width="60" class="rounded-3" alt="..."></td>
                                        <td class="align-middle fw-bold"><?= $item["titulo"]; ?></td>
                                        <td class="align-middle">$<?= $item['precio_venta'] ?></td>
                                        <td class="align-middle"><?= $item['cantidad'] ?></td>
                                        <td class="align-middle text-primary fw-bold">$<?= $item['precio_venta'] * $item['cantidad'] ?></td>
                                    </tr>
                                <?php endforeach ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-3">
                        <a href="cliente_vista.php" class="btn">Continuar comprando</a>
                        <form action="ticket_generar.php" method="get" target="_blank" class="d-inline">
                            <input type="hidden" name="idOrden" value="<?= $order_id ?>">
                            <button type="submit" class="btn btn-dark">Descargar Ticket PDF</button>
                        </form>
                    </div>
                
                <?php else: ?>
                    <div class="alert alert-danger">
                        ¡Ha habido un error al procesar tu pago!
                    </div>
                <?php endif ?>
            </div>
        </div>
    </section>

    <?php
    include '../resources/templates/footer.php';

} else {
    header("Location:login_error.php");
    exit();
}
