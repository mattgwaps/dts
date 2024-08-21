<?php
include "../denrconnection.php";
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_POST['submit'])) {
    // Escape user inputs for security
    $denrtransactionno = mysqli_real_escape_string($conn, $_POST['denrtransactionno']);
    $denrname = mysqli_real_escape_string($conn, $_POST['denrname']);
    $denrsender = mysqli_real_escape_string($conn, $_POST['denrsender']);
    $denraddress = mysqli_real_escape_string($conn, $_POST['denraddress']);
    $denrdaterecv = mysqli_real_escape_string($conn, $_POST['denrdaterecv']);
    $denrformtime = mysqli_real_escape_string($conn, $_POST['denrformtime']);
    $denrsubject = mysqli_real_escape_string($conn, $_POST['denrsubject']);
    $denrdocumentsource = mysqli_real_escape_string($conn, $_POST['denrdocumentsource']);
    $denrdocumentstatus = 'Transmitted';
    $denrdatetransmitted = mysqli_real_escape_string($conn, $_POST['denrdatetransmitted']);
    $denrofficeorigin = mysqli_real_escape_string($conn, $_POST['denrofficeorigin']);
    $returnpurpose = mysqli_real_escape_string($conn, $_POST['returnpurpose']);
    $returndate = mysqli_real_escape_string($conn, $_POST['returndate']);
    $returntime = mysqli_real_escape_string($conn, $_POST['returntime']);
    
    $penroprocessor = mysqli_real_escape_string($conn, $_POST['penroformprocessor']);
    $penrodateprocessed = mysqli_real_escape_string($conn, $_POST['penroformdateprocessed']);
    $penrotime = mysqli_real_escape_string($conn, $_POST['penroformtime']);
    $penropriority = mysqli_real_escape_string($conn, $_POST['penroformpriority']);
    $penrodepartment = mysqli_real_escape_string($conn, $_POST['penrodepartment']);
    $penroaction = mysqli_real_escape_string($conn, $_POST['penroaction']);

    if ($penrodepartment === "TSD") {
        $table = "tsd_table";
        $sqlduplicatechecker = "SELECT * FROM tsd_table WHERE denrtransactionno = '$denrtransactionno'";

    } elseif ($penrodepartment === "MSD") {
        $table = "msd_table";
        $sqlduplicatechecker = "SELECT * FROM msd_table WHERE denrtransactionno = '$denrtransactionno'";

    } else {
        header("Location:msd/msdprocesstable.php?denrtransactionno=$denrtransactionno");
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
    $sql = "INSERT INTO $table (denrtransactionno, denrname, denrsender, denraddress, denrdaterecv, denrformtime, denrsubject, denrdocumentsource, denrdocumentstatus, denrdatetransmitted, denrofficeorigin, returnpurpose, returndate, returntime, penropriority, penroprocessor, penrodateprocessed, penroformtime, penroaction, penrodepartment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    
    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ssssssssssssssssssss", $denrtransactionno, $denrname, $denrsender, $denraddress, $denrdaterecv, $denrformtime, $denrsubject, $denrdocumentsource, $denrdocumentstatus, $denrdatetransmitted, $denrofficeorigin, $returnpurpose, $returndate, $returntime, $penropriority, $penroprocessor, $penrodateprocessed, $penrotime, $penroaction, $penrodepartment);
    
    // Execute statement
    mysqli_stmt_execute($stmt);

    // Check if insert was successful
    if (mysqli_stmt_affected_rows($stmt) > 0) {
        // Prepare and execute update query
        $sql_update_document_table = "UPDATE document_table SET penrodepartment = ?, penropriority = ?, penroprocessor = ?, returnpurpose = ?, returndate = ?, returntime = ?, penrodateprocessed = ?, penrotime = ?, penroaction = ? WHERE denrtransactionno = ?";
        $stmt_update = mysqli_prepare($conn, $sql_update_document_table);
        mysqli_stmt_bind_param($stmt_update, "ssssssssss", $penrodepartment, $penropriority, $penroprocessor, $returnpurpose, $returndate, $returntime, $penrodateprocessed, $penrotime, $penroaction, $denrtransactionno);
        mysqli_stmt_execute($stmt_update);
        
        // Prepare and execute delete query
        $sql_delete_query = "DELETE FROM msd_table WHERE denrtransactionno = ?";
        $stmt_delete = mysqli_prepare($conn, $sql_delete_query);
        mysqli_stmt_bind_param($stmt_delete, "s", $denrtransactionno);
        $result_delete = mysqli_stmt_execute($stmt_delete);

        // Check for successful deletion
        if ($result_delete) {
            // Redirect after successful update and deletion
            header("Location: /denr/msd/msdsuccess.html");
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
