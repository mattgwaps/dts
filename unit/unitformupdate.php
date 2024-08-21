<?php
include "../denrconnection.php";
if(isset($_POST['submit'])){
    $denrtransactionno = mysqli_real_escape_string($conn, $_POST['denrtransactionno']);
    $unitprocessor = mysqli_real_escape_string($conn, $_POST['unitprocessor']);
    $unitdateprocessed = mysqli_real_escape_string($conn, $_POST['unitdateprocessed']);
    $unitaction = mysqli_real_escape_string($conn, $_POST['unitaction']);
    $unitaction = str_replace(array('\\', '/', '|', '`'), '', $unitaction);

    $unittime = mysqli_real_escape_string($conn, $_POST['unittime']);
    
    $sql = "UPDATE document_table SET unitprocessor = ?, unitdateprocessed = ?, unitaction = ?, unittime = ? WHERE denrtransactionno = ?";
    $update_stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($update_stmt, "sssss", $unitprocessor, $unitdateprocessed, $unitaction, $unittime, $denrtransactionno);
    mysqli_stmt_execute($update_stmt);
    
    if($update_stmt){
        $sql_delete_query = "DELETE FROM unit_table WHERE denrtransactionno = ?";
        $stmt_delete = mysqli_prepare($conn, $sql_delete_query);
        mysqli_stmt_bind_param($stmt_delete, "s", $denrtransactionno);
        $result_delete = mysqli_stmt_execute($stmt_delete);
        if($result_delete){
            header("Location: /denr/unit/unitsuccess.html");
       
        }
        exit();
    }else{
        echo "Error record: ". mysqli_error($conn);
    }
mysqli_stmt_close($update_stmt);
}
mysqli_close($conn);
?>