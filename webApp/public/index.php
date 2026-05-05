<?php 
session_start();
$PageTitle = "Librería Pessoa - Inicio";
require_once '../resources/templates/head.php';
include_once '../resources/db/LibroDB.php';
include_once '../resources/db/CategoriaDB.php';

// Obtener datos para el index
$librosBillboard = LibroDB::getLibrosAleatorios(3);
$librosMasVendidos = LibroDB::getLibrosAleatorios(6);
$libroOferta = LibroDB::getLibrosAleatorios(1)[0];
$categoriasIndex = CategoriaDB::getCategorias();

// Segmentar 12 libros para las 4 listas (3 cada una)
$librosListas = LibroDB::getLibrosAleatorios(12);
$librosFeatured = array_slice($librosListas, 0, 3);
$librosLatest = array_slice($librosListas, 3, 3);
$librosReviewed = array_slice($librosListas, 6, 3);
$librosSale = array_slice($librosListas, 9, 3);
?>
  <style>
    /* Ajuste para imágenes no uniformes */
    .card img, .swiper-slide img, .item img {
      height: 300px;
      object-fit: contain;
      background-color: #f8f9fa;
      border-radius: 8px;
    }
    .item img {
      height: 120px;
      width: 80px;
    }
    .banner-content h2 {
      font-weight: 800;
      color: #272727;
    }
  </style>
  <body>
    <?php
    require_once '../resources/templates/svg-icons.php';
    require_once '../resources/templates/header.php';
    ?>

    <section id="billboard" class="position-relative d-flex align-items-center py-5 bg-light-gray"
      style="background-image: url(assets/img/banner-image-bg.jpg); background-size: cover; background-repeat: no-repeat; background-position: center; height: 800px;">
      <div class="position-absolute end-0 pe-0 pe-xxl-5 me-0 me-xxl-5 swiper-next main-slider-button-next">
        <svg class="chevron-forward-circle d-flex justify-content-center align-items-center p-2" width="80" height="80">
          <use xlink:href="#alt-arrow-right-outline"></use>
        </svg>
      </div>
      <div class="position-absolute start-0 ps-0 ps-xxl-5 ms-0 ms-xxl-5 swiper-prev main-slider-button-prev">
        <svg class="chevron-back-circle d-flex justify-content-center align-items-center p-2" width="80" height="80">
          <use xlink:href="#alt-arrow-left-outline"></use>
        </svg>
      </div>
      <div class="swiper main-swiper">
        <div class="swiper-wrapper d-flex align-items-center">
          
          <?php 
          $esloganes = [
            ["title" => "Tu Próximo Tesoro Literario", "subtitle" => "Explora nuestra colección curada con pasión."],
            ["title" => "Donde las Historias Cobran Vida", "subtitle" => "Descubre mundos nuevos en cada estante digital."],
            ["title" => "El Placer de una Buena Lectura", "subtitle" => "Encuentra ese libro que no podrás soltar."]
          ];
          foreach($librosBillboard as $i => $libro): ?>
          <div class="swiper-slide">
            <div class="container">
              <div class="row d-flex flex-column-reverse flex-md-row align-items-center">
                <div class="col-md-5 offset-md-1 mt-5 mt-md-0 text-center text-md-start">
                  <div class="banner-content">
                    <h2><?= $esloganes[$i]['title'] ?></h2>
                    <p><?= $esloganes[$i]['subtitle'] ?></p>
                    <p class="fs-5 text-primary">Destacado: <strong><?= $libro['titulo'] ?></strong></p>
                    <a href="vista_previa.php?id=<?= $libro['id'] ?>" class="btn mt-3">Ver Libro</a>
                  </div>
                </div>
                <div class="col-md-6 text-center">
                  <div class="image-holder">
                    <img src="../resources/uploads/<?= $libro['imagen'] ?>" class="img-fluid" alt="banner" style="max-height: 500px; width: auto; object-fit: contain;">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>

        </div>
      </div>
    </section>

    <section id="company-services" class="padding-large pb-0">
      <div class="container">
        <div class="row">
          <div class="col-lg-3 col-md-6 pb-3 pb-lg-0">
            <div class="icon-box d-flex">
              <div class="icon-box-icon pe-3 pb-3">
                <svg class="cart-outline">
                  <use xlink:href="#cart-outline" />
                </svg>
              </div>
              <div class="icon-box-content">
                <h4 class="card-title mb-1 text-capitalize text-dark">Entrega Gratis</h4>
                <p>En pedidos superiores a $500 dentro de la ciudad.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 pb-3 pb-lg-0">
            <div class="icon-box d-flex">
              <div class="icon-box-icon pe-3 pb-3">
                <svg class="quality">
                  <use xlink:href="#quality" />
                </svg>
              </div>
              <div class="icon-box-content">
                <h4 class="card-title mb-1 text-capitalize text-dark">Calidad Garantizada</h4>
                <p>Libros en excelente estado y ediciones originales.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 pb-3 pb-lg-0">
            <div class="icon-box d-flex">
              <div class="icon-box-icon pe-3 pb-3">
                <svg class="price-tag">
                  <use xlink:href="#price-tag" />
                </svg>
              </div>
              <div class="icon-box-content">
                <h4 class="card-title mb-1 text-capitalize text-dark">Ofertas Diarias</h4>
                <p>Descuentos especiales todos los días en títulos seleccionados.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-3 col-md-6 pb-3 pb-lg-0">
            <div class="icon-box d-flex">
              <div class="icon-box-icon pe-3 pb-3">
                <svg class="shield-plus">
                  <use xlink:href="#shield-plus" />
                </svg>
              </div>
              <div class="icon-box-content">
                <h4 class="card-title mb-1 text-capitalize text-dark">Pagos 100% Seguros</h4>
                <p>Tus transacciones están protegidas con encriptación SSL.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="best-selling-items" class="position-relative padding-large ">
      <div class="container">
        <div class="section-title d-md-flex justify-content-between align-items-center mb-4">
          <h3 class="d-flex align-items-center">Más Vendidos</h3>
          <a href="libros_visitante_muestra.php?id=0&palabra=" class="btn">Ver Todo</a>
        </div>
        <div class="position-absolute top-50 end-0 pe-0 pe-xxl-5 me-0 me-xxl-5 swiper-next product-slider-button-next">
          <svg class="chevron-forward-circle d-flex justify-content-center align-items-center p-2" width="80" height="80">
            <use xlink:href="#alt-arrow-right-outline"></use>
          </svg>
        </div>
        <div class="position-absolute top-50 start-0 ps-0 ps-xxl-5 ms-0 ms-xxl-5 swiper-prev product-slider-button-prev">
          <svg class="chevron-back-circle d-flex justify-content-center align-items-center p-2" width="80" height="80">
            <use xlink:href="#alt-arrow-left-outline"></use>
          </svg>
        </div>
        <div class="swiper product-swiper">
          <div class="swiper-wrapper">
            
            <?php foreach($librosMasVendidos as $libro): ?>
            <div class="swiper-slide">
              <div class="card position-relative p-4 border rounded-3 h-100">
                <a href="vista_previa.php?id=<?= $libro['id'] ?>">
                    <img src="../resources/uploads/<?= $libro['imagen'] ?>" class="img-fluid shadow-sm" alt="<?= $libro['titulo'] ?>">
                </a>
                <h6 class="mt-4 mb-0 fw-bold">
                    <a href="vista_previa.php?id=<?= $libro['id'] ?>"><?= $libro['titulo'] ?></a>
                </h6>
                <div class="review-content d-flex">
                  <p class="my-2 me-2 fs-6 text-black-50"><?= $libro['autor'] ?></p>
                  <div class="rating text-warning d-flex align-items-center">
                    <svg class="star star-fill"><use xlink:href="#star-fill"></use></svg>
                    <svg class="star star-fill"><use xlink:href="#star-fill"></use></svg>
                    <svg class="star star-fill"><use xlink:href="#star-fill"></use></svg>
                    <svg class="star star-fill"><use xlink:href="#star-fill"></use></svg>
                    <svg class="star star-fill"><use xlink:href="#star-fill"></use></svg>
                  </div>
                </div>
                <span class="price text-primary fw-bold mb-2 fs-5">$<?= $libro['precio_venta'] ?></span>
                <div class="card-concern position-absolute start-0 end-0 d-flex gap-2">
                  <a href="../resources/lib/cartAction.php?action=addToCart&id=<?= $libro['id'] ?>" class="btn btn-dark" title="Añadir al carrito">
                    <svg class="cart"><use xlink:href="#cart"></use></svg>
                  </a>
                </div>
              </div>
            </div>
            <?php endforeach; ?>

          </div>
        </div>
      </div>
    </section>

    <section id="limited-offer" class="padding-large"
      style="background-image: url(assets/img/banner-image-bg-1.jpg); background-size: cover; background-repeat: no-repeat; background-position: center; height: 800px;">
      <div class="container">
        <div class="row d-flex align-items-center">
          <div class="col-md-6 text-center">
            <div class="image-holder">
              <img src="../resources/uploads/<?= $libroOferta['imagen'] ?>" class="img-fluid rounded-3 shadow-lg" alt="oferta" style="max-height: 500px;">
            </div>
          </div>
          <div class="col-md-5 offset-md-1 mt-5 mt-md-0 text-center text-md-start">
            <h2 class="display-4 fw-bold">Oferta Especial: 30% de Descuento</h2>
            <p class="fs-4 text-dark mb-4">Llévate hoy <strong><?= $libroOferta['titulo'] ?></strong> de <?= $libroOferta['autor'] ?> a un precio irrepetible.</p>
            <div id="countdown-clock" class="text-dark d-flex align-items-center my-3 justify-content-center justify-content-md-start">
              <div class="time d-grid pe-3">
                <span class="days fs-1 fw-bold"></span>
                <small>Días</small>
              </div>
              <span class="fs-1 text-primary">:</span>
              <div class="time d-grid pe-3 ps-3">
                <span class="hours fs-1 fw-bold"></span>
                <small>Hrs</small>
              </div>
              <span class="fs-1 text-primary">:</span>
              <div class="time d-grid pe-3 ps-3">
                <span class="minutes fs-1 fw-bold"></span>
                <small>Min</small>
              </div>
              <span class="fs-1 text-primary">:</span>
              <div class="time d-grid ps-3">
                <span class="seconds fs-1 fw-bold"></span>
                <small>Seg</small>
              </div>
            </div>
            <a href="vista_previa.php?id=<?= $libroOferta['id'] ?>" class="btn btn-dark btn-lg mt-3 px-5">¡Comprar Ahora!</a>
          </div>
        </div>
      </div>
    </section>

    <section id="items-listing" class="padding-large">
      <div class="container">
        <div class="row">
          
          <?php 
          $secciones = [
            ["titulo" => "Destacados", "data" => $librosFeatured],
            ["titulo" => "Novedades", "data" => $librosLatest],
            ["titulo" => "Mejor Valorados", "data" => $librosReviewed],
            ["titulo" => "En Oferta", "data" => $librosSale]
          ];
          foreach($secciones as $sec): ?>
          <div class="col-md-6 mb-4 mb-lg-0 col-lg-3">
            <div class="featured border rounded-3 p-4 h-100">
              <div class="section-title overflow-hidden mb-5 mt-2">
                <h3 class="d-flex flex-column mb-0"><?= $sec['titulo'] ?></h3>
              </div>
              <div class="items-lists">
                <?php foreach($sec['data'] as $libro): ?>
                <div class="item d-flex mb-3">
                  <a href="vista_previa.php?id=<?= $libro['id'] ?>">
                    <img src="../resources/uploads/<?= $libro['imagen'] ?>" class="img-fluid shadow-sm" alt="libro">
                  </a>
                  <div class="item-content ms-3">
                    <h6 class="mb-0 fw-bold"><a href="vista_previa.php?id=<?= $libro['id'] ?>"><?= $libro['titulo'] ?></a></h6>
                    <div class="review-content d-flex mt-1">
                      <div class="rating text-warning d-flex align-items-center">
                        <svg class="star star-fill" width="12" height="12"><use xlink:href="#star-fill"></use></svg>
                        <svg class="star star-fill" width="12" height="12"><use xlink:href="#star-fill"></use></svg>
                        <svg class="star star-fill" width="12" height="12"><use xlink:href="#star-fill"></use></svg>
                      </div>
                    </div>
                    <span class="price text-primary fw-bold mb-2 fs-5">$<?= $libro['precio_venta'] ?></span>
                  </div>
                </div>
                <hr class="gray-400">
                <?php endforeach; ?>
              </div>
            </div>
          </div>
          <?php endforeach; ?>

        </div>
      </div>
    </section>

    <section id="categories" class="padding-large pt-0">
      <div class="container">
        <div class="section-title overflow-hidden mb-4">
          <h3 class="d-flex align-items-center">Categorías</h3>
        </div>
        <div class="row">
          <?php 
          $catsMostradas = array_slice($categoriasIndex, 0, 3);
          $catImages = ["assets/img/category1.jpg", "assets/img/category2.jpg", "assets/img/category3.jpg"];
          foreach($catsMostradas as $i => $cat): ?>
          <div class="col-md-4">
            <div class="card mb-4 border-0 rounded-3 position-relative">
              <a href="libros_visitante_muestra.php?id=<?= $cat['id'] ?>&palabra=">
                <img src="<?= $catImages[$i] ?>" class="img-fluid rounded-3" alt="<?= $cat['categoria'] ?>">
                <h6 class=" position-absolute bottom-0 bg-primary m-4 py-2 px-3 rounded-3">
                  <a href="libros_visitante_muestra.php?id=<?= $cat['id'] ?>&palabra=" class="text-white"><?= $cat['categoria'] ?></a>
                </h6>
              </a>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>

    <section id="customers-reviews" class="position-relative padding-large"
      style="background-image: url(assets/img/banner-image-bg.jpg); background-size: cover; background-repeat: no-repeat; background-position: center; height: 600px;">
      <div class="container offset-md-3 col-md-6 ">
        <div class="position-absolute top-50 end-0 pe-0 pe-xxl-5 me-0 me-xxl-5 swiper-next testimonial-button-next">
          <svg class="chevron-forward-circle d-flex justify-content-center align-items-center p-2" width="80" height="80">
            <use xlink:href="#alt-arrow-right-outline"></use>
          </svg>
        </div>
        <div class="position-absolute top-50 start-0 ps-0 ps-xxl-5 ms-0 ms-xxl-5 swiper-prev testimonial-button-prev">
          <svg class="chevron-back-circle d-flex justify-content-center align-items-center p-2" width="80" height="80">
            <use xlink:href="#alt-arrow-left-outline"></use>
          </svg>
        </div>
        <div class="section-title mb-4 text-center">
          <h3 class="mb-4">Opiniones de Clientes</h3>
        </div>
        <div class="swiper testimonial-swiper ">
          <div class="swiper-wrapper">
            <div class="swiper-slide">
              <div class="card position-relative text-left p-5 border rounded-3">
                <blockquote>"Encontré esta librería por casualidad y se convirtió instantáneamente en mi lugar favorito. El ambiente acogedor, el personal amable y la gran selección de libros hacen que cada visita sea un deleite."</blockquote>
                <div class="rating text-warning d-flex align-items-center">
                  <svg class="star star-fill" width="16" height="16"><use xlink:href="#star-fill"></use></svg>
                  <svg class="star star-fill" width="16" height="16"><use xlink:href="#star-fill"></use></svg>
                  <svg class="star star-fill" width="16" height="16"><use xlink:href="#star-fill"></use></svg>
                  <svg class="star star-fill" width="16" height="16"><use xlink:href="#star-fill"></use></svg>
                  <svg class="star star-fill" width="16" height="16"><use xlink:href="#star-fill"></use></svg>
                </div>
                <h5 class="mt-1 fw-bold">Jimena Fernández</h5>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="card position-relative text-left p-5 border rounded-3">
                <blockquote>"Como lector ávido, siempre busco nuevos lanzamientos, y esta librería nunca me decepciona. ¡Siempre tienen los últimos títulos y sus recomendaciones son increíbles!"</blockquote>
                <div class="rating text-warning d-flex align-items-center">
                  <svg class="star star-fill" width="16" height="16"><use xlink:href="#star-fill"></use></svg>
                  <svg class="star star-fill" width="16" height="16"><use xlink:href="#star-fill"></use></svg>
                  <svg class="star star-fill" width="16" height="16"><use xlink:href="#star-fill"></use></svg>
                  <svg class="star star-fill" width="16" height="16"><use xlink:href="#star-fill"></use></svg>
                  <svg class="star star-fill" width="16" height="16"><use xlink:href="#star-fill"></use></svg>
                </div>
                <h5 class="mt-1 fw-bold">Tomás Juárez</h5>
              </div>
            </div>
            <div class="swiper-slide">
              <div class="card position-relative text-left p-5 border rounded-3">
                <blockquote>"Pedí varios libros en línea y me impresionó la rapidez de la entrega y el cuidado del embalaje. Está claro que priorizan la satisfacción del cliente."</blockquote>
                <div class="rating text-warning d-flex align-items-center">
                  <svg class="star star-fill" width="16" height="16"><use xlink:href="#star-fill"></use></svg>
                  <svg class="star star-fill" width="16" height="16"><use xlink:href="#star-fill"></use></svg>
                  <svg class="star star-fill" width="16" height="16"><use xlink:href="#star-fill"></use></svg>
                  <svg class="star star-fill" width="16" height="16"><use xlink:href="#star-fill"></use></svg>
                  <svg class="star star-fill" width="16" height="16"><use xlink:href="#star-fill"></use></svg>
                </div>
                <h5 class="mt-1 fw-bold">Kevin Ruiz</h5>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="latest-posts" class="padding-large">
      <div class="container">
        <div class="section-title d-md-flex justify-content-between align-items-center mb-4">
          <h3 class="d-flex align-items-center">Últimas Noticias</h3>
          <a href="#" class="btn shadow-none">Ver Todo</a>
        </div>
        <div class="row">
          <div class="col-md-3 posts mb-4">
            <img src="assets/img/post-item1.jpg" alt="post image" class="img-fluid rounded-3">
            <a href="#" class="fs-6 text-primary">Libros</a>
            <h4 class="card-title mb-2 text-capitalize text-dark"><a href="#">Los 10 Libros Imprescindibles de este Año</a></h4>
            <p class="mb-2">Sumérgete en el mundo de la literatura con nuestra selección de los mejores títulos. <span><a class="text-decoration-underline text-black-50" href="#">Leer Más</a></span>
            </p>
          </div>
          <div class="col-md-3 posts mb-4">
            <img src="assets/img/post-item2.jpg" alt="post image" class="img-fluid rounded-3">
            <a href="#" class="fs-6 text-primary">Ficción</a>
            <h4 class="card-title mb-2 text-capitalize text-dark"><a href="#">El Fascinante Reino de la Ciencia Ficción</a></h4>
            <p class="mb-2">Explora mundos imaginarios y tecnologías futuristas en nuestra última reseña. <span><a class="text-decoration-underline text-black-50" href="#">Leer Más</a></span> </p>
          </div>
          <div class="col-md-3 posts mb-4">
            <img src="assets/img/post-item3.jpg" alt="post image" class="img-fluid rounded-3">
            <a href="#" class="fs-6 text-primary">Romance</a>
            <h4 class="card-title mb-2 text-capitalize text-dark"><a href="#">Encontrando el Amor entre Páginas</a></h4>
            <p class="mb-2">Historias que te harán suspirar. Descubre lo mejor del género romántico.<span><a class="text-decoration-underline text-black-50" href="#">Leer Más</a></span>
            </p>
          </div>
          <div class="col-md-3 posts mb-4">
            <img src="assets/img/post-item4.jpg" alt="post image" class="img-fluid rounded-3">
            <a href="#" class="fs-6 text-primary">Salud Mental</a>
            <h4 class="card-title mb-2 text-capitalize text-dark"><a href="#">Lectura para la Salud Mental: Sanar e Inspirar</a></h4>
            <p class="mb-2">Cómo un buen libro puede ser tu mejor aliado en momentos difíciles. <span><a class="text-decoration-underline text-black-50" href="#">Leer Más</a></span>
            </p>
          </div>
        </div>
      </div>
    </section>

    
    <section id="instagram">
      <div class="container">
        <div class="text-center mb-4">
          <h3>Instagram</h3>
        </div>
        <div class="row">
          <div class="col-md-2">
            <figure class="instagram-item position-relative rounded-3">
              <a href="https://templatesjungle.com/" class="image-link position-relative">
                <div class="icon-overlay position-absolute d-flex justify-content-center">
                  <svg class="instagram">
                    <use xlink:href="#instagram"></use>
                  </svg>
                </div>
                <img src="assets/img/insta-item1.jpg" alt="instagram" class="img-fluid rounded-3 insta-image">
              </a>
            </figure>
          </div>
          <div class="col-md-2">
            <figure class="instagram-item position-relative rounded-3">
              <a href="https://templatesjungle.com/" class="image-link position-relative">
                <div class="icon-overlay position-absolute d-flex justify-content-center">
                  <svg class="instagram">
                    <use xlink:href="#instagram"></use>
                  </svg>
                </div>
                <img src="assets/img/insta-item2.jpg" alt="instagram" class="img-fluid rounded-3 insta-image">
              </a>
            </figure>
          </div>
          <div class="col-md-2">
            <figure class="instagram-item position-relative rounded-3">
              <a href="https://templatesjungle.com/" class="image-link position-relative">
                <div class="icon-overlay position-absolute d-flex justify-content-center">
                  <svg class="instagram">
                    <use xlink:href="#instagram"></use>
                  </svg>
                </div>
                <img src="assets/img/insta-item3.jpg" alt="instagram" class="img-fluid rounded-3 insta-image">
              </a>
            </figure>
          </div>
          <div class="col-md-2">
            <figure class="instagram-item position-relative rounded-3">
              <a href="https://templatesjungle.com/" class="image-link position-relative">
                <div class="icon-overlay position-absolute d-flex justify-content-center">
                  <svg class="instagram">
                    <use xlink:href="#instagram"></use>
                  </svg>
                </div>
                <img src="assets/img/insta-item4.jpg" alt="instagram" class="img-fluid rounded-3 insta-image">
              </a>
            </figure>
          </div>
          <div class="col-md-2">
            <figure class="instagram-item position-relative rounded-3">
              <a href="https://templatesjungle.com/" class="image-link position-relative">
                <div class="icon-overlay position-absolute d-flex justify-content-center">
                  <svg class="instagram">
                    <use xlink:href="#instagram"></use>
                  </svg>
                </div>
                <img src="assets/img/insta-item5.jpg" alt="instagram" class="img-fluid rounded-3 insta-image">
              </a>
            </figure>
          </div>
          <div class="col-md-2">
            <figure class="instagram-item position-relative rounded-3">
              <a href="https://templatesjungle.com/" class="image-link position-relative">
                <div class="icon-overlay position-absolute d-flex justify-content-center">
                  <svg class="instagram">
                    <use xlink:href="#instagram"></use>
                  </svg>
                </div>
                <img src="assets/img/insta-item6.jpg" alt="instagram" class="img-fluid rounded-3 insta-image">
              </a>
            </figure>
          </div>
        </div>
      </div>
    </section>

<?php require_once '../resources/templates/footer.php'; ?>