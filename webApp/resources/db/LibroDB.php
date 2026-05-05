<?php

include_once 'Conexion.php';

class LibroDB {

    public static function insertaLibro($arreglo, $idImagen) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'INSERT INTO libro 
                        (isbn, titulo, autor, editorial, descripcion, paginas, anio_publicacion, existencia, precio_compra, precio_venta, estado, creado, fk_categoria, fk_imagen) 
                        VALUES (?,?,?,?,?,?,?,?,?,?,?,now(),?,?)';
            $stmt = $dbh->prepare($consulta);
            $stmt->bindParam(1, $arreglo['isbn']);
            $stmt->bindParam(2, $arreglo['titulo']);
            $stmt->bindParam(3, $arreglo['autor']);
            $stmt->bindParam(4, $arreglo['editorial']);
            $stmt->bindParam(5, $arreglo['descripcion']);
            $stmt->bindParam(6, $arreglo['paginas']);
            $stmt->bindParam(7, $arreglo['anioPublicacion']);
            $stmt->bindParam(8, $arreglo['existencia']);
            $stmt->bindParam(9, $arreglo['precioCompra']);
            $stmt->bindParam(10, $arreglo['precioVenta']);
            $stmt->bindParam(11, $arreglo['checkActivo']);
            $stmt->bindParam(12, $arreglo['categoria']);
            $stmt->bindParam(13, $idImagen);
            
            $renglones = $stmt->execute();
            $dbh = null;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        if (isset($renglones)) {
            return $renglones;
        }
    }

    public static function getLibros() {
    $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT l.id, isbn, titulo, autor, editorial, descripcion, paginas, anio_publicacion, existencia, precio_compra, precio_venta, estado, creado, modificado,
                c.categoria as categoria, i.nombre_archivo as imagen 
                FROM libro l JOIN categoria c ON c.id = l.fk_categoria
                             JOIN imagen i ON i.id = l.fk_imagen
                ORDER BY titulo ASC';
            $stmt = $dbh->prepare($consulta);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $libros = $stmt->fetchAll();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $libros;
    }

    public static function getLibroPorId($id) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT l.id, isbn, titulo, autor, editorial, descripcion, paginas, anio_publicacion, existencia, precio_compra, precio_venta, estado, creado, modificado, l.fk_categoria,
                c.categoria as categoria, i.nombre_archivo as imagen 
                FROM libro l JOIN categoria c ON c.id = l.fk_categoria
                             JOIN imagen i ON i.id = l.fk_imagen
                WHERE l.id=?';
            $stmt = $dbh->prepare($consulta);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->bindValue(1, $id);
            $stmt->execute();
            $libro = $stmt->fetch();
            $dbh = null; // cierra la conexion
        } catch (PDOException $e) {
            echo $e->getMessage();
            }
        return $libro;
    }

public static function modificaLibroSinImagen($arreglo) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'UPDATE libro 
                SET isbn=?, titulo=?, autor=?, editorial=?, descripcion=?, paginas=?, anio_publicacion=?, existencia=?, precio_compra=?, precio_venta=?, estado=?, fk_categoria=?, modificado=now()
                WHERE id=?';
            $stmt = $dbh->prepare($consulta);
            $stmt->bindParam(1, $arreglo['isbn']);
            $stmt->bindParam(2, $arreglo['titulo']);
            $stmt->bindParam(3, $arreglo['autor']);
            $stmt->bindParam(4, $arreglo['editorial']);
            $stmt->bindParam(5, $arreglo['descripcion']);
            $stmt->bindParam(6, $arreglo['paginas']);
            $stmt->bindParam(7, $arreglo['anioPublicacion']);
            $stmt->bindParam(8, $arreglo['existencia']);
            $stmt->bindParam(9, $arreglo['precioCompra']);
            $stmt->bindParam(10, $arreglo['precioVenta']);
            $stmt->bindParam(11, $arreglo['checkActivo']); 
            $stmt->bindParam(12, $arreglo['categoria']);   
            $stmt->bindParam(13, $arreglo['id']);
            $renglones = $stmt->execute();
            $dbh = null; 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        if (isset($renglones)) {
            return $renglones;
        }
    }

    public static function modificaLibroConImagen($arreglo, $idImagen) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'UPDATE libro 
                SET isbn=?, titulo=?, autor=?, editorial=?, descripcion=?, paginas=?, anio_publicacion=?, existencia=?, precio_compra=?, precio_venta=?, estado=?, fk_categoria=?, fk_imagen=?, modificado=now()
                WHERE id=?';
            $stmt = $dbh->prepare($consulta);
            $stmt->bindParam(1, $arreglo['isbn']);
            $stmt->bindParam(2, $arreglo['titulo']);
            $stmt->bindParam(3, $arreglo['autor']);
            $stmt->bindParam(4, $arreglo['editorial']);
            $stmt->bindParam(5, $arreglo['descripcion']);
            $stmt->bindParam(6, $arreglo['paginas']);
            $stmt->bindParam(7, $arreglo['anioPublicacion']);
            $stmt->bindParam(8, $arreglo['existencia']);
            $stmt->bindParam(9, $arreglo['precioCompra']);
            $stmt->bindParam(10, $arreglo['precioVenta']);
            $stmt->bindParam(11, $arreglo['checkActivo']); 
            $stmt->bindParam(12, $arreglo['categoria']);   
            $stmt->bindParam(13, $idImagen);               
            $stmt->bindParam(14, $arreglo['id']);
            $renglones = $stmt->execute();
            $dbh = null; 
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        if (isset($renglones)) {
            return $renglones;
        }
    }

    public static function existeIsbn($isbn) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT COUNT(*) FROM libro WHERE isbn = ?';
            $stmt = $dbh->prepare($consulta);
            $stmt->bindParam(1, $isbn);
            $stmt->execute();
            $existe = $stmt->fetchColumn();
            $dbh = null;
            return $existe > 0;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function getLibrosPorCategoriaId($idCategoria) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT l.id, isbn, titulo, autor, editorial, descripcion, paginas, anio_publicacion, existencia, precio_compra, precio_venta, estado, creado, modificado,
                c.categoria as categoria, i.nombre_archivo as imagen 
                FROM libro l JOIN categoria c ON c.id = l.fk_categoria
                             JOIN imagen i ON i.id = l.fk_imagen
                WHERE c.id = ?
                ORDER BY titulo ASC';
            $stmt = $dbh->prepare($consulta);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->bindParam(1, $idCategoria);
            $stmt->execute();
            $libros = $stmt->fetchAll();
            $dbh = null;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $libros;
    }
        
    public static function getLibrosAleatorios($cant) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'SELECT l.id, isbn, titulo, autor, editorial, descripcion, paginas, anio_publicacion, existencia, precio_compra, precio_venta, estado, l.creado, l.modificado,
                        c.categoria as categoria, i.nombre_archivo as imagen 
                        FROM libro l 
                        JOIN categoria c ON c.id = l.fk_categoria 
                        JOIN imagen i ON i.id = l.fk_imagen 
                        ORDER BY RAND() LIMIT ?';
                
            $stmt = $dbh->prepare($consulta);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
                
            // Es vital forzar el tipo a entero para que LIMIT funcione correctamente en PDO
            $stmt->bindValue(1, (int)$cant, PDO::PARAM_INT);
            $stmt->execute();
                
            $libros = $stmt->fetchAll();
            $dbh = null; 
                
            return $libros;
                
        } catch (PDOException $e) {
            print($e->getMessage());
            return array();
        }
    }

    public static function decrementaExistencia($idLibro, $cantidad) {
        $conexion = Conexion::getInstancia();
        $dbh = $conexion->getDbh();
        try {
            $consulta = 'UPDATE libro SET existencia = existencia - ? WHERE id = ? AND existencia >= ?';
            $stmt = $dbh->prepare($consulta);
            $stmt->bindParam(1, $cantidad);
            $stmt->bindParam(2, $idLibro);
            $stmt->bindParam(3, $cantidad);
            $resultado = $stmt->execute();
            $dbh = null;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
        return $resultado;
    }
    
}