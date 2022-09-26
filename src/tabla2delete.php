<?php
    $mbd = include './includes/conexion.php';

    header('Content-type:application/json;charset=utf-8');
    // Ejecución de la consulta
    try 
    {    
        // Asignamos los datos de las variables
        $id = $_POST['id'];
        
        $statement = $mbd->prepare("SELECT * FROM compras WHERE id = :id");
        $statement->bindParam(':id', $id);
        $statement->execute();
    
        $registro = $statement->fetch(PDO::FETCH_ASSOC);

        $statement = $mbd->prepare("SELECT * FROM productos WHERE id = :fk");
        $statement->bindParam(':fk', $registro["fk_id"]);
        $statement->execute();

        $fk = $statement->fetch(PDO::FETCH_ASSOC);
        
        // Creamos una sentencia preparada
        $statement = $mbd->prepare("DELETE FROM compras WHERE id = :id");
        $statement->bindParam(':id', $id);

        // Eliminar
        if ($statement->execute()){
            $salida = [
                "mensaje" => "Registro eliminado satisfactoriamente",
                "data"    => $registro + array("data_fk" => $fk)
            ];
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

