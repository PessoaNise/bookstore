<?php

function getLibros($id, $palabra, $logeado) {

    if ($id == 0) {
        $libros = LibroDB::getLibros();
    } else {
        $libros = LibroDB::getLibrosPorCategoriaId($id);
    }

    $encontrados = 0;

    foreach ($libros as $libro) {
        if (!$palabra == "") {
            // Búsqueda flexible: case-insensitive y parcial
            $palabraLower = mb_strtolower(trim($palabra), 'UTF-8');
            $tituloLower = mb_strtolower($libro['titulo'], 'UTF-8');
            $autorLower = mb_strtolower($libro['autor'], 'UTF-8');
            $editorialLower = mb_strtolower($libro['editorial'], 'UTF-8');
            $categoriaLower = mb_strtolower($libro['categoria'], 'UTF-8');

            // Buscar coincidencia parcial en titulo, autor, editorial o categoría
            if (
                mb_strpos($tituloLower, $palabraLower) !== false ||
                mb_strpos($autorLower, $palabraLower) !== false ||
                mb_strpos($editorialLower, $palabraLower) !== false ||
                mb_strpos($categoriaLower, $palabraLower) !== false
            ) {
                $encontrados++;
                renderCardLibro($libro, $logeado);
            }
        } else {
            $encontrados++;
            renderCardLibro($libro, $logeado);
        }
    }

    if ($encontrados == 0) {
        echo '<div class="col-12 text-center py-5">
                <h4 class="text-black-50">No se encontraron resultados</h4>
                <p>Intenta con otra palabra o categoría.</p>
              </div>';
    }
}

function renderCardLibro($libro, $logeado) {
    ?>
    <div class="col-md-4 col-lg-3 mb-4">
        <div class="card position-relative p-4 border rounded-3 h-100">
            <a href="<?php $logeado ? print('vista_previa.php?id='.$libro['id']) : print('login.php') ?>">
                <img src="../resources/uploads/<?= $libro['imagen'] ?>" class="img-fluid shadow-sm" alt="<?= $libro['titulo'] ?>">
            </a>
            <h6 class="mt-4 mb-0 fw-bold">
                <a href="<?php $logeado ? print('vista_previa.php?id='.$libro['id']) : print('login.php') ?>"><?= $libro['titulo'] ?></a>
            </h6>
            <div class="review-content">
                <p class="my-2 fs-6 text-black-50"><?= $libro['autor'] ?></p>
            </div>
            <span class="price text-primary fw-bold mb-2 fs-5">$<?= $libro['precio_venta'] ?></span>
            <a href="<?php $logeado ? print('vista_previa.php?id='.$libro['id']) : print('login.php') ?>" class="btn btn-dark mt-auto">Ver más</a>
        </div>
    </div>
    <?php
}
