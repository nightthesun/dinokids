<?php
  
function sql_to_array($sql){
    $array=[];
    foreach ($sql as $key => $value) {
        if(!isset($array[$value->usr]))
        {
            $array[$value->usr]=$sql[$key];
        }      
        else   
        {
            if(!is_array($array[$value->usr]))
            {
                $array[$value->usr]=[$array[$value->usr],$sql[$key]];
            }
            else{
            array_push($array[$value->usr], $sql[$key]);
            }
        }   
    }
    return $array;
}
   
function sql_valor_id($sql, $id, $val)
{
    $array=[];
    foreach ($sql as $key => $value) {
        if(!isset($array[$value->usr]))
        {
            $array[$value->usr]=$value->$val;
        }      
        else   
        {
            if(!is_array($array[$value->usr]))
            {
                $array[$value->usr]=[$array[$value->usr],$value->$val];
            }
            else{
            array_push($array[$value->usr], $value->$val);
            }
        }   
    }
    return $array;
}