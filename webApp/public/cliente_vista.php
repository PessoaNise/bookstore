<?php

session_start();
if (isset($_SESSION['usuario']) && $_SESSION['tipo_usuario'] === 'cliente') {

    $PageTitle = "Librería Pessoa - Tienda";

    include '../resources/templates/head.php';
    ?>
    <body>
    <?php
    include '../resources/templates/svg-icons.php';
    include '../resources/templates/header.php';
    ?>

    <section class="padding-large bg-light-gray">
        <div class="container">
            <div class="section-title d-md-flex justify-content-between align-items-center mb-4">
                <h3 class="d-flex align-items-center">Libros Populares</h3>
                <p class="text-black-50">Descubre nuestra selección de libros destacados</p>
            </div>
            <div class="row justify-content-center">

                <?php
                include_once '../resources/db/LibroDB.php';
                $librosAleatorios = LibroDB::getLibrosAleatorios(6);

                if (!empty($librosAleatorios)):
                    foreach ($librosAleatorios as $libro) : ?>
                        <div class="col-md-4 col-lg-3 col-xl-2 mb-4">
                            <div class="card position-relative p-3 border rounded-3 h-100">
                                <a href="vista_previa.php?id=<?= $libro['id'] ?>">
                                    <img src="../resources/uploads/<?= $libro['imagen'] ?>" class="img-fluid shadow-sm" alt="<?= $libro['titulo'] ?>">
                                </a>
                                <h6 class="mt-3 mb-0 fw-bold">
                                    <a href="vista_previa.php?id=<?= $libro['id'] ?>"><?= $libro['titulo'] ?></a>
                                </h6>
                                <div class="review-content">
                                    <p class="my-1 fs-6 text-black-50"><?= $libro['autor'] ?></p>
                                </div>
                                <p class="text-black-50 small mb-2"><?= substr($libro['descripcion'], 0, 80) . '...' ?></p>
                                <span class="price text-primary fw-bold mb-2 fs-5">$<?= $libro['precio_venta'] ?></span>
                                <div class="mt-auto">
                                    <a href="vista_previa.php?id=<?= $libro['id'] ?>" class="btn btn-dark w-100">Ver más</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach;
                else: ?>
                    <div class="col-12 text-center py-5">
                        <h4 class="text-black-50">No hay libros disponibles en este momento</h4>
                        <p>Vuelve pronto para ver nuestra colección actualizada.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php
    include '../resources/templates/footer.php';

} else {
    header("Location:login_error.php");
    exit();
}
