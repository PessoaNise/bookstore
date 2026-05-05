<?php

session_start();
if (isset($_SESSION['usuario']) && $_SESSION['tipo_usuario'] === 'cliente') {

    include_once '../resources/db/CarroDB.php';
    include_once '../resources/db/LibroDB.php';

    // Initialize shopping cart class
    if (!isset($cart)) {
        $cart = new Cart;
    }

    $PageTitle = "Librería Pessoa - Carrito";

    include '../resources/templates/head.php';
    ?>
    <body>
    <?php
    include '../resources/templates/svg-icons.php';
    include '../resources/templates/header.php';
    ?>

    <section class="padding-large bg-light-gray">
        <div class="container">
            <h3 class="mb-4">Carrito de Compras</h3>
            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th width="10%"></th>
                                <th width="35%">Libro</th>
                                <th width="15%">Precio</th>
                                <th width="15%">Cantidad</th>
                                <th width="20%">Total</th>
                                <th width="5%"></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if ($cart->total_items() > 0){
                                $cartItems = $cart->contents();
                                foreach ($cartItems as $item) {
                                    $libroStock = LibroDB::getLibroPorId($item['id']);
                                    $maxStock = $libroStock ? $libroStock['existencia'] : 99;
                                    ?>
                                    <tr>
                                        <td><img src="../resources/uploads/<?= $item["image"] ?>" width="80" class="rounded-3 shadow-sm" alt="..."></td>
                                        <td class="align-middle fw-bold"><?php echo $item["name"]; ?></td>
                                        <td class="align-middle">$<?= $item["price"] ?></td>
                                        <td class="align-middle"><input class="form-control" style="width:80px" type="number" min="1" max="<?= $maxStock ?>" value="<?= $item["qty"]; ?>" onchange="updateCartItem(this, '<?= $item["rowid"] ?>', <?= $maxStock ?>)"/></td>
                                        <td class="align-middle fw-bold text-primary">$<?= $item["subtotal"] ?></td>
                                        <td class="align-middle">
                                            <button class="btn btn-sm btn-danger rounded-pill"
                                                    onclick="return confirm('¿Estás seguro de eliminar este artículo?')?window.location.href='../resources/lib/cartAction.php?action=removeCartItem&id=<?php echo $item["rowid"]; ?>':false;"
                                                    title="Eliminar">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                                                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                <?php }
                            } else { ?>
                            <tr>
                                <td colspan="6"><p class="text-center text-black-50 py-4">Tu carrito está vacío...</p></td>
                            </tr>
                            <?php } ?>
                            <?php if ($cart->total_items() > 0){ ?>
                                <tr class="table-light">
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><strong class="fs-5">TOTAL</strong></td>
                                    <td><strong class="fs-5 text-primary">$<?= $cart->total() ?></strong></td>
                                    <td></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-12 mt-3">
                    <div class="d-flex flex-wrap gap-3 justify-content-between">
                        <a href="cliente_vista.php" class="btn btn-dark">Continuar comprando</a>
                        <?php if ($cart->total_items() > 0) { ?>
                            <a href="orden_pago.php" class="btn">Proceder con el pago</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function updateCartItem(obj, id, maxStock) {
            if (parseInt(obj.value) > maxStock) {
                Swal.fire({
                    title: 'Stock insuficiente',
                    text: 'Solo hay ' + maxStock + ' unidades disponibles de este libro.',
                    icon: 'warning',
                    confirmButtonColor: '#272727'
                });
                obj.value = maxStock;
                return;
            }
            $.get("../resources/lib/cartAction.php", {action: "updateCartItem", id: id, qty: obj.value}, function (data) {
                if (data == 'ok') {
                    location.reload();
                } else if (data == 'maxstock') {
                    Swal.fire({
                        title: 'Stock insuficiente',
                        text: 'No hay suficientes unidades disponibles.',
                        icon: 'warning',
                        confirmButtonColor: '#272727'
                    });
                    location.reload();
                } else {
                    alert('Error al actualizar el carrito, intenta de nuevo.');
                }
            });
        }

        // Mostrar alerta si hay error de stock en URL
        <?php if (isset($_GET['error']) && $_GET['error'] == 'maxstock'): ?>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Stock máximo alcanzado',
                text: 'Ya tienes el máximo de unidades disponibles de este libro en tu carrito.',
                icon: 'warning',
                confirmButtonColor: '#272727'
            });
        });
        <?php endif; ?>
    </script>

    <?php
    include '../resources/templates/footer.php';
} else {
    header("Location:login_error.php");
    exit();
}
