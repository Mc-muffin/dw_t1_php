<?php
    include './includes/utils.php';
    $mbd = include './includes/conexion.php';

    header('Content-type:application/json;charset=utf-8');
    // Ejecución de la consulta
    try 
    {            
        $tb_name   = "compras";
        $query_get = "SELECT * FROM $tb_name WHERE id = ?";
        require_args($_POST, 2);

        $id   = $_POST['id'];
        $args = array_diff_key($_POST, ['id' => '']);
        $qry  = get_update_query($tb_name, $args);  
        $args = $args + [$id];
        
        $statement=$mbd->prepare($query_get);
        $statement->execute([$id]);
    
        $registro_o = $statement->fetch(PDO::FETCH_ASSOC);

        $statement=$mbd->prepare("SELECT * FROM productos WHERE id = :fk");
        $statement->bindParam(':fk', $registro["fk_id"]);
        $statement->execute();
        $fk = $statement->fetch(PDO::FETCH_ASSOC);

        // Creamos una sentencia preparada
        $statement=$mbd->prepare($qry);
        $statement->execute(array_values($args));


        $statement=$mbd->prepare($query_get);
        $statement->execute([$id]);
    
        $registro_n = $statement->fetch(PDO::FETCH_ASSOC);

        $salida = [
            "mensaje"  => "Registro actualizado satisfactoriamente",
            "old_data" => $registro_o + array("data_fk" => $fk),
            "new_data" => $registro_n + array("data_fk" => $fk),
        ];
        
        // Retornamos resultados
        header('Content-type:application/json;charset=utf-8');    
        echo json_encode($salida);
    
    } catch (PDOException $e) {
        header('Content-type:application/json;charset=utf-8');    
        echo json_encode([
            'error' => [
                'codigo' =>$e->getCode() ,
                'mensaje' => $e->getMessage()
            ]
        ]);
    }
?>