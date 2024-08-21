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
    $denrformtime = mysqli_real_escape_string($conn, $_POST['denrformtime']);

    $denrsubject = mysqli_real_escape_string($conn, $_POST['denrsubject']);
    $denrsubject = str_replace(array('\\r','\\n','\\', '/', '|', '`'), '', $denrsubject);

    $denrdocumentsource = mysqli_real_escape_string($conn, $_POST['denrdocumentsource']);
    $denrdocumentstatus = 'Transmitted';
    $denrdatetransmitted = mysqli_real_escape_string($conn, $_POST['denrdatetransmitted']);

    $denrofficeorigin = mysqli_real_escape_string($conn, $_POST['denrofficeorigin']);
    $denrofficeorigin = str_replace(array('\\r','\\n','\\', '/', '|', '`'), '', $denrofficeorigin);
        
    $penroprocessor = mysqli_real_escape_string($conn, $_POST['penroformprocessor']);
    $penroprocessor = str_replace(array('\\r','\\n','\\', '/', '|', '`'), '', $penroprocessor);

    $penrodateprocessed = mysqli_real_escape_string($conn, $_POST['penroformdateprocessed']);

    $penrotime = mysqli_real_escape_string($conn, $_POST['penroformtime']);
    $penropriority = mysqli_real_escape_string($conn, $_POST['penroformpriority']);
    $penropriority = str_replace(array('\\r','\\n','\\', '/', '|', '`'), '', $penropriority);

    $penrodepartment = mysqli_real_escape_string($conn, $_POST['penrodepartment']);
    $penroaction = isset($_POST['penroformaction']) ? implode(", ", $_POST['penroformaction']) : "";
    
        // Check if 'penroformaction' and 'Others' are set
    if (isset($_POST['penroformaction']) && in_array("Others", $_POST['penroformaction'])) {
        // Check if 'otherActionInput' is set and not empty
        if (isset($_POST['otherActionInput']) && !empty(trim($_POST['otherActionInput']))) {
            $otherActionInput = trim(mysqli_real_escape_string($conn, $_POST['otherActionInput']));
            $penroaction .= " (" . $otherActionInput . ")";
    }
            // Remove unwanted characters from penroaction
            $penroaction = str_replace(array('\\r','\\n','\\', '/', '|', '`'), '', $penroaction);
    }
    if ($penrodepartment === "TSD") {
        $table = "tsd_table";
        $sqlduplicatechecker = "SELECT * FROM tsd_table WHERE denrtransactionno = '$denrtransactionno'";

    } elseif ($penrodepartment === "MSD") {
        $table = "msd_table";
        $sqlduplicatechecker = "SELECT * FROM msd_table WHERE denrtransactionno = '$denrtransactionno'";
    } else {
        header("Location:penroform.php?denrtransactionno=$denrtransactionno");
        exit();
    }
//duplicate checker
    $query = mysqli_query($conn,$sqlduplicatechecker);
    if(mysqli_num_rows($query) > 0){
        $duplicate = "msdreturnform.php?d&denrtransactionno=" . urlencode($denrtransactionno);
        header("Location: " . $duplicate);
        exit; 
    }else{

    // Prepare insert statement
    $sql = "INSERT INTO $table (denrtransactionno, denrname, denrsender, denraddress, denrdaterecv, denrformtime, denrsubject, denrdocumentsource, denrdocumentstatus, denrdatetransmitted, denrofficeorigin, penropriority, penroprocessor, penrodateprocessed, penroformtime, penroaction, penrodepartment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssssssssssssssss", $denrtransactionno, $denrname, $denrsender, $denraddress, $denrdaterecv, $denrformtime, $denrsubject, $denrdocumentsource, $denrdocumentstatus, $denrdatetransmitted, $denrofficeorigin, $penropriority, $penroprocessor, $penrodateprocessed, $penrotime, $penroaction, $penrodepartment);

    // Execute statement
    mysqli_stmt_execute($stmt);

    // Check if insert was successful
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        // Prepare and execute update query
        $sql_update_document_table = "UPDATE document_table SET penrodepartment = ?, penropriority = ?, penroprocessor = ?, penrodateprocessed = ?, penrotime = ?, penroaction = ? WHERE denrtransactionno = ?";
        $stmt_update = mysqli_prepare($conn, $sql_update_document_table);
        mysqli_stmt_bind_param($stmt_update, "sssssss", $penrodepartment, $penropriority, $penroprocessor, $penrodateprocessed, $penrotime, $penroaction, $denrtransactionno);
        mysqli_stmt_execute($stmt_update);
        
        // Prepare and execute delete query
        $sql_delete_query = "DELETE FROM penro_table WHERE denrtransactionno = ?";
        $stmt_delete = mysqli_prepare($conn, $sql_delete_query);
        mysqli_stmt_bind_param($stmt_delete, "s", $denrtransactionno);
        $result_delete = mysqli_stmt_execute($stmt_delete);

        // Check for successful deletion
        if ($result_delete) {
            // Redirect after successful update and deletion
            header("Location: /denr/penro/penrosuccess.html");
            exit();
        } else {
            // Handle delete error
            echo "Error deleting record: " . mysqli_error($conn);
        }
    } else {
        // Handle insert error
        echo "Error inserting record: " . mysqli_error($conn);
    }

    // Close statements
    mysqli_stmt_close($stmt);
    mysqli_stmt_close($stmt_update);
    mysqli_stmt_close($stmt_delete);
}
}
// Close connection
mysqli_close($conn);
?>
