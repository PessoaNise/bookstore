<?php

include_once 'Conexion.php';

class ItemPedidoDB {

    public static function insertaOrden($idOrden, $idLibro, $cantidad) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'INSERT INTO item_pedido (fk_orden, fk_libro, cantidad) VALUES (?,?,?)';
            $stmt = $dbh->prepare($consulta);
            $stmt->bindParam(1, $idOrden);
            $stmt->bindParam(2, $idLibro);
            $stmt->bindParam(3, $cantidad);
            $resultado = $stmt->execute();
            $dbh = null;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }

    public static function getDatosItemsOrdenPorIdOrden($idOrden) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT io.*, l.titulo, l.autor, l.precio_venta, i.nombre_archivo  
                FROM item_pedido io
                JOIN pedido o ON o.id = io.fk_orden 
                JOIN libro l ON l.id = io.fk_libro 
                JOIN imagen i ON i.id = l.fk_imagen 
                WHERE o.id = ?';
            $stmt = $dbh->prepare($consulta);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->bindParam(1, $idOrden);
            $stmt->execute();
            $resultado = $stmt->fetchAll();
            $dbh = null;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }

}
