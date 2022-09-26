<?php
    include './includes/utils.php';
    $mbd = include './includes/conexion.php';

    header('Content-type:application/json;charset=utf-8');
    // Ejecución de la consulta
    try 
    {   
        $tb_name   = "productos";
        $query_get = "SELECT * FROM $tb_name WHERE id = ?";
        require_args($_POST, 2);

        $id   = $_POST['id'];
        $args = array_diff_key($_POST, ['id' => '']);
        $qry  = get_update_query($tb_name, $args);  
        $args = $args + [$id];      
        
        $statement=$mbd->prepare($query_get);
        $statement->execute([$id]);
        $prod_o = $statement->fetch(PDO::FETCH_ASSOC);
        
        // Creamos una sentencia preparada
        $statement=$mbd->prepare($qry);
        $statement->execute(array_values($args));

        $statement=$mbd->prepare($query_get);
        $statement->execute([$id]);
        $prod_n = $statement->fetch(PDO::FETCH_ASSOC);

        $salida = [
            "mensaje"  => "Producto actualizado satisfactoriamente",
            "old_data" => $prod_o,
            "new_data" => $prod_n
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

