<?php
session_start();
if(isset($_SESSION['username']) && isset($_SESSION['password']) && ($_SESSION['department'] === "DIVISION UNIT")){
  
include "../denrconnection.php";
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if (isset($_GET['denrtransactionno'])) {
    $transno = mysqli_real_escape_string($conn, $_GET['denrtransactionno']);
    $sql = "SELECT * FROM unit_table WHERE denrtransactionno = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $transno);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Check if there are rows returned
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Process the retrieved data
    } else {
        echo "No data found for transaction number: $transno";
        header("Location:unitprocesstable.php");
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    echo "Transaction number not provided in URL.";
    header("Location:unitprocesstable.php");
  }
// Close the connection
mysqli_close($conn);

}else{
  header("Location:/DENR/index.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/DENR/css/unit/unitform.css">
  <script defer src="/DENR/js/rightclickvalidations.js"></script>
  <script defer src="/DENR/js/autotime.js"></script>
 </head>
<body background="/denr/img/denr not blur.jpg">
  
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
</div>
</div>
<div class="formbody">
          <form action="unitformupdate.php" method="POST" onsubmit="return validation()"> 
          <div class="frontdeskdetails">
          <h5>DETAILS</h5>

          <?php 
          //convert special character for anti sql injection.
           $denrtransactionno = htmlspecialchars($row['denrtransactionno'], ENT_QUOTES, 'UTF-8');
          $denrdaterecv = htmlspecialchars($row['denrdaterecv'], ENT_QUOTES, 'UTF-8');
          $denrdatetransmitted = htmlspecialchars($row['denrdatetransmitted'], ENT_QUOTES, 'UTF-8');
          $denrdocumentstatus = htmlspecialchars($row['denrdocumentstatus'], ENT_QUOTES, 'UTF-8');
          $denrformtime = htmlspecialchars($row['denrformtime'], ENT_QUOTES, 'UTF-8');

          $penropriority = htmlspecialchars($row['penropriority'], FILTER_SANITIZE_STRING);
          $penroprocessor = htmlspecialchars($row['penroprocessor'], FILTER_SANITIZE_STRING);
          $penrodateprocessed = htmlspecialchars($row['penrodateprocessed'], FILTER_SANITIZE_STRING);
          $penroformtime = htmlspecialchars($row['penrotime'], FILTER_SANITIZE_STRING);
          $penroaction = htmlspecialchars($row['penroaction'], FILTER_SANITIZE_STRING);
          $penrodepartment = htmlspecialchars($row['penrodepartment'], FILTER_SANITIZE_STRING);
          
          $deptprocessor = htmlspecialchars($row['deptprocessor'], ENT_QUOTES, 'UTF-8');
          $deptdateprocessed = htmlspecialchars($row['deptdateprocessed'], ENT_QUOTES, 'UTF-8');
          $depttime = htmlspecialchars($row['depttime'], ENT_QUOTES, 'UTF-8');
          $deptpriority = htmlspecialchars($row['deptpriority'], ENT_QUOTES, 'UTF-8');
          $deptaction = htmlspecialchars($row['deptaction'], ENT_QUOTES, 'UTF-8');
          $deptworkgroup = htmlspecialchars($row['deptworkgroup'], ENT_QUOTES, 'UTF-8');
          $deptto = htmlspecialchars($row['deptto'], ENT_QUOTES, 'UTF-8');
          ?>

           <!---Output Information with no special characters--->
           <input type="text" hidden name="denrtransactionno" value="<?php echo $denrtransactionno ?>">
          
          <input type="text" hidden name="denrname" value="<?php
          $denrname = htmlspecialchars($row['denrname'], ENT_QUOTES, 'UTF-8');
          echo $denrname; 
          ?>">

          <input type="text" hidden name="denrsender" value="<?php
          $denrsender = htmlspecialchars($row['denrsender'], ENT_QUOTES, 'UTF-8');
          echo $denrsender; 
          ?>">

          <input type="text" hidden name="denraddress" value="<?php
          $denraddress = htmlspecialchars($row['denraddress'], ENT_QUOTES, 'UTF-8');
          echo $denraddress; 
          ?>">

          <input type="text" hidden name="denrdaterecv" value="<?php echo $denrdaterecv; ?>">
         
          <input type="text" hidden name="denrdocumentsource" value="<?php
          $denrdocumentsource = htmlspecialchars($row['denrdocumentsource'], ENT_QUOTES, 'UTF-8');
          echo $denrdocumentsource; 
          ?>">

          <input type="text" hidden name="denrofficeorigin" value="<?php
          $denrofficeorigin = htmlspecialchars($row['denrofficeorigin'], ENT_QUOTES, 'UTF-8');
          echo $denrofficeorigin; 
          ?>">

          <input type="text" hidden name="denrdatetransmitted" value="<?php echo $denrdatetransmitted; ?>">
    
          <input type="text" hidden name="denrsubject" value="<?php
          $denrsubject = htmlspecialchars($row['denrsubject'], ENT_QUOTES, 'UTF-8');
          echo $denrsubject; 
          ?>">

          <input type="text" hidden name="denrdocumentstatus" value="<?php echo $denrdocumentstatus; ?>">
          <input type="text" hidden name="denrformtime" value="<?php echo $denrformtime; ?>">
         
          <input type="text" hidden name="penropriority" value="<?php
          $penropriority = htmlspecialchars($row['penropriority'], ENT_QUOTES, 'UTF-8');
          echo $penropriority; 
          ?>">

          <input type="text" hidden name="penroprocessor" value="<?php echo $penroprocessor; ?>">
          <input type="text" hidden name="penrodateprocessed" value="<?php echo $penrodateprocessed; ?>">
          <input type="text" hidden name="penrotime" value="<?php echo $penroformtime; ?>">
          
          <input type="text" hidden name="penroaction" value="<?php
          $penroaction = htmlspecialchars($row['penroaction'], ENT_QUOTES, 'UTF-8');
          echo $penroaction; 
          ?>">
          
          <input type="text" hidden name="penrodepartment" value="<?php echo $penrodepartment; ?>">
          
          <input type="text" hidden name="deptprocessor" value="<?php echo $deptprocessor; ?>">
          <input type="text" hidden name="deptdateprocessed" value="<?php echo $deptdateprocessed; ?>">
          <input type="text" hidden name="depttime" value="<?php echo $depttime; ?>">
          <input type="text" hidden name="deptpriority" value="<?php echo $deptpriority; ?>">
          
          <input type="text" hidden name="deptaction" value="<?php
          $deptaction = htmlspecialchars($row['deptaction'], ENT_QUOTES, 'UTF-8');
          echo $deptaction; 
          ?>">
          
          <input type="text" hidden name="deptworkgroup" value="<?php echo $deptworkgroup; ?>">
          <input type="text" hidden name="deptto" value="<?php echo $deptto; ?>">
          
          <label style="font-weight:bold; font-size:20px;">FRONT DESK</label><br> <b style="font-size:20px;">Transaction No:</b>&nbsp;<div class="formgroup details"><?php echo $row['denrtransactionno']; ?></div>
          <b style="font-size:14px;">Processor:</b>&nbsp;
          <div class="formgroup details" style="font-size:12px;">
          <?php
           $row['denrname'] = htmlspecialchars($row['denrname'], ENT_QUOTES, 'UTF-8');
           echo $row['denrname'];
           ?>
          </div>

          <b style="font-size:14px;">Sender:</b>&nbsp;
          <div class="formgroup details" style="font-size:12px;">
          <?php
           $row['denrsender'] = htmlspecialchars($row['denrsender'], ENT_QUOTES, 'UTF-8');
           echo $row['denrsender'];
           ?>
          </div>

          <b style="font-size:14px;">Address:</b>&nbsp;
          <div class="formgroup details" style="font-size:12px;">
          <?php
           $row['denraddress'] = htmlspecialchars($row['denraddress'], ENT_QUOTES, 'UTF-8');
           echo $row['denraddress'];
           ?>
          </div>
          <b>Date Receive:</b>&nbsp;<div class="formgroup details"><?php echo $row['denrdaterecv']; ?></div>
          <b>Document Source:</b>&nbsp;<div class="formgroup details"><?php echo $row['denrdocumentsource']; ?></div>
          
          <b style="font-size:14px;">Office Origin:</b>&nbsp;
          <div class="formgroup details" style="font-size:12px;">
          <?php
           $row['denrofficeorigin'] = htmlspecialchars($row['denrofficeorigin'], ENT_QUOTES, 'UTF-8');
           echo $row['denrofficeorigin'];
           ?>
          </div>
          
          <b>Date Transmitted:</b>&nbsp;<div class="formgroup details"><?php echo $row['denrdatetransmitted']. " / ". $row['denrformtime']; ?></div>
          
          <b style="font-size:14px;">Subject:</b>&nbsp;
          <div class="formgroup details" style="font-size:12px;">
          <?php
           $row['denrsubject'] = htmlspecialchars($row['denrsubject'], ENT_QUOTES, 'UTF-8');
           echo $row['denrsubject'];
           ?>
          </div>
          <hr>
          <label style="font-weight:bold; font-size:20px;">PENRO</label><br> 
          <b style="font-size:20px;">Processor:</b>&nbsp;<div class="formgroup details"><?php echo $row['penroprocessor']; ?></div>
          <b>Date Processed:</b>&nbsp;<div class="formgroup details"><?php echo $row['penrodateprocessed']." / ".$row['penrotime']; ?></div>
         
          <b style="font-size:14px;">Priority:</b>&nbsp;
          <div class="formgroup details" style="font-size:12px;">
          <?php
           $row['penropriority'] = htmlspecialchars($row['penropriority'], ENT_QUOTES, 'UTF-8');
           echo $row['penropriority'];
           ?>
          </div>
  
          <b style="font-size:14px;">Action:</b>&nbsp;
          <div class="formgroup details" style="font-size:12px;">
          <?php
           $row['penroaction'] = htmlspecialchars($row['penroaction'], ENT_QUOTES, 'UTF-8');
           echo $row['penroaction'];
           ?>
          </div>

          <b>Send to:</b>&nbsp;<div class="formgroup details"><?php echo $row['penrodepartment']; ?></div>
<hr>
          <label style="font-weight:bold; font-size:20px;">TSD / MSD</label><br> <b style="font-size:20px;">Processor:</b>&nbsp;<div class="formgroup details"><?php echo $row['deptprocessor']; ?></div>
          <b>Date Processed:</b>&nbsp;<div class="formgroup details"><?php echo $row['penrodateprocessed']." / ".$row['depttime']; ?></div>
          <b>Priority:</b>&nbsp;<div class="formgroup details"><?php echo $row['deptpriority']; ?></div>

          <b style="font-size:14px;">Action:</b>&nbsp;
          <div class="formgroup details" style="font-size:12px;">
          <?php
           $row['deptaction'] = htmlspecialchars($row['deptaction'], ENT_QUOTES, 'UTF-8');
           echo $row['deptaction'];
           ?>
          </div>
          
          <b>Send to:</b>&nbsp;<div class="formgroup details"><?php echo $row['deptto']; ?></div>
          <b>Workgroup:</b>&nbsp;<div class="formgroup details"><?php echo $row['deptworkgroup']; ?></div>
          </div>  
         
          <div class="container-fluid mx-5">
            <h1>UNIT FORM DETAILS</h1>
          <div class="formgroup">
              <div class="formgroupitem">
                <label>Processor:</label>
                <input type="text" name="unitprocessor" id="unitprocessor" readonly value="<?php echo $_SESSION['name'] ?>">
              </div>
              <div class="formgroupitem">
                <label>Date Processed:</label>
                <input type="date" name="unitdateprocessed" id="unitdateprocessed" required>
              </div>
              <div class="formgroupitem">
                <label hidden>Time Processed:</label>
                <input type="text" name="unittime" id="denrformtime" required readonly hidden>
              </div>
              </div>

            <div class="formgroup">
              <div class="formgroupitem">
                <label>Action:</label>
                <textarea name="unitaction" id="" cols="30" rows="10" required></textarea>
              </div>
            </div>
                  
            <div class="formgroup">
                <div class="formgroupitem" style="margin-bottom:1em;">
                <input type="submit" name="submit" value="Submit">
                </div> 
            </div>
            </div><!--Penro Form--->

    </div><!--Container--->
    </div><!--Formbody--->

<script>   
function getCurrentDate() {
    const today = new Date();
      const year = today.getFullYear();
      const month = String(today.getMonth() + 1).padStart(2, '0');
      const day = String(today.getDate()).padStart(2, '0');
      const formattedDate = `${year}-${month}-${day}`;
      document.getElementById('unitdateprocessed').value = formattedDate;
}

// Automatically generate reference number and current date when the page loads
window.onload = function() {
    getCurrentDate();
};

function redirectToDetails(transactionNo) {
    window.location.href = 'details.php?transactionNo=' + encodeURIComponent(transactionNo);
}

const cbitem8 = document.getElementById('cbitem9');
const hiddenothers = document.getElementById('hiddenothers');

cbitem8.addEventListener('change', function() {
  if (this.checked) {
    hiddenothers.style.display = 'flex';
  } else {
    hiddenothers.style.display = 'none';
  }
});


</script>
</body>
</html>