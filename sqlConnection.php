<?php
function conn() {
    $server = "tcp:techniondbcourse01.database.windows.net,1433";
    $user = "eduardogol";
    $pass = "Qwerty12!";
    $database = "eduardogol";
    $c = array("Database" => $database, "UID" => $user, "PWD" => $pass);
    sqlsrv_configure('WarningsReturnAsErrors', 0);
    $conn = sqlsrv_connect($server, $c);
    if($conn === false)
    {
        echo "error";
        die(print_r(sqlsrv_errors(), true));
    }
    return $conn;
}

function uploadSingle($arr, $table){
    $sql="INSERT INTO ";
    $sql.= $table;
    $sql.=" VALUES(";
    for ($i = 0; $i <count($arr); $i++) {
        if ($i !=0 )$sql.=',';
        if (!is_int($arr[$i]))
            $sql .="'$arr[$i]'";
        else
            $sql .=$arr[$i];
    }
    $sql .=")";
    return sqlsrv_query(conn(), $sql);
}

function CVSUpload($file, $table){
    $success = 0;
    $failed = 0;
    $row = 1;
    if (($handle = fopen($file, "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if ($row == 1) {
                $row++;
                continue;}
            $row++;
            $result = uploadSingle($data, $table);
            if (!$result) {$failed++;}
            else {$success++;}
        }
    }
    else {return array('Success' => 'FAILED', 'Failed' => 'FAILED');}
    fclose($handle);
    return array('Success' => $success, 'Failed' => $failed);
}
?>