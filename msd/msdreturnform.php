<?php
require_once('return.php');
session_start();
if(isset($_SESSION['username']) && isset($_SESSION['password']) && ($_SESSION['department'] === "MSD")){
  
include "../denrconnection.php";
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if (isset($_GET['denrtransactionno'])) {
    $transno = mysqli_real_escape_string($conn, $_GET['denrtransactionno']);
    $sql = "SELECT * FROM msd_table WHERE denrtransactionno = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $transno);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        header("Location:msdprocesstable.php");
        echo "No data found for transaction number: $transno";
    }
    mysqli_stmt_close($stmt);
} else {
    header("Location:msdprocesstable.php");
    echo "Transaction number not provided in URL.";
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
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/DENR/css/division/returnform.css">
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
            <a class="nav-link" href="/denr/msd/msdhome.php">BACK</a>
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
<form action="return.php" method="POST">
  <div class="frontdeskdetails">
    <h5>FRONTDESK</h5>
    <b>Transaction No:</b>&nbsp;<div class="formgroup details"><?php echo $row['denrtransactionno']; ?></div>
    <b>Processor:</b>&nbsp;<div class="formgroup details"><?php echo $row['denrname']; ?></div>
    <b>Sender:</b>&nbsp;<div class="formgroup details"><?php echo $row['denrsender']; ?></div>
    <b>Address:</b>&nbsp;<div class="formgroup details"><?php echo $row['denraddress']; ?></div>
    <b>Document Received:</b>&nbsp;<div class="formgroup details"><?php echo $row['denrdaterecv']; ?></div>
    <b>Document Source:</b>&nbsp;<div class="formgroup details"><?php echo $row['denrdocumentsource']; ?></div>
    <b>Office of Origin:</b>&nbsp;<div class="formgroup details"><?php echo $row['denrofficeorigin']; ?></div>
    <b>Date Processed:</b>&nbsp;<div class="formgroup details"><?php echo $row['denrdatetransmitted']." | ".$row['denrformtime']; ?></div>
    <b>Subject:</b>&nbsp;<div class="formgroup details"><?php echo $row['denrsubject']; ?></div>
    
<!--Hidden--->
    <input type="text" hidden name="denrtransactionno" value="<?php echo $row['denrtransactionno'] ?>">
    <input type="text" hidden name="denrname" value="<?php echo $row['denrname'] ?>">
    <input type="text" hidden name="denrsender" value="<?php echo $row['denrsender'] ?>">
    <input type="text" hidden name="denraddress" value="<?php echo $row['denraddress'] ?>">
    <input type="text" hidden name="denrdaterecv" value="<?php echo $row['denrdaterecv'] ?>">
    <input type="text" hidden name="denrdocumentsource" value="<?php echo $row['denrdocumentsource'] ?>">
    <input type="text" hidden name="denrofficeorigin" value="<?php echo $row['denrofficeorigin'] ?>">
    <input type="text" hidden name="denrdatetransmitted" value="<?php echo $row['denrdatetransmitted'] ?>">
    <input type="text" hidden name="denrformtime" value="<?php echo $row['denrformtime'] ?>">
    <input type="text" hidden name="denrsubject" value="<?php echo $row['denrsubject'] ?>">
    <input type="text" hidden name="denrdocumentstatus" value="<?php echo $row['denrdocumentstatus'] ?>">

    
  </div>
<div class="ms-3 col-9"><!--Adjust here for Return Form --->
<h2>Return Form</h2>
<!--Duplicate validation --->
<?php if(isset($_GET['d'])){ $_GET['d'] = 'Error! Document Already Exists!'; echo "<div class='text-danger' style='font-weight:bold;'>".$_GET['d']."</div>"; }?>

<span>Processor</span>
<input class="form-control form-control-sm" name="penroformprocessor" type="text" placeholder="Processor" value="<?php echo $row['penroprocessor']; ?>" readonly required>
<span>Date Processed</span>
<input class="form-control form-control-sm" name="penroformdateprocessed" type="text" placeholder="Date Processed" value="<?php echo $row['penrodateprocessed']; ?>" readonly required>
<input class="form-control form-control-sm" type="input" name="penroformtime" id="denrformtime"  required readonly hidden>
<span>Priority</span>
<input class="form-control form-control-sm" name="penroformpriority" type="text" placeholder="Priority" value="<?php echo $row['penropriority']; ?>" readonly required>
<span>Action</span>
<textarea class="form-control form-control-sm" name="penroaction" placeholder="Action" readonly required><?php echo $row['penroaction'];?></textarea>
<span>Send To</span>
<select name="penrodepartment" id="penrodepartment" class="form-control form-control-sm" required>
  <option value="<?php echo $row['penrodepartment']; ?>"><?php echo $row['penrodepartment']; ?></option>
  <option value="TSD">TSD</option>
  </optgroup>
</select>
<span>Purpose</span>
<input class="form-control form-control-sm" name="returnpurpose" type="text" placeholder="Purpose" required>
<input class="form-control form-control-sm" type="input" name="returndate" id="returndate" required readonly hidden>
<input class="form-control form-control-sm" type="input" name="returntime" id="returntime" required  readonly hidden> 
<input class="btn btn-success" name="submit" type="submit" value="Submit">


</div>
</div>
</form>

    </div><!--Container--->
    </div><!--Formbody--->

    <script>   
function redirectToDetails(transactionNo) {
    window.location.href = 'details.php?transactionNo=' + encodeURIComponent(transactionNo);
}

function getCurrentDate() {
    const today = new Date();
      const year = today.getFullYear();
      const month = String(today.getMonth() + 1).padStart(2, '0');
       const day = String(today.getDate()).padStart(2, '0');
      const formattedDate = `${year}-${month}-${day}`;
      document.getElementById('returndate').value = formattedDate;
}

// Automatically generate reference number and current date when the page loads
window.onload = function() {
    getCurrentDate();
};

function removeQueryParameter(parameterName) {
    // Get the current URL without the query string
    var urlWithoutQueryString = window.location.origin + window.location.pathname;

    // Get query parameters from the current URL
    var queryParams = new URLSearchParams(window.location.search);

    // Delete the specific parameter
    queryParams.delete(parameterName);

    // Construct the new URL with updated query parameters
    var newUrl = urlWithoutQueryString + '?' + queryParams.toString();

    // Replace the current URL with the new URL
    window.history.replaceState({}, document.title, newUrl);
}

// Usage example: remove ?denrtransactionno=2002 from the current URL
removeQueryParameter('d');

</script>
</body>
</html>