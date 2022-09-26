<?php
    $mbd = include './includes/conexion.php';

    header('Content-type:application/json;charset=utf-8');
    // Ejecución de la consulta
    try 
    {    
        
        // Asignamos los datos de las variables
        $statement=$mbd->prepare("SELECT * FROM compras");
        $statement->execute();

        $registro = $statement->fetchAll(PDO::FETCH_ASSOC);
        $salida = array();

        foreach ($registro as $reg){
            $statement=$mbd->prepare("SELECT * FROM productos WHERE id = :fk");
            $statement->bindParam(':fk', $reg["fk_id"]);
            $statement->execute();
            
            $fk = $statement->fetch(PDO::FETCH_ASSOC);
            $salida[] = $reg + array("data_fk" => $fk);
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

