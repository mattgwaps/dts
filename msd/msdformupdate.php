<?php
include "../denrconnection.php";

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {

    // Escape user inputs for security
    $denrtransactionno = mysqli_real_escape_string($conn, $_POST['denrtransactionno']);
    
    $denrname = mysqli_real_escape_string($conn, $_POST['denrname']);
    $denrname = str_replace(array('\\r','\\n','\\', '/', '|', '`'), '', $denrname);

    $denrsender = mysqli_real_escape_string($conn, $_POST['denrsender']);
    $denrsender = str_replace(array('\\r','\\n','\\', '/', '|', '`'), '', $denrsender);

    $denraddress = mysqli_real_escape_string($conn, $_POST['denraddress']);
    $denraddress = str_replace(array('\\r','\\n','\\', '/', '|', '`'), '', $denraddress);

    $denrdaterecv = mysqli_real_escape_string($conn, $_POST['denrdaterecv']);
    $denrdaterecv = str_replace(array('\\r','\\n','\\', '/', '|', '`'), '', $denrdaterecv);

    $denrsubject = mysqli_real_escape_string($conn, $_POST['denrsubject']);
    $denrsubject = str_replace(array('\\r','\\n','\\', '/', '|', '`'), '', $denrsubject);

    $denrdocumentsource = mysqli_real_escape_string($conn, $_POST['denrdocumentsource']);
    $denrdocumentstatus = 'Transmitted';
    $denrdatetransmitted = mysqli_real_escape_string($conn, $_POST['denrdatetransmitted']);
    $denrformtime = mysqli_real_escape_string($conn, $_POST['denrformtime']);

    $denrofficeorigin = mysqli_real_escape_string($conn, $_POST['denrofficeorigin']);
    $denrofficeorigin = str_replace(array('\\r','\\n','\\', '/', '|', '`'), '', $denrofficeorigin);
        
    $penroprocessor = mysqli_real_escape_string($conn, $_POST['penroprocessor']);
    $penroprocessor = str_replace(array('\\r','\\n','\\', '/', '|', '`'), '', $penroprocessor);

    $penrodateprocessed = mysqli_real_escape_string($conn, $_POST['penrodateprocessed']);
    $penrotime = mysqli_real_escape_string($conn, $_POST['penrotime']);
    $penropriority = mysqli_real_escape_string($conn, $_POST['penropriority']);
    $penropriority = str_replace(array('\\r','\\n','\\', '/', '|', '`'), '', $penropriority);

    $penrodepartment = mysqli_real_escape_string($conn, $_POST['penrodepartment']);
    
    $penroaction = mysqli_real_escape_string($conn, $_POST['penroaction']);
    $penroaction = str_replace(array('\\r','\\n','\\', '/', '|', '`'), '', $penroaction);
 
    $deptprocessor = mysqli_real_escape_string($conn, $_POST['deptprocessor']);
    $deptdateprocessed = mysqli_real_escape_string($conn, $_POST['deptdateprocessed']);
    $depttime = mysqli_real_escape_string($conn, $_POST['depttime']);
    $deptpriority = mysqli_real_escape_string($conn, $_POST['deptpriority']);

    
    $deptaction = isset($_POST['deptaction']) ? implode(", ", $_POST['deptaction']) : "";
    // Check if 'deptaction' and 'Others' are set
if (isset($_POST['deptaction']) && in_array("Others", $_POST['deptaction'])) {
    // Check if 'otherActionInput' is set and not empty
    if (isset($_POST['otherActionInput']) && !empty(trim($_POST['otherActionInput']))) {
        $otherActionInput = trim(mysqli_real_escape_string($conn, $_POST['otherActionInput']));
        $deptaction .= " (" . $otherActionInput . ")";
}
        $deptaction = str_replace(array('\\r','\\n','\\', '/', '|', '`'), '', $deptaction);
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
        $sql_delete_query = "DELETE FROM msd_table WHERE denrtransactionno = ?";
        $stmt_delete = mysqli_prepare($conn, $sql_delete_query);
        mysqli_stmt_bind_param($stmt_delete, "s", $denrtransactionno); //DENRTRANSACTIONNO IS A STRING
        $result_delete = mysqli_stmt_execute($stmt_delete);

        if ($result_delete) {
            header("Location: /denr/msd/msdsuccess.html");
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