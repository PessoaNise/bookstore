<?php

session_start();
if (isset($_SESSION['usuario'])) {

    $PageTitle = "Librería Pessoa - Vista Previa";

    include '../resources/templates/head.php';
    ?>
    <body>
    <?php
    include '../resources/templates/svg-icons.php';
    include '../resources/templates/header.php';
    include_once '../resources/db/LibroDB.php';

    $libro = LibroDB::getLibroPorId($_GET['id']);
    ?>

    <section class="padding-large bg-light-gray">
        <div class="container">
            <h2 class="mb-5 text-center"><?= $libro['titulo'] ?></h2>
            <div class="card border-0 shadow-sm rounded-3 p-4" style="max-width: 1200px; margin: 0 auto;">
                <div class="row g-0 align-items-center">
                    <div class="col-md-4 text-center p-3">
                        <img src="../resources/uploads/<?= $libro['imagen'] ?>" class="img-fluid rounded-3 shadow" alt="<?= $libro['titulo'] ?>">
                    </div>
                    <div class="col-md-8 p-4">
                        <div class="card-body p-4">
                            <h4 class="card-title mb-3 fw-bold"><?= $libro['titulo'] ?></h4>
                            <p class="card-text text-black-50 mb-1"><strong>Autor:</strong> <?= $libro['autor'] ?></p>
                            <p class="card-text text-black-50 mb-1"><strong>Editorial:</strong> <?= $libro['editorial'] ?></p>
                            <p class="card-text text-black-50 mb-1"><strong>ISBN:</strong> <?= $libro['isbn'] ?></p>
                            <p class="card-text text-black-50 mb-1"><strong>Páginas:</strong> <?= $libro['paginas'] ?></p>
                            <p class="card-text text-black-50 mb-1"><strong>Año:</strong> <?= $libro['anio_publicacion'] ?></p>
                            <hr>
                            <p class="card-text"><strong>Descripción:</strong></p>
                            <p class="card-text text-black-50"><?= $libro['descripcion'] ?></p>
                            <hr>
                            <p class="card-text mb-1"><strong>Existencia:</strong> <?= $libro['existencia'] ?> unidades</p>
                            <p class="card-text fs-4 text-primary fw-bold mb-3">$<?= $libro['precio_venta'] ?></p>
                            <p class="card-text"><small class="text-body-secondary">En venta desde: <?= $libro['creado'] ?></small></p>
                            <div class="d-flex gap-3 mt-4">
                                <?php if ($libro['existencia'] > 0): ?>
                                <a href="../resources/lib/cartAction.php?action=addToCart&id=<?= $libro["id"]; ?>" class="btn">
                                    <svg class="cart me-2" width="20" height="20">
                                        <use xlink:href="#cart"></use>
                                    </svg>Agregar al carrito
                                </a>
                                <?php else: ?>
                                <button class="btn btn-secondary" disabled>Agotado</button>
                                <?php endif; ?>
                                <a href="cliente_vista.php" class="btn btn-dark">Seguir comprando</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php if (isset($_GET['error']) && $_GET['error'] == 'sinstock'): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Sin existencias',
                text: 'Este libro no tiene unidades disponibles en este momento.',
                icon: 'error',
                confirmButtonColor: '#272727'
            });
        });
    </script>
    <?php endif; ?>

    <?php
    include '../resources/templates/footer.php';

} else {
    header("Location:login_error.php");
    exit();
}
