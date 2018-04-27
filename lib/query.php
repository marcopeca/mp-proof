<?php 

/*
Settings:
- random: true/false -> default: false
- limit: start - stop -> default: NULL
*/ 

function proof_get_var_query($table, $var, $where = array(),$debug = false){
    global $wpdb;
    $w_string = parse_where($where);    
    if($debug){
        echo "SELECT $var FROM $table WHERE $w_string";
    }

    return $wpdb->get_var("SELECT $var FROM $table WHERE $w_string");
}

function random_proof_get_var_query($table, $var, $where = array(),$debug = false){
    global $wpdb;
    $w_string = parse_where($where);    
    if($debug){
        echo "SELECT $var FROM $table WHERE $w_string ORDER BY RAND()";
    }

    return $wpdb->get_var("SELECT $var FROM $table WHERE $w_string ORDER BY RAND()");
}

function proof_get_results_query($table, $var = "*", $where = array(), $settings = array(), $debug = false){
    global $wpdb;
    $w_string = parse_where($where);
    $s_string = "";    
    if(count($settings)){
        foreach($settings as $key=>$mp_set){
            switch ($key) {
                case 'random':
                if($mp_set){
                    $s_string .= " ORDER BY RAND()";
                }
                break;
                case 'limit':
                $s_string .= " LIMIT ". $mp_set;
                break;                
            }
        }
    }

    if($debug){
        echo "SELECT $var FROM $table WHERE $w_string $s_string";
    }
    return $wpdb->get_results("SELECT $var FROM $table WHERE $w_string $s_string");
}

function parse_where($where){
    $w_string = "1";
    if(count($where)){
        $w_string = "";
        foreach ($where as $key => $w){
            $w_string .= "$key = '$w' AND";
        }
        $w_string = substr($w_string, 0, -4);
    }

    return $w_string;
}
