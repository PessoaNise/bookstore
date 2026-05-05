<?php

session_start();
if (isset($_SESSION['usuario']) && $_SESSION['tipo_usuario'] === 'cliente') {

    // Initialize shopping cart class
    include_once '../resources/db/CarroDB.php';
    $cart = new Cart;

    // If the cart is empty, redirect to the products page
    if ($cart->total_items() <= 0) {
        header("Location: cliente_vista.php");
        exit();
    }

    // Get posted form data from session
    $postData = !empty($_SESSION['postData']) ? $_SESSION['postData'] : array();
    unset($_SESSION['postData']);

    // Get status message from session
    $sessData = !empty($_SESSION['sessData']) ? $_SESSION['sessData'] : '';
    if (!empty($sessData['status']['msg'])) {
        $statusMsg = $sessData['status']['msg'];
        $statusMsgType = $sessData['status']['type'];
        unset($_SESSION['sessData']['status']);
    }

    $PageTitle = "Librería Pessoa - Pago";

    include '../resources/templates/head.php';
    ?>
    <body>
    <?php
    include '../resources/templates/svg-icons.php';
    include '../resources/templates/header.php';
    ?>

    <section class="padding-large bg-light-gray">
        <div class="container">
            <?php if (!empty($statusMsg) && ($statusMsgType == 'success')) { ?>
                <div class="alert alert-success"><?= $statusMsg; ?></div>
            <?php } elseif (!empty($statusMsg) && ($statusMsgType == 'error')) { ?>
                <div class="alert alert-danger"><?= $statusMsg; ?></div>
            <?php } ?>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h3 class="mb-4">Resumen de tu pedido</h3>
                    <h5 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-black-50">Tu carrito</span>
                        <span class="badge bg-dark rounded-pill"><?php echo $cart->total_items(); ?></span>
                    </h5>
                    <ul class="list-group mb-4 shadow-sm">
                        <?php
                        if ($cart->total_items() > 0) {
                            $cartItems = $cart->contents();
                            foreach ($cartItems as $item) {
                                ?>
                                <li class="list-group-item d-flex justify-content-between lh-condensed">
                                    <div>
                                        <h6 class="my-0 fw-bold"><?php echo $item["name"]; ?></h6>
                                        <small class="text-dark">$<?= $item["price"]; ?> × <?= $item["qty"]; ?></small>
                                    </div>
                                    <span class="text-primary fw-bold">$<?= $item["subtotal"]; ?></span>
                                </li>
                            <?php }
                        } ?>
                        <li class="list-group-item d-flex justify-content-between bg-light">
                            <span class="fw-bold">Total</span>
                            <strong class="text-primary fs-5">$<?= $cart->total() ?></strong>
                        </li>
                    </ul>
                    <div class="mb-5 text-end">
                        <a href="cliente_vista.php" class="btn btn-dark">Agregar más libros</a>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <h3 class="mb-4">Datos de pago</h3>
                    <div class="card border-0 shadow-sm rounded-3 p-4">
                        <form method="post" action="../resources/lib/cartAction.php">
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="propietario" class="form-label fw-bold">Propietario de la tarjeta *</label>
                                    <input type="text" class="form-control rounded-3" name="propietario" placeholder="Nombre como aparece en la tarjeta" required>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="cvv" class="form-label fw-bold">CVV *</label>
                                    <input type="text" class="form-control rounded-3" name="cvv" placeholder="123" maxlength="4" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="numTarjeta" class="form-label fw-bold">Número de tarjeta *</label>
                                    <input type="text" class="form-control rounded-3" name="numTarjeta" placeholder="XXXX XXXX XXXX XXXX" maxlength="19" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-2">
                                    <label class="form-label fw-bold">Fecha de expiración *</label>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-md-5 mb-3">
                                    <select class="form-select rounded-3" name="mes">
                                        <option value="01">Enero</option>
                                        <option value="02">Febrero</option>
                                        <option value="03">Marzo</option>
                                        <option value="04">Abril</option>
                                        <option value="05">Mayo</option>
                                        <option value="06">Junio</option>
                                        <option value="07">Julio</option>
                                        <option value="08">Agosto</option>
                                        <option value="09">Septiembre</option>
                                        <option value="10">Octubre</option>
                                        <option value="11">Noviembre</option>
                                        <option value="12">Diciembre</option>
                                    </select>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <select class="form-select rounded-3" name="anio">
                                        <option value="24">2024</option>
                                        <option value="25">2025</option>
                                        <option value="26" selected>2026</option>
                                        <option value="27">2027</option>
                                        <option value="28">2028</option>
                                        <option value="29">2029</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3 text-center">
                                    <img src="assets/img/visa.jpg" alt="visa" style="height:30px" class="me-1">
                                    <img src="assets/img/mastercard.jpg" alt="mastercard" style="height:30px">
                                </div>
                            </div>
                            <div class="mt-4 text-end">
                                <input type="hidden" name="action" value="placeOrder"/>
                                <button class="btn w-100 py-3 fs-5" type="submit">Pagar $<?= $cart->total() ?></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php
    include '../resources/templates/footer.php';

} else {
    header("Location:login_error.php");
    exit();
}