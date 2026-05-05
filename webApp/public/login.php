<?php

include '../resources/db/UsuarioDB.php';

$usuario = $contrasenia = '';
$errorLogin = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $usuario = $_POST['usuario'];
    $contrasenia = $_POST['contrasenia'];

    $passwordHasheado = UsuarioDB::getPasswordHashByUser($_POST['usuario']);
    if (password_verify($_POST['contrasenia'], $passwordHasheado) && UsuarioDB::esActivo($usuario)) {
        session_start();
        $_SESSION['usuario'] = $_POST['usuario'];
        $consulta = UsuarioDB::getUsuarioTipoCientePorUsuario($_POST['usuario']);
        $tipoUsuario = $consulta['tipo_usuario'];
        $_SESSION['id_usuario'] = $consulta['id'];
        $_SESSION['tipo_usuario'] = $tipoUsuario;
        if ($tipoUsuario == 'administrador') {
            header("Location:administrador_vista.php");
        } else {
            header("Location:cliente_vista.php");
        }
        exit();
    } else { // Usuario o password inválido
        $errorLogin = "Usuario o contraseña incorrectos.";
    }
}

$PageTitle = "Login";

include '../resources/templates/head.php';
?>
<body>
<?php
include '../resources/templates/svg-icons.php';
include '../resources/templates/header.php';
?>

<section id="login-form" class="padding-large bg-light-gray">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card border-0 shadow-sm rounded-3 p-4 p-md-5">
                    <div class="section-title mb-4 text-center">
                        <h3 class="mb-0">Iniciar Sesión</h3>
                        <p class="text-black-50 mt-2">Bienvenido de nuevo. Ingresa a tu cuenta de Librería Pessoa.</p>
                    </div>

                    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" class="row g-4">
                        <div class="col-12">
                            <label class="form-label fw-bold" for="usuario">Nombre de Usuario *</label>
                            <input class="form-control rounded-3 p-3" type="text" name="usuario" id="usuario" value="<?= htmlspecialchars($usuario) ?>" required>
                        </div>
                        
                        <div class="col-12">
                            <label class="form-label fw-bold" for="contrasenia">Contraseña *</label>
                            <input class="form-control rounded-3 p-3" type="password" name="contrasenia" id="contrasenia" required>
                        </div>

                        <div class="col-12 mt-4 d-flex justify-content-between align-items-center">
                            <a href="#" class="text-decoration-underline text-black-50 fs-6">¿Olvidaste tu contraseña?</a>
                            <a href="usuario_registro.php" class="text-decoration-underline text-black-50 fs-6">Crear una cuenta nueva</a>
                        </div>

                        <div class="col-12 mt-4">
                            <button type="submit" class="btn btn-dark w-100 py-3 fs-5">Ingresar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if ($errorLogin !== ""): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: "Error de acceso",
                text: "<?= $errorLogin ?>",
                icon: "error",
                confirmButtonColor: "#272727"
            });
        });
    </script>
<?php endif; ?>

<?php include '../resources/templates/footer.php'; ?>