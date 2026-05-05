<?php

$PageTitle = "Librería Pessoa - Buscar Libros";

include '../resources/templates/head.php';
?>
<body>
<?php
include '../resources/templates/svg-icons.php';
include '../resources/templates/header.php';

include '../resources/lib/getLibros.php';
include_once '../resources/db/LibroDB.php';
?>

<section class="padding-large bg-light-gray">
    <div class="container">
        <h3 class="mb-4">Resultados de búsqueda</h3>
        <div class="row">
            <?php
            getLibros($_GET['id'], $_GET['palabra'], false);
            ?>
        </div>
    </div>
</section>

<?php
include '../resources/templates/footer.php';