<?php
session_start();
if(isset($_SESSION['username']) && isset($_SESSION['password']) && ($_SESSION['department'] === "DIVISION UNIT")){
 
}else{
  header("Location:/DENR/index.php");
  exit();
}
include "../denrconnection.php";
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if (isset($_GET['denrtransactionno'])) {
    $transno = mysqli_real_escape_string($conn, $_GET['denrtransactionno']);
    $sql = "SELECT * FROM document_table WHERE denrtransactionno = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $transno);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "No data found for transaction number: $transno";
    }
    mysqli_stmt_close($stmt);
} else {
    echo "Transaction number not provided in URL.";
}
mysqli_close($conn);
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/DENR/css/unit/unitdocumenttable.css">
  <script defer src="/DENR/js/rightclickvalidations.js"></script>
</head>
<body background="/denr/img/ur.jpg">
<!-- Top Navbar -->
<nav class="navbar top-nav">
    <div class="container-fluid">
    <img src="/denr/img/logo.ico" alt="logo" style="width:3rem"> <a class="navbar-brand">PENRO LEYTE</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="background:whitesmoke;">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <p class="nav-link">Processor: <?php echo "<br>".$_SESSION['name']; ?></p>
          </li>
          <li class="nav-item">
          <p class="nav-link">Division: <?php echo "<br>".$_SESSION['department']; ?></p>
          </li>
          <li class="nav-item">
          <p class="nav-link">Workgroup: <?php echo "<br>".$_SESSION['workgroup']; ?></p>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/denr/unit/unithome.php">BACK</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

 <!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<div class="container-fluid p-5 mt-1" style="width:90%; backdrop-filter: blur(200px);">
    <div class="row">
        <!-- FRONTDESK -->
        <div class="col-6">
            <h4 style="color:white;">FRONTDESK</h4>
            <div class="input-group">
                <span class="input-group-text">Transaction No</span>
                <input type="text" class="form-control" style="font-size:12px;" value="<?php echo htmlspecialchars($row['denrtransactionno']); ?>" readonly>
                <span class="input-group-text">Status</span>
                <input type="text" class="form-control" style="font-size:12px;" value="<?php echo htmlspecialchars($row['denrdocumentstatus']); ?>" readonly>
                <span class="input-group-text">Date Receive</span>
                <input type="text" class="form-control" style="font-size:12px;" value="<?php echo htmlspecialchars($row['denrdaterecv']); ?>" readonly>
            </div>
            <div class="input-group mt-1">
                <span class="input-group-text">Sender</span>
                <input type="text" class="form-control" style="font-size:12px;" value="<?php echo htmlspecialchars($row['denrsender']); ?>" readonly>
                
            </div>
            <div class="input-group mt-1">
                <span class="input-group-text">Address</span>
                <input type="text" class="form-control" style="font-size:12px;" value="<?php echo htmlspecialchars($row['denraddress']); ?>" readonly>
            </div>
            <div class="input-group mt-1">
                <span class="input-group-text">Origin</span>
                <input type="text" class="form-control" style="font-size:12px;" value="<?php echo htmlspecialchars($row['denrofficeorigin']); ?>" readonly>
                <span class="input-group-text">Document Source</span>
                <input type="text" class="form-control" style="font-size:12px;" value="<?php echo htmlspecialchars($row['denrdocumentsource']); ?>" readonly>    
            </div>
            <div class="input-group mt-1">
                <span class="input-group-text">Processor</span>
                <input type="text" class="form-control" style="font-size:12px;" value="<?php echo htmlspecialchars($row['denrname']); ?>" readonly>
                <span class="input-group-text">Date Processed</span>
                <input type="text" class="form-control" style="font-size:12px;" value="<?php echo htmlspecialchars($row['denrdatetransmitted'].' / '.$row['denrformtime']); ?>" readonly>    
            </div>
            <div class="input-group mt-1">
                <textarea class="form-control" style="font-size:12px;" aria-label="With textarea" readonly style="font-size:12px;"><?php echo htmlspecialchars($row['denrsubject']); ?></textarea>
            </div>
        </div><!--col-->

        <!-- PENRO -->
        <div class="col-6">
            <h4 style="color:white;">PENRO</h4>
            <div class="input-group mt-1">
                <span class="input-group-text">Processor</span>
                <input type="text" class="form-control" style="font-size:12px;" value="<?php echo htmlspecialchars($row['penroprocessor']); ?>" readonly>
                <span class="input-group-text">Priority</span>
                <input type="text" class="form-control" style="font-size:12px;" value="<?php echo htmlspecialchars($row['penropriority']); ?>" readonly>
            </div>
            <div class="input-group mt-1">
                <span class="input-group-text">Date Processed</span>
                <input type="text" class="form-control" style="font-size:12px;" value="<?php echo htmlspecialchars($row['penrodateprocessed']); ?>" readonly>
                <span class="input-group-text">Time</span>
                <input type="text" class="form-control" style="font-size:12px;" value="<?php echo htmlspecialchars($row['penrotime']); ?>" readonly>
                <span class="input-group-text">Document Sent To</span>
                <input type="text" class="form-control" style="font-size:12px;" value="<?php echo htmlspecialchars($row['penrodepartment']); ?>" readonly>
            </div>
            <div class="input-group mt-1">
                <textarea class="form-control" style="font-size:12px;" aria-label="With textarea" readonly style="font-size:12px;"><?php echo htmlspecialchars($row['penroaction']); ?></textarea>
            </div>
        </div><!--col-->

        <!-- MSD / TSD -->
        <div class="col-6 mt-3">
            <h4 style="color:white;">MSD / TSD</h4>
            <div class="input-group mt-1">
                <span class="input-group-text">Processor</span>
                <input type="text" class="form-control" style="font-size:12px;" value="<?php echo htmlspecialchars($row['deptprocessor']); ?>" readonly>
                <span class="input-group-text">Priority</span>
                <input type="text" class="form-control" style="font-size:12px;" value="<?php echo htmlspecialchars($row['deptpriority']); ?>" readonly>
            </div>
            <div class="input-group mt-1">
                <span class="input-group-text">Sent to</span>
                <input type="text" class="form-control" style="font-size:12px;" value="<?php echo htmlspecialchars($row['deptto']); ?>" readonly>
                <span class="input-group-text">Workgroup</span>
                <input type="text" class="form-control" style="font-size:12px;" value="<?php echo htmlspecialchars($row['deptworkgroup']); ?>" readonly>
            </div>
            <div class="input-group mt-1">
                <span class="input-group-text">Date Processed</span>
                <input type="text" class="form-control" style="font-size:12px;" value="<?php echo htmlspecialchars($row['deptdateprocessed']); ?>" readonly>
                <span class="input-group-text">Time</span>
                <input type="text" class="form-control" style="font-size:12px;" value="<?php echo htmlspecialchars($row['depttime']); ?>" readonly>
            </div>
            
            <div class="input-group mt-1">
                <textarea class="form-control" style="font-size:12px;" aria-label="With textarea" readonly style="font-size:12px;"><?php echo htmlspecialchars($row['deptaction']); ?></textarea>
            </div>
            <div class="input-group mt-1">
                <span class="input-group-text">Return Processor</span>
                <input type="text" class="form-control" style="font-size:12px;" value="<?php echo htmlspecialchars($row['returnprocessor']); ?>" readonly>
                <span class="input-group-text">Date</span>
                <input type="text" class="form-control" style="font-size:12px;" value="<?php echo htmlspecialchars($row['returndate']); ?>" readonly>
                <span class="input-group-text">Time</span>
                <input type="text" class="form-control" style="font-size:12px;" value="<?php echo htmlspecialchars($row['returntime']); ?>" readonly>
            </div>
            <div class="input-group mt-1">
                <span class="input-group-text">Purpose</span>
                <input type="text" class="form-control" style="font-size:12px;" value="<?php echo htmlspecialchars($row['returnpurpose']); ?>" readonly>
            </div>
            
            
        </div><!--col-->

        <!-- WORKGROUP -->
        <div class="col-6 mt-3">
            <h4 style="color:white;">Workgroup</h4>
            <div class="input-group mt-1">
                <span class="input-group-text">Processor</span>
                <input type="text" class="form-control" style="font-size:12px;" value="<?php echo htmlspecialchars($row['unitprocessor']); ?>" readonly>
                <span class="input-group-text">Workgroup</span>
                <input type="text" class="form-control" style="font-size:12px;" value="<?php echo htmlspecialchars($row['deptworkgroup']); ?>" readonly>
            </div>
            <div class="input-group mt-1">
                <span class="input-group-text">Date Processed</span>
                <input type="text" class="form-control" style="font-size:12px;" value="<?php echo htmlspecialchars($row['unitdateprocessed']); ?>" readonly>
                <span class="input-group-text">Time</span>
                <input type="text" class="form-control" style="font-size:12px;" value="<?php echo htmlspecialchars($row['unittime']); ?>" readonly>
            </div>
            <div class="input-group mt-1">
                <textarea class="form-control" style="font-size:12px;" aria-label="With textarea" readonly style="font-size:12px;"><?php echo htmlspecialchars($row['unitaction']); ?></textarea>
            </div>
            
            <div class="input-group mt-1">
                <span class="input-group-text">Return Processor</span>
                <input type="text" class="form-control" style="font-size:12px;" value="<?php echo htmlspecialchars($row['returnprocessor']); ?>" readonly>
                <span class="input-group-text">Date</span>
                <input type="text" class="form-control" style="font-size:12px;" value="<?php echo htmlspecialchars($row['returndate']); ?>" readonly>
                <span class="input-group-text">Time</span>
                <input type="text" class="form-control" style="font-size:12px;" value="<?php echo htmlspecialchars($row['returntime']); ?>" readonly>
            </div>
            <div class="input-group mt-1">
                <span class="input-group-text">Purpose</span>
                <input type="text" class="form-control" style="font-size:12px;" value="<?php echo htmlspecialchars($row['returnpurpose']); ?>" readonly>
            </div>
            
            
        </div><!--col-->
    </div><!--row-->
            
    </div><!--container-fluid-->
</div><!--container-->
</body>
</html>

