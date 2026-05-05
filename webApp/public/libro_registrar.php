<?php

session_start();
if (isset($_SESSION['usuario']) && $_SESSION['tipo_usuario'] === 'administrador') { 

    include '../resources/db/LibroDB.php';
    include '../resources/db/ImagenDB.php';
    include '../resources/lib/sanitizacion.php';
    include '../resources/templates/svg-icons.php';

    $isbn = $titulo = $autor = $editorial = $descripcion = $paginas = $anioPublicacion = $existencia = $precioCompra = $precioVenta = $categoriaSel = "";

    $errores = [];

    if (isset($_POST['registrar'])) {

        if (empty($_POST['isbn'])) $errores['isbn'] = "Se requiere el ISBN del libro";
        else {
            $isbn = sanitizacion($_POST["isbn"]);
            if (!preg_match('/^\d{13}$/', $isbn)) $errores['isbn'] = "El ISBN debe tener exactamente 13 dígitos numéricos";
        }

        if (empty($_POST['titulo'])) $errores['titulo'] = "Se requiere el título del libro";
        else $titulo = sanitizacion($_POST["titulo"]);

        if (empty($_POST['autor'])) $errores['autor'] = "Se requiere el autor del libro";
        else $autor = sanitizacion($_POST["autor"]);

        if (empty($_POST['editorial'])) $errores['editorial'] = "Se requiere la editorial del libro";
        else $editorial = sanitizacion($_POST["editorial"]);

        if (empty($_POST['descripcion'])) $errores['descripcion'] = "Se requiere una descripción";
        else $descripcion = $_POST['descripcion'];

        if (empty($_POST['paginas'])) $errores['paginas'] = "Indica cuantas páginas tiene el libro";
        else {
            $paginas = sanitizacion($_POST['paginas']);
            if (!filter_var($paginas, FILTER_VALIDATE_INT)) $errores['paginas'] = "Formato incorrecto";
        }

        if (empty($_POST['anioPublicacion'])) $errores['anioPublicacion'] = "Indica el año de publicación";
        else {
            $anioPublicacion = sanitizacion($_POST['anioPublicacion']);
            if (!filter_var($anioPublicacion, FILTER_VALIDATE_INT)) $errores['anioPublicacion'] = "Formato incorrecto";
        }

        if (empty($_POST['existencia'])) $errores['existencia'] = "Indica cuantas unidades son";
        else {
            $existencia = sanitizacion($_POST['existencia']);
            if (!filter_var($existencia, FILTER_VALIDATE_INT)) $errores['existencia'] = "Formato incorrecto";
        }

        if (empty($_POST['precioCompra'])) $errores['precioCompra'] = "Se requiere el precio de compra";
        else {
            $precioCompra = sanitizacion($_POST['precioCompra']);
            if (!filter_var($precioCompra, FILTER_VALIDATE_FLOAT)) $errores['precioCompra'] = "Formato incorrecto";
        }

        if (empty($_POST['precioVenta'])) $errores['precioVenta'] = "Se requiere el precio de venta";
        else {
            $precioVenta = sanitizacion($_POST['precioVenta']);
            if (!filter_var($precioVenta, FILTER_VALIDATE_FLOAT)) $errores['precioVenta'] = "Formato incorrecto";
        }

        if (empty($_POST['categoria'])) $errores['categoria'] = "Se requiere una categoria";
        else $categoriaSel = $_POST["categoria"];

        if (count($errores) == 0) {
            $_POST['checkActivo'] = isset($_POST['checkActivo']) ? 1 : 0;

            $errorInsertarImagen = ImagenDB::insertaImagen($_FILES);
            if (!isset($errorInsertarImagen)) {
                $idImagen = ImagenDB::getMaxId();
                $resultadoRegistrarLibro = LibroDB::insertaLibro($_POST, $idImagen);
                
                // Limpiar formulario tras registro exitoso
                $isbn = $titulo = $autor = $editorial = $descripcion = $paginas = $anioPublicacion = $existencia = $precioCompra = $precioVenta = $categoriaSel = "";
            }
        }
    }

    $PageTitle = "Registrar Libro";
    include '../resources/templates/head.php';
    ?>

    <section id="add-book-form" class="padding-large bg-light-gray">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="card border-0 shadow-sm rounded-3 p-4 p-md-5">
                        <div class="section-title mb-4">
                            <h3 class="mb-0">Registrar Nuevo Libro</h3>
                        </div>

                        <form method="POST" novalidate action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" enctype="multipart/form-data" class="row g-4">
                            
                            <div class="col-md-4">
                                <label for="isbn" class="form-label fw-bold">ISBN*</label>
                                <input type="text" class="form-control rounded-3 p-3" id="isbn" name="isbn" value="<?= $isbn ?>" maxlength="13" pattern="\d{13}" title="El ISBN debe tener exactamente 13 dígitos numéricos">
                                <span class="text-danger fs-6"><?php if (isset($errores['isbn'])) print($errores['isbn']) ?></span>
                            </div>
                            
                            <div class="col-md-8">
                                <label for="titulo" class="form-label fw-bold">Título*</label>
                                <input type="text" class="form-control rounded-3 p-3" id="titulo" name="titulo" value="<?= $titulo ?>">
                                <span class="text-danger fs-6"><?php if (isset($errores['titulo'])) print($errores['titulo']) ?></span>
                            </div>

                            <div class="col-md-6">
                                <label for="autor" class="form-label fw-bold">Autor*</label>
                                <input type="text" class="form-control rounded-3 p-3" id="autor" name="autor" value="<?= $autor ?>">
                                <span class="text-danger fs-6"><?php if (isset($errores['autor'])) print($errores['autor']) ?></span>
                            </div>

                            <div class="col-md-6">
                                <label for="editorial" class="form-label fw-bold">Editorial*</label>
                                <input type="text" class="form-control rounded-3 p-3" id="editorial" name="editorial" value="<?= $editorial ?>">
                                <span class="text-danger fs-6"><?php if (isset($errores['editorial'])) print($errores['editorial']) ?></span>
                            </div>

                            <div class="col-12">
                                <label for="descripcion" class="form-label fw-bold">Descripción*</label>
                                <textarea class="form-control rounded-3 p-3" id="descripcion" name="descripcion" rows="4"><?= $descripcion ?></textarea>
                                <span class="text-danger fs-6"><?php if (isset($errores['descripcion'])) print($errores['descripcion']) ?></span>
                            </div>

                            <div class="col-md-4">
                                <label for="categoria" class="form-label fw-bold">Categoría *</label>
                                <select class="form-select rounded-3 p-3" id="categoria" name="categoria">
                                    <option value="" <?php if ($categoriaSel == "") print('selected') ?>>Selecciona una categoría</option>
                                    <?php
                                    include '../resources/db/CategoriaDB.php';
                                    $categorias = CategoriaDB::getCategorias();
                                    foreach ($categorias as $categoria): ?>
                                        <option value="<?= $categoria['id'] ?>" <?php if ($categoria['id'] == $categoriaSel) print('selected') ?>> <?= $categoria['categoria'] ?></option>
                                    <?php endforeach ?>
                                </select>
                                <span class="text-danger fs-6"><?php if (isset($errores['categoria'])) print($errores['categoria']) ?></span>
                            </div>

                            <div class="col-md-4">
                                <label for="paginas" class="form-label fw-bold">Páginas*</label>
                                <input type="number" class="form-control rounded-3 p-3" id="paginas" name="paginas" value="<?= $paginas ?>">
                                <span class="text-danger fs-6"><?php if (isset($errores['paginas'])) print($errores['paginas']) ?></span>
                            </div>

                            <div class="col-md-4">
                                <label for="anioPublicacion" class="form-label fw-bold">Año*</label>
                                <input type="number" class="form-control rounded-3 p-3" id="anioPublicacion" name="anioPublicacion" value="<?= $anioPublicacion ?>">
                                <span class="text-danger fs-6"><?php if (isset($errores['anioPublicacion'])) print($errores['anioPublicacion']) ?></span>
                            </div>

                            <div class="col-md-4">
                                <label for="precioCompra" class="form-label fw-bold">Precio Compra*</label>
                                <input type="text" class="form-control rounded-3 p-3" id="precioCompra" name="precioCompra" value="<?= $precioCompra ?>">
                                <span class="text-danger fs-6"><?php if (isset($errores['precioCompra'])) print($errores['precioCompra']) ?></span>
                            </div>

                            <div class="col-md-4">
                                <label for="precioVenta" class="form-label fw-bold">Precio Venta*</label>
                                <input type="text" class="form-control rounded-3 p-3" id="precioVenta" name="precioVenta" value="<?= $precioVenta ?>">
                                <span class="text-danger fs-6"><?php if (isset($errores['precioVenta'])) print($errores['precioVenta']) ?></span>
                            </div>

                            <div class="col-md-4">
                                <label for="existencia" class="form-label fw-bold">Existencia*</label>
                                <input type="number" class="form-control rounded-3 p-3" id="existencia" name="existencia" value="<?= $existencia ?>">
                                <span class="text-danger fs-6"><?php if (isset($errores['existencia'])) print($errores['existencia']) ?></span>
                            </div>

                            <div class="col-md-8">
                                <label for="imagen" class="form-label fw-bold">Imagen de Portada</label>
                                <input class="form-control rounded-3 p-3" type="file" id="imagen" name="imagen">
                            </div>

                            <div class="col-md-4 d-flex align-items-center mt-5">
                                <div class="form-check form-switch fs-5">
                                    <input class="form-check-input" type="checkbox" id="checkActivo" name="checkActivo" checked>
                                    <label class="form-check-label ms-2" for="checkActivo">Activo</label>
                                </div>
                            </div>

                            <div class="col-12 mt-5">
                                <button type="submit" name="registrar" class="btn btn-dark w-100 py-3 fs-5">Guardar Libro</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php if (isset($errorInsertarImagen)): ?>
        <script>
            Swal.fire({
                title: "<?=$errorInsertarImagen ?>",
                icon: "error",
                timer: 2000
            });
        </script>
    <?php endif ?>

    <?php if (isset($resultadoRegistrarLibro)): ?>
        <script>
            Swal.fire({
                title: "Libro registrado exitosamente",
                icon: "success",
                timer: 2000
            });
        </script>
    <?php endif ?>

    <?php
    include '../resources/templates/footer.php';

} else {
    header("Location:login_error.php");
    exit();
}
