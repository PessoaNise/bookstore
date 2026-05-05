<?php

include '../resources/db/PersonaDB.php';
include '../resources/db/UsuarioDB.php';
include '../resources/lib/sanitizacion.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

$nombre = $paterno = $materno = $calle = $numero = $cp = $ciudad = $telefono = $usuario = $email =
$contrasenia = $contrasenia2 = "";
$errores = [];
$resEnviarCorreo = false;
$errorGeneral = ""; // Variable para capturar errores sin romper el HTML

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = sanitizacion($_POST["nombre"]);
    $paterno = sanitizacion($_POST["paterno"]);
    $materno = sanitizacion($_POST["materno"]);
    $calle = sanitizacion($_POST["calle"]);
    $numero = sanitizacion($_POST["numero"]);
    $cp = sanitizacion($_POST["cp"]);
    $ciudad = sanitizacion($_POST["ciudad"]);
    $telefono = sanitizacion($_POST["telefono"]);
    $usuario = sanitizacion($_POST["usuario"]);
    $email = sanitizacion($_POST["email"]);

    if (PersonaDB::existeCorreo($_POST['email'])) {
        $errorGeneral = "Ya existe un registro con ese correo electrónico.";
    } else if (UsuarioDB::existeUsuario($_POST['usuario'])) {
        $errorGeneral = "Ya existe un registro con ese nombre de usuario.";
    } else {
        PersonaDB::insertaPersona($_POST);
        $idPersonaInsertada = PersonaDB::getUltimoIdInsertado();
        $resInsertUsuario = UsuarioDB::insertaUsuario($idPersonaInsertada, $_POST);
        
        if ($resInsertUsuario > 0) {
            $idUsuarioInsertado = UsuarioDB::getIdUltimoInsertado();
            $mail = new PHPMailer(true);
            try {
                $mail->SMTPDebug = SMTP::DEBUG_OFF;
                $mail->isSMTP();
                $mail->Host = 'sandbox.smtp.mailtrap.io';
                $mail->SMTPAuth = true;
                $mail->Username = 'ffb41d9b44cace';
                $mail->Password = '4cb962207e3c58';
                $mail->Port = 2525;

                $mail->setFrom('registro@tizaovenirs.com', 'Bookly Admin');
                $mail->addAddress($email, $nombre . ' ' . $paterno);

                $link = "http://$_SERVER[HTTP_HOST]" . "/public/usuario_activacion.php?id=" . $idUsuarioInsertado;
                $mail->isHTML(true);
                $mail->Subject = 'Valida tu correo por favor';
                $mail->Body = "<div style='font-family: Arial, sans-serif; padding: 20px;'>
                                <h2>Bienvenido a Bookly!</h2>
                                <p>Hola $nombre, gracias por registrarte. Para activar tu cuenta, haz clic en el siguiente enlace:</p>
                                <a href='$link' style='display: inline-block; padding: 10px 20px; background-color: #272727; color: white; '>Activar mi cuenta</a>
                               </div>";

                $resEnviarCorreo = $mail->send();
            } catch (Exception $e) {
                $errorGeneral = "No se pudo envíar el correo. Mailer error: {$mail->ErrorInfo}";
            }
        } else {
            $errorGeneral = "Error al registrar el usuario en la base de datos.";
        }
    }
}

$PageTitle = "Registro usuario";
include '../resources/templates/head.php';
include '../resources/templates/header.php';
include '../resources/templates/svg-icons.php';

?>

<section id="register-form" class="padding-large bg-light-gray">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-sm rounded-3 p-4 p-md-5">
                    <div class="section-title mb-4 text-center">
                        <h3 class="mb-0">Registro de usuario nuevo</h3>
                        <p class="text-black-50 mt-2">Únete a Bookly para realizar pedidos y gestionar tus compras.</p>
                    </div>

                    <form method="POST" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" class="row g-4">
                        
                        <h5 class="fw-bold mb-0 border-bottom pb-2">1. Datos Personales</h5>
                        
                        <div class="col-md-4">
                            <label class="form-label fw-bold" for="nombre">Nombre *</label>
                            <input class="form-control rounded-3 p-3" type="text" required name="nombre" id="nombre" value="<?= $nombre ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold" for="paterno">Apellido paterno *</label>
                            <input class="form-control rounded-3 p-3" type="text" required name="paterno" id="paterno" value="<?= $paterno ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold" for="materno">Apellido materno *</label>
                            <input class="form-control rounded-3 p-3" type="text" required name="materno" id="materno" value="<?= $materno ?>">
                        </div>

                        <h5 class="fw-bold mb-0 border-bottom pb-2 mt-5">2. Dirección y Contacto</h5>
                        
                        <div class="col-md-8">
                            <label class="form-label fw-bold" for="calle">Calle *</label>
                            <input class="form-control rounded-3 p-3" type="text" required name="calle" id="calle" value="<?= $calle ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold" for="numero">Número *</label>
                            <input class="form-control rounded-3 p-3" type="text" required name="numero" id="numero" value="<?= $numero ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold" for="cp">Código postal *</label>
                            <input class="form-control rounded-3 p-3" type="text" required name="cp" id="cp" value="<?= $cp ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold" for="ciudad">Ciudad *</label>
                            <input class="form-control rounded-3 p-3" type="text" required name="ciudad" id="ciudad" value="<?= $ciudad ?>">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold" for="telefono">Teléfono *</label>
                            <input class="form-control rounded-3 p-3" type="text" required name="telefono" id="telefono" value="<?= $telefono ?>">
                        </div>

                        <h5 class="fw-bold mb-0 border-bottom pb-2 mt-5">3. Datos de la Cuenta</h5>

                        <div class="col-md-6">
                            <label class="form-label fw-bold" for="usuario">Usuario *</label>
                            <input class="form-control rounded-3 p-3" type="text" required name="usuario" id="usuario" value="<?= $usuario ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold" for="email">Correo electrónico *</label>
                            <input class="form-control rounded-3 p-3" type="email" required name="email" id="email" value="<?= $email ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold" for="contrasenia">Contraseña *</label>
                            <input class="form-control rounded-3 p-3" type="password" name="contrasenia" id="contrasenia" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold" for="contrasenia2">Repetir contraseña *</label>
                            <input class="form-control rounded-3 p-3" type="password" name="contrasenia2" id="contrasenia2" required>
                        </div>

                        <div class="col-12 mt-5">
                            <button type="submit" class="btn btn-dark w-100 py-3 fs-5">Crear Cuenta</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    let password = document.getElementById("contrasenia");
    let confirm_password = document.getElementById("contrasenia2");

    function validatePassword() {
        if (password.value !== confirm_password.value) {
            confirm_password.setCustomValidity("Las contraseñas no coinciden");
        } else {
            confirm_password.setCustomValidity('');
        }
    }

    password.onchange = validatePassword;
    confirm_password.onkeyup = validatePassword;
</script>

<?php if ($errorGeneral !== ""): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: "Error en el registro",
                text: "<?= $errorGeneral ?>",
                icon: "error",
                confirmButtonColor: "#272727"
            });
        });
    </script>
<?php endif; ?>

<?php if ($resEnviarCorreo): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: "¡Registro Exitoso!",
                text: "Revisa tu correo para validar tu usuario antes de iniciar sesión.",
                icon: "success",
                confirmButtonColor: "#272727"
            }).then(function () {
                window.location = "login.php";
            });
        });
    </script>
<?php endif; ?>

<?php
include '../resources/templates/footer.php';
?>