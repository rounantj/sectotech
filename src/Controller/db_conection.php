<?php




function voidQuery($query){
    echo $query;
    try {
        $cx = mysqli_connect("mysql669.umbler.com:41890", "ronan_weg", "printMER2022");
        $db = mysqli_select_db($cx, "ronan_weg");
        $sql = mysqli_query($cx, $query) or die( mysqli_error($cx));
    } catch (\Throwable $th) {
        return $th;
    }

    

}


function JsonReturnQuery($query){
    //echo $query;
    try {
        $cx = mysqli_connect("mysql669.umbler.com:41890", "ronan_weg", "printMER2022");
        $db = mysqli_select_db($cx, "ronan_weg");
        $sql = mysqli_query($cx, $query) or die( mysqli_error($cx));
        $arrayQueRetorna = Array();
        $arrayStr = "";
        while($row = mysqli_fetch_assoc($sql)){ 
            if(json_encode($row) != ""){
                $arrayStr = $arrayStr.json_encode($row).",";
            }
        }
        $arrayStr = substr($arrayStr, 0, -1);

        return "[".$arrayStr."]";
    } catch (\Throwable $th) {
        return $th;
    }

}



?>