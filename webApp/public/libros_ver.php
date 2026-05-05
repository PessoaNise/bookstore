<?php

session_start();
if (isset($_SESSION['usuario']) && $_SESSION['tipo_usuario'] === 'administrador') {


$PageTitle = "Ver libros";

include '../resources/templates/head.php';
?>
<body>
<?php
include '../resources/templates/svg-icons.php';
include '../resources/templates/header.php';
?>
<section id="lista-libros" class="padding-large bg-light-gray">
    <div class="container">
        <div class="card border-0 shadow-sm rounded-3 p-4 p-md-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="mb-0">Inventario de Libros</h3>
                <a href="libro_registrar.php" class="btn btn-dark">Añadir Nuevo</a>
            </div>

            <input class="form-control rounded-3 p-3 mb-4" type="text" id="busqueda" onkeyup="funcionBuscar()"
                    placeholder="Buscar por título del libro..." title="Escribe un título">

            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tabla">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">Portada</th>
                            <th class="text-center">ISBN</th>
                            <th class="text-center">Título</th>
                            <th class="text-center">Autor</th>
                            <th class="text-center">Categoría</th>
                            <th class="text-center">Stock</th>
                            <th class="text-center">Precio Vta.</th>
                            <th class="text-center">Estado</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include_once '../resources/db/LibroDB.php';
                        $libros = LibroDB::getLibros();
                        foreach ($libros as $libro): ?>
                            <tr>
                                <td class="text-center">
                                    <img src="../resources/uploads/<?= $libro['imagen'] ?>"
                                    style="height: 120px; object-fit: cover;" class="rounded shadow-sm">
                                </td>
                                <td class="text-center"><?= $libro['isbn'] ?></td>
                                <td class="text-center fw-bold"><?= $libro['titulo'] ?></td>
                                <td class="text-center"><?= $libro['autor'] ?></td>
                                <td class="text-center"><?= $libro['categoria'] ?></td>
                                <td class="text-center"><?= $libro['existencia'] ?></td>
                                <td class="text-center text-primary fw-bold">$<?= number_format($libro['precio_venta'], 2) ?></td>
                                <td class="text-center">
                                    <?php if ($libro['estado'] == 1): ?>
                                        <span class="badge bg-success">Activo</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Inactivo</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <form action="libro_modificar.php" method="POST" class="m-0">
                                        <input type="hidden" name="id" value="<?= $libro['id'] ?>">
                                        <button type="submit" class="btn btn-dark btn-sm px-4 py-2" style="border-radius: 5px;">Editar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>    
            </div>
        </div>
    </div>
</section>

    <script>
        /*
        function funcionBuscar() {
            let textoBuscar, tabla, renglones, primerCelda, renglon, textoCelda; // variables para la función

            textoBuscar = document.getElementById("busqueda").value.toUpperCase();
            tabla = document.getElementById("tabla");
            renglones = tabla.getElementsByTagName("tr");
            for (renglon = 0; renglon < renglones.length; renglon++) {
                primerCelda = renglones[renglon].getElementsByTagName("td")[1];
                if (primerCelda) {
                    textoCelda = primerCelda.textContent || primerCelda.innerText;
                    if (textoCelda.toUpperCase().indexOf(textoBuscar) > -1) {
                        renglones[renglon].style.display = "";
                    } else {
                        renglones[renglon].style.display = "none";
                    }
                }
            }
        }
        */
        const funcionBuscar = () => {
            const textoBuscar = document.getElementById("busqueda").value.toUpperCase();
            const renglones = document.querySelectorAll("#tabla tbody tr"); 

            renglones.forEach(renglon => {
                const celda = renglon.querySelectorAll("td")[2];
                
                if (celda) {
                    const coincide = celda.textContent.toUpperCase().includes(textoBuscar);
                    renglon.style.display = coincide ? "" : "none"; 
                }
            });
        };
    </script>

<?php
include '../resources/templates/footer.php';

} else {
    header("Location:login_error.php");
    exit();
}
