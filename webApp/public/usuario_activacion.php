<?php
include '../resources/db/UsuarioDB.php';

$activado = false;
$message = "No se proporcionó un código de activación válido.";

if (!empty($_GET["id"])) {
    $resultado = UsuarioDB::activaUsuarioById($_GET["id"]);

    if (!empty($resultado)) {
        $activado = true;
        $message = "Tu cuenta ha sido activada";
        $type = "success";
    } else {
        $message = "Hubo un problema al activar tu cuenta o ya ha sido activada";
        $type = "error";
    }
}

$PageTitle = "Activación";

include '../resources/templates/head.php';
include '../resources/templates/header.php';
include '../resources/templates/svg-icons.php';
?>

<section class="padding-large bg-light-gray" style="min-height: 60vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 text-center">
                <div class="card border-0 shadow-sm rounded-3 p-5">
                    
                    <?php if ($activado): ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#F86D72" class="bi bi-check-circle mx-auto mb-4" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                        </svg>
                        
                        <h2 class="mb-3 text-dark">¡Cuenta Activada!</h2>
                        <p class="text-black-50 mb-4 fs-5"><?= $message ?></p>
                        <a href="login.php" class="btn btn-dark py-3 px-5 fs-5 rounded-pill">Ir a Iniciar Sesión</a>
                    
                    <?php else: ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="#272727" class="bi bi-x-circle mx-auto mb-4" viewBox="0 0 16 16">
                            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
                        </svg>
                        
                        <h2 class="mb-3 text-dark">Error de Activación</h2>
                        <p class="text-black-50 mb-4 fs-5"><?= $message ?></p>
                        <a href="index.php" class="btn btn-outline-dark py-3 px-5 fs-5 rounded-pill">Volver a la Tienda</a>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</section>

<?php
include '../resources/templates/footer.php';