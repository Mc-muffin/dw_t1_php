<?php
    $mbd = include './includes/conexion.php';

    header('Content-type:application/json;charset=utf-8');
    // Ejecución de la consulta
    try 
    {    
        // Asignamos los datos de las variables
        $id = $_POST['id'];
        
        $statement = $mbd->prepare("SELECT * FROM productos WHERE id = :id");
        $statement->bindParam(':id', $id);
        $statement->execute();

        $prod = $statement->fetch(PDO::FETCH_ASSOC);
        
        // Creamos una sentencia preparada
        $statement = $mbd->prepare("DELETE FROM productos WHERE id = :id");
        $statement->bindParam(':id', $id);
        $statement->execute();

        $salida = [
            "mensaje" => "Producto eliminado satisfactoriamente",
            "data"    => $prod,
        ];
        
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

