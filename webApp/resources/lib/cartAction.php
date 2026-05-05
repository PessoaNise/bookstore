<?php

include '../db/LibroDB.php';
include '../db/PedidoDB.php';
include '../db/ItemPedidoDB.php';

require_once '../db/CarroDB.php';
$cart = new Cart;

$redirectURL = '../../public/cliente_vista.php';

// Process request based on the specified action
if (isset($_REQUEST['action']) && !empty($_REQUEST['action'])) {
    if ($_REQUEST['action'] == 'addToCart' && !empty($_REQUEST['id'])) {
        $libro_id = $_REQUEST['id'];

        $libro = LibroDB::getLibroPorId($libro_id);

        // Verificar que hay existencia disponible
        if ($libro['existencia'] <= 0) {
            $redirectURL = '../../public/vista_previa.php?id=' . $libro_id . '&error=sinstock';
            header("Location: $redirectURL");
            exit();
        }

        // Verificar que no se exceda la existencia con lo que ya hay en el carrito
        $rowid = md5($libro_id);
        $existingItem = $cart->get_item($rowid);
        $currentQtyInCart = $existingItem ? (int)$existingItem['qty'] : 0;

        if (($currentQtyInCart + 1) > $libro['existencia']) {
            $redirectURL = '../../public/carro_ver.php?error=maxstock';
            header("Location: $redirectURL");
            exit();
        }

        $itemData = array(
            'id' => $libro['id'],
            'image' => $libro['imagen'],
            'name' => $libro['titulo'],
            'price' => $libro['precio_venta'],
            'qty' => 1
        );

        // Insert item to cart
        $insertItem = $cart->insert($itemData);

        // Redirect to cart page
        $redirectURL = $insertItem ? '../../public/carro_ver.php' : '../../public/cliente_vista.php';
    } elseif ($_REQUEST['action'] == 'updateCartItem' && !empty($_REQUEST['id'])) {
        $newQty = (int)$_REQUEST['qty'];

        // Obtener el item actual del carrito para verificar stock
        $currentItem = $cart->get_item($_REQUEST['id']);
        if ($currentItem) {
            $libro = LibroDB::getLibroPorId($currentItem['id']);
            if ($libro && $newQty > $libro['existencia']) {
                echo 'maxstock';
                die;
            }
        }

        // Update item data in cart
        $itemData = array(
            'rowid' => $_REQUEST['id'],
            'qty' => $newQty
        );
        $updateItem = $cart->update($itemData);

        // Return status
        echo $updateItem ? 'ok' : 'err';
        die;
    } elseif ($_REQUEST['action'] == 'removeCartItem' && !empty($_REQUEST['id'])) {
        // Remove item from cart
        $deleteItem = $cart->remove($_REQUEST['id']);

        // Redirect to cart page
        $redirectURL = '../../public/carro_ver.php';
    } elseif ($_REQUEST['action'] == 'placeOrder' && $cart->total_items() > 0) {
        $redirectURL = '../../public/orden_pago.php';

        // Store post data
        $_SESSION['postData'] = $_POST;

        $resInsertaOrden = PedidoDB::insertaOrden($_SESSION['id_usuario'], $cart->total());

        if ($resInsertaOrden) {
            $ordenId = PedidoDB::getUltimaIdInsertada();

            // Retrieve cart items
            $cartItems = $cart->contents();

            // Insert order items and decrement stock
            if (!empty($cartItems)) {
                foreach ($cartItems as $item) {
                    ItemPedidoDB::insertaOrden($ordenId, $item['id'], $item['qty']);
                    // Descontar existencia
                    LibroDB::decrementaExistencia($item['id'], $item['qty']);
                }

                // Remove all items from cart
                $cart->destroy();

                // Redirect to the status page
                $redirectURL = '../../public/pago_validacion.php?id=' . base64_encode($ordenId);
            } else {
                $sessData['status']['type'] = 'error';
                $sessData['status']['msg'] = 'Algo salió mal, por favor intenta de nuevo.';
            }
        } else {
            $sessData['status']['type'] = 'error';
            $sessData['status']['msg'] = 'Algo salió mal, por favor intenta de nuevo.';
        }
    }
}

// Redirect to the specific page
header("Location: $redirectURL");
exit();
