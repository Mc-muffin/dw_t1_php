<?php
    $mbd = include './includes/conexion.php';

    header('Content-type:application/json;charset=utf-8');
    // Ejecución de la consulta
    try 
    {    
        // Creamos una sentencia preparada
        $statement=$mbd->prepare("INSERT INTO compras (fk_id, nombres, apellidos, fecha_compra, fin_garantia, cantidad, impuesto, email) VALUES (:fk, :vc1, :vc2, :dtm, :dt, :it, :flt, :mail)");

        // Asociamos los parametros de la consulta a las variables de los datos
        $statement->bindParam(':fk',   $fk_id);
        $statement->bindParam(':vc1',  $nombres);
        $statement->bindParam(':vc2',  $apellidos);
        $statement->bindParam(':dtm',  $fecha_compra);
        $statement->bindParam(':dt',   $fin_garantia);
        $statement->bindParam(':it',   $cantidad);
        $statement->bindParam(':flt',  $impuesto);
        $statement->bindParam(':mail', $email);

        // Asignamos los datos de las variables
        $fk_id        = $_POST['fk_id'];
        $nombres      = $_POST['nombres'];
        $apellidos    = $_POST['apellidos'];
        $fecha_compra = $_POST['fecha_compra'];
        $fin_garantia = $_POST['fin_garantia'];
        $cantidad     = $_POST['cantidad'];
        $impuesto     = $_POST['impuesto'];
        $email        = $_POST['email'];

        // Insertar
        if ($statement->execute()){
            // obtener id
            $statement=$mbd->prepare("SELECT * FROM compras WHERE id = LAST_INSERT_ID()");
            $statement->execute();
            $salida = $statement->fetch(PDO::FETCH_ASSOC);

            $statement=$mbd->prepare("SELECT * FROM productos WHERE id = :fk");
            $statement->bindParam(':fk', $fk_id);
            $statement->execute();
            $salida += array("data_fk" => $statement->fetch(PDO::FETCH_ASSOC)); 
        } else {
            $salida = [ 
                "error" => [
                    "mensaje" => "Error durante la consulta",
                    "info"    => $statement->errorInfo()
                ]
            ];
        }
        
        // Retornamos resultados  
        echo json_encode($salida);

    } catch (PDOException $e) {    
        echo json_encode([
            'error' => [
                'codigo'  => $e->getCode(),
                'mensaje' => $e->getMessage()
            ]
        ]);
    }
?>

