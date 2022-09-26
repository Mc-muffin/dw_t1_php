<?php
    function require_args($arg_arr, $min_args){
        if (count($arg_arr) < $min_args) {
            echo json_encode([
                'error' => [
                    'codigo'  => "INPUT_ARGS_MISSING",
                    'mensaje' => "Argumentos insuficientes"
                ]
            ]);
            return;
        }
    }

    function get_update_query($tb_name, $arg_arr){
        $qry = "UPDATE $tb_name SET "; 
        foreach ($arg_arr as $field => $value)
        {
            $qry .= "$field = ?, ";
        }

        return substr($qry, 0, -2) . " WHERE id = ?;";
    }
?>