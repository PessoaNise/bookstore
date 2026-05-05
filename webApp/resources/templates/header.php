    <div id="preloader" class="preloader-container">
      <div class="book">
        <div class="inner">
          <div class="left"></div>
          <div class="middle"></div>
          <div class="right"></div>
        </div>
        <ul>
          <li></li><li></li><li></li><li></li><li></li><li></li>
          <li></li><li></li><li></li><li></li><li></li><li></li>
          <li></li><li></li><li></li><li></li><li></li><li></li>
        </ul>
      </div>
    </div>

    <div class="search-popup">
      <div class="search-popup-container">

        <form role="search" method="get" class="search-form" action="">
          <input type="search" id="search-form" class="search-field" placeholder="Escribe y presiona enter" value=""
            name="s" />
          <button type="submit" class="search-submit"><svg class="search">
              <use xlink:href="#search"></use>
            </svg></button>
        </form>

        <h5 class="cat-list-title">Buscar por Categorías</h5>

        <ul class="cat-list">
          <?php
          include_once(__DIR__ . '/../db/CategoriaDB.php');
          $categoriasList = CategoriaDB::getCategorias();
          foreach ($categoriasList as $cat): ?>
            <li class="cat-list-item">
              <a href="<?php isset($_SESSION['usuario']) 
                ? print('libros_usuario_muestra.php?id='.$cat['id'].'&palabra=') 
                : print('libros_visitante_muestra.php?id='.$cat['id'].'&palabra=') ?>" 
                title="<?= $cat['categoria'] ?>"><?= $cat['categoria'] ?></a>
            </li>
          <?php endforeach; ?>
        </ul>

      </div>
    </div>

    <header id="header" class="site-header">

      <div class="top-info border-bottom d-none d-md-block ">
        <div class="container-fluid">
          <div class="row g-0">
            <div class="col-md-4">
              <p class="fs-6 my-2 text-center">¿Necesitas ayuda? Llámanos <a href="#">112233344455</a></p>
            </div>
            <div class="col-md-4 border-start border-end">
              <p class="fs-6 my-2 text-center">¡Descuento de verano del 60%! <a class="text-decoration-underline"
                  href="index.php">Comprar Ahora</a></p>
            </div>
            <div class="col-md-4">
              <p class="fs-6 my-2 text-center">Entrega en 2-3 días hábiles y devoluciones gratis</p>
            </div>
          </div>
        </div>
      </div>

      <nav id="header-nav" class="navbar navbar-expand-lg py-3">
        <div class="container">
          <a class="navbar-brand" href="index.php">
            <img src="assets/img/main-logo.png" class="logo">
          </a>
          <button class="navbar-toggler d-flex d-lg-none order-3 p-2" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#bdNavbar" aria-controls="bdNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <svg class="navbar-icon">
              <use xlink:href="#navbar-icon"></use>
            </svg>
          </button>
          <div class="offcanvas offcanvas-end" tabindex="-1" id="bdNavbar" aria-labelledby="bdNavbarOffcanvasLabel">
            <div class="offcanvas-header px-4 pb-0">
              <a class="navbar-brand" href="index.php">
                <img src="assets/img/main-logo.png" class="logo">
              </a>
              <button type="button" class="btn-close btn-close-black" data-bs-dismiss="offcanvas" aria-label="Close"
                data-bs-target="#bdNavbar"></button>
            </div>
            <div class="offcanvas-body">
              <ul id="navbar"
                class="navbar-nav text-uppercase justify-content-start justify-content-lg-center align-items-start align-items-lg-center flex-grow-1">
                <li class="nav-item">
                  <a class="nav-link me-4 active" href="index.php">Inicio</a>
                </li>
                <?php if (isset($_SESSION['usuario']) && isset($_SESSION['tipo_usuario'])): ?>
                  <?php if ($_SESSION['tipo_usuario'] == 'administrador'): ?>
                    <li class="nav-item">
                      <a class="nav-link me-4" href="libros_ver.php">Inventario</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link me-4" href="libro_registrar.php">Registrar Libro</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link me-4" href="pedidos_ver.php">Pedidos</a>
                    </li>
                  <?php else: ?>
                    <li class="nav-item">
                      <a class="nav-link me-4" href="cliente_vista.php">Tienda</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link me-4" href="cliente_ver_pedidos.php">Mis Pedidos</a>
                    </li>
                  <?php endif; ?>
                  <li class="nav-item">
                    <a class="nav-link me-4" href="logout.php">Salir</a>
                  </li>
                <?php else: ?>
                  <li class="nav-item">
                    <a class="nav-link me-4" href="login.php">Acceder</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link me-4" href="usuario_registro.php">Registrarse</a>
                  </li>
                <?php endif; ?>
              </ul>
              <div class="user-items d-flex">
                <ul class="d-flex justify-content-end list-unstyled mb-0">
                  <li class="search-item pe-3">
                    <a href="#" class="search-button">
                      <svg class="search">
                        <use xlink:href="#search"></use>
                      </svg>
                    </a>
                  </li>
                  <li class="pe-3">
                    <?php if (isset($_SESSION['usuario'])): ?>
                      <a href="#" title="<?= $_SESSION['usuario'] ?>">
                        <svg class="user">
                          <use xlink:href="#user"></use>
                        </svg>
                      </a>
                    <?php else: ?>
                      <a href="login.php">
                        <svg class="user">
                          <use xlink:href="#user"></use>
                        </svg>
                      </a>
                    <?php endif; ?>
                  </li>
                  <li class="cart-dropdown dropdown">
                    <a href="<?php !isset($_SESSION['usuario']) ? print('login.php') : print('carro_ver.php') ?>">
                      <svg class="cart">
                        <use xlink:href="#cart"></use>
                      </svg>
                      <?php
                      if (isset($_SESSION['usuario'])):
                          include_once __DIR__ . '/../db/CarroDB.php';
                          $cartHeader = new Cart;
                      ?>
                        <span class="fs-6 fw-light">(<?= $cartHeader->total_items() ?>)</span>
                      <?php endif; ?>
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </nav>

    </header>