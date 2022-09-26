<?php
    $mbd = include './includes/conexion.php';

    header('Content-type:application/json;charset=utf-8');
    try 
    {       
        $statement=$mbd->prepare("SELECT * FROM productos");
        $statement->execute();

        $registros = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        // Retornamos resultados
        echo json_encode($registros);

    } catch (PDOException $e) {  
        echo json_encode([
            'error' => [
                'codigo' =>$e->getCode() ,
                'mensaje' => $e->getMessage()
            ]
        ]);
    }
?>

