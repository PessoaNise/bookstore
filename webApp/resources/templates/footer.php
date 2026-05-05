    <footer id="footer" class="padding-large">
      <div class="container">
        <div class="row">
          <div class="footer-top-area">
            <div class="row d-flex flex-wrap justify-content-between">
              <div class="col-lg-3 col-sm-6 pb-3">
                <div class="footer-menu">
                  <img src="assets/img/main-logo.png" alt="logo" class="img-fluid mb-2">
                  <p>Tu librería de confianza con los mejores títulos y las mejores ofertas para lectores apasionados.</p>
                  <div class="social-links">
                    <ul class="d-flex list-unstyled">
                      <li>
                        <a href="#">
                          <svg class="facebook">
                            <use xlink:href="#facebook" />
                          </svg>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <svg class="instagram">
                            <use xlink:href="#instagram" />
                          </svg>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <svg class="twitter">
                            <use xlink:href="#twitter" />
                          </svg>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <svg class="linkedin">
                            <use xlink:href="#linkedin" />
                          </svg>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <svg class="youtube">
                            <use xlink:href="#youtube" />
                          </svg>
                        </a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-lg-2 col-sm-6 pb-3">
                <div class="footer-menu text-capitalize">
                  <h5 class="widget-title pb-2">Enlaces Rápidos</h5>
                  <ul class="menu-list list-unstyled text-capitalize">
                    <li class="menu-item mb-1">
                      <a href="index.php">Inicio</a>
                    </li>
                    <li class="menu-item mb-1">
                      <a href="login.php">Acceder</a>
                    </li>
                    <li class="menu-item mb-1">
                      <a href="usuario_registro.php">Registrarse</a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="col-lg-3 col-sm-6 pb-3">
                <div class="footer-menu text-capitalize">
                  <h5 class="widget-title pb-2">Ayuda e Info</h5>
                  <ul class="menu-list list-unstyled">
                    <li class="menu-item mb-1">
                      <a href="#">Rastrear tu Orden</a>
                    </li>
                    <li class="menu-item mb-1">
                      <a href="#">Políticas de Devolución</a>
                    </li>
                    <li class="menu-item mb-1">
                      <a href="#">Envío y Entrega</a>
                    </li>
                    <li class="menu-item mb-1">
                      <a href="#">Contáctanos</a>
                    </li>
                    <li class="menu-item mb-1">
                      <a href="#">FAQs</a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="col-lg-3 col-sm-6 pb-3">
                <div class="footer-menu contact-item">
                  <h5 class="widget-title text-capitalize pb-2">Contáctanos</h5>
                  <p>¿Tienes alguna consulta o sugerencia? <a href="mailto:"
                      class="text-decoration-underline">info@libreriapessoa.com</a></p>
                  <p>Si necesitas soporte, llámanos. <a href="#" class="text-decoration-underline">+55 111 222
                      333 44</a></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </footer>
    <hr>
    <div id="footer-bottom" class="mb-2">
      <div class="container">
        <div class="d-flex flex-wrap justify-content-between">
          <div class="ship-and-payment d-flex gap-md-5 flex-wrap">
            <div class="shipping d-flex">
              <p>Enviamos con:</p>
              <div class="card-wrap ps-2">
                <img src="assets/img/dhl.png" alt="dhl">
                <img src="assets/img/shippingcard.png" alt="shipping">
              </div>
            </div>
            <div class="payment-method d-flex">
              <p>Opciones de pago:</p>
              <div class="card-wrap ps-2">
                <img src="assets/img/visa.jpg" alt="visa">
                <img src="assets/img/mastercard.jpg" alt="mastercard">
                <img src="assets/img/paypal.jpg" alt="paypal">
              </div>
            </div>
          </div>
          <div class="copyright">
            <p>© Copyright 2024 Librería Pessoa. Template by <a href="https://templatesjungle.com/"
                target="_blank">TemplatesJungle</a>
            </p>
          </div>
        </div>
      </div>
    </div>

    <script src="js/jquery-1.11.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="js/script.js"></script>

    <script>
      // Funciones de búsqueda
      function buscarLogeado() {
          let palabra = document.getElementById('search-form') ? document.getElementById('search-form').value : '';
          document.location.href = 'libros_usuario_muestra.php?id=0&palabra=' + palabra;
      }

      function buscarNoLogeado() {
          let palabra = document.getElementById('search-form') ? document.getElementById('search-form').value : '';
          document.location.href = 'libros_visitante_muestra.php?id=0&palabra=' + palabra;
      }

      // Override search form submission
      document.addEventListener('DOMContentLoaded', function() {
          var searchForm = document.querySelector('.search-form');
          if (searchForm) {
              searchForm.addEventListener('submit', function(e) {
                  e.preventDefault();
                  <?php if (isset($_SESSION['usuario'])): ?>
                    buscarLogeado();
                  <?php else: ?>
                    buscarNoLogeado();
                  <?php endif; ?>
              });
          }
      });
    </script>
  </body>
</html>