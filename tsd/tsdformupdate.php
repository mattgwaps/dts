<?php
include "../denrconnection.php";

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {

    $denrtransactionno = mysqli_real_escape_string($conn, $_POST['denrtransactionno']);
    $denrname = mysqli_real_escape_string($conn, $_POST['denrname']);
    $denrsender = mysqli_real_escape_string($conn, $_POST['denrsender']);
    $denraddress = mysqli_real_escape_string($conn, $_POST['denraddress']);
    $denrdaterecv = mysqli_real_escape_string($conn, $_POST['denrdaterecv']);
    $denrsubject = mysqli_real_escape_string($conn, $_POST['denrsubject']);
    $denrdocumentsource = mysqli_real_escape_string($conn, $_POST['denrdocumentsource']);
    $denrdocumentstatus = mysqli_real_escape_string($conn, $_POST['denrdocumentstatus']);
    $denrdatetransmitted = mysqli_real_escape_string($conn, $_POST['denrdatetransmitted']);
    $denrformtime = mysqli_real_escape_string($conn, $_POST['denrformtime']);
    $denrofficeorigin = mysqli_real_escape_string($conn, $_POST['denrofficeorigin']);

    $penropriority = mysqli_real_escape_string($conn, $_POST['penropriority']);
    $penroprocessor = mysqli_real_escape_string($conn, $_POST['penroprocessor']);
    $penrodateprocessed = mysqli_real_escape_string($conn, $_POST['penrodateprocessed']);
    $penrotime = mysqli_real_escape_string($conn, $_POST['penrotime']);
    $penroaction = mysqli_real_escape_string($conn, $_POST['penroaction']);
    $penrodepartment = mysqli_real_escape_string($conn, $_POST['penrodepartment']);

    $deptprocessor = mysqli_real_escape_string($conn, $_POST['deptprocessor']);
    $deptdateprocessed = mysqli_real_escape_string($conn, $_POST['deptdateprocessed']);
    $depttime = mysqli_real_escape_string($conn, $_POST['depttime']);
    $deptpriority = mysqli_real_escape_string($conn, $_POST['deptpriority']);

    $deptaction = isset($_POST['deptaction']) ? implode(", ", $_POST['deptaction']) : "";
    
    if (isset($_POST['deptaction']) && in_array("Others", $_POST['deptaction']) && isset($_POST['otherActionInput'])) {
        $otherActionInput = mysqli_real_escape_string($conn, $_POST['otherActionInput']);
        $deptaction .= ", " . $otherActionInput;
    }

    $deptworkgroup = mysqli_real_escape_string($conn, $_POST['deptworkgroup']);
    $deptto = mysqli_real_escape_string($conn, $_POST['deptto']);

    $sql_insert_unit_table = "INSERT INTO unit_table 
    (denrtransactionno, denrname, denrsender, denraddress, denrdaterecv, denrsubject, denrdocumentsource, denrdocumentstatus, denrdatetransmitted, denrformtime,denrofficeorigin,
    penropriority, penroprocessor, penrodateprocessed, penrotime, penroaction, penrodepartment,
    deptprocessor, deptdateprocessed, depttime, deptpriority, deptaction, deptworkgroup, deptto)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt_insert_unit_table = mysqli_prepare($conn, $sql_insert_unit_table);
    mysqli_stmt_bind_param($stmt_insert_unit_table,"ssssssssssssssssssssssss",
    $denrtransactionno, $denrname, $denrsender, $denraddress, $denrdaterecv, $denrsubject, $denrdocumentsource, $denrdocumentstatus, $denrdatetransmitted, $denrformtime, $denrofficeorigin,
    $penropriority, $penroprocessor, $penrodateprocessed, $penrotime, $penroaction, $penrodepartment, 
    $deptprocessor, $deptdateprocessed, $depttime, $deptpriority, $deptaction, $deptworkgroup,$deptto);
    mysqli_stmt_execute($stmt_insert_unit_table);


    $sql_update_document_table = "UPDATE document_table SET deptprocessor = ?, deptdateprocessed = ?, depttime = ?, deptpriority = ?, deptaction = ?, deptworkgroup = ?, deptto = ? WHERE denrtransactionno = ?";
    $stmt = mysqli_prepare($conn, $sql_update_document_table);
    mysqli_stmt_bind_param($stmt, "ssssssss", $deptprocessor, $deptdateprocessed, $depttime, $deptpriority, $deptaction, $deptworkgroup, $deptto, $denrtransactionno);
    mysqli_stmt_execute($stmt);

    
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        // Prepare and execute delete query
        $sql_delete_query = "DELETE FROM tsd_table WHERE denrtransactionno = ?";
        $stmt_delete = mysqli_prepare($conn, $sql_delete_query);
        mysqli_stmt_bind_param($stmt_delete, "s", $denrtransactionno);
        $result_delete = mysqli_stmt_execute($stmt_delete);

        if ($result_delete) {
            header("Location: /denr/tsd/tsdcomplete.html");
            exit();
        } else {
            // Handle delete error
            echo "Error deleting record: " . mysqli_error($conn);
        }
    } else {
        // Handle update error
        echo "Error updating record: " . mysqli_error($conn);
    }
    // Closing statement
    mysqli_stmt_close($stmt);
}

// Closing connection
mysqli_close($conn);
?>