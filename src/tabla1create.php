<?php
    $mbd = include './includes/conexion.php';

    header('Content-type:application/json;charset=utf-8');
    // Ejecución de la consulta
    try 
    {    
        // Creamos una sentencia preparada
        $statement = $mbd->prepare("INSERT INTO productos (nombre, descripcion, precio) VALUES (:nom, :dsc, :prc)");

        // Asociamos los parametros de la consulta a las variables de los datos
        $statement->bindParam(':nom', $nombre);
        $statement->bindParam(':dsc', $descripcion);
        $statement->bindParam(':prc', $precio);

        // Asignamos los datos de las variables
        $nombre      = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $precio      = $_POST['precio'];

        // Insertar
        if ($statement->execute()){
            $statement = $mbd->prepare("SELECT * FROM productos WHERE id=LAST_INSERT_ID()");
            $statement->execute();

            $salida = $statement->fetch(PDO::FETCH_ASSOC);
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
                'codigo' =>$e->getCode() ,
                'mensaje' => $e->getMessage()
            ]
        ]);
    }
?>

