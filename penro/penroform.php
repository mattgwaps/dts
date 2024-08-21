<?php
session_start();
if(isset($_SESSION['username']) && isset($_SESSION['password']) && ($_SESSION['department'] === "PENRO")){
  
include "../denrconnection.php";
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if (isset($_GET['denrtransactionno'])) {
    $transno = mysqli_real_escape_string($conn, $_GET['denrtransactionno']);
    $sql = "SELECT * FROM penro_table WHERE denrtransactionno = ?";
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
        header("Location:/denr/penro/penroprocesstable.php");
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    echo "Transaction number not provided in URL.";
    header("Location:/denr/penro/penroprocesstable.php");
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
<title>127.0.0.1/form/<?php echo $_SESSION['username']; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--ACTION CHECKBOX VALIDATION--><script def src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">  
<link rel="stylesheet" href="/DENR/css/penro/penroform.css">
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
            <a class="nav-link" href="/denr/penro/penrohome.php">BACK</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Bootstrap Bundle with Popper -->
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</div>
</div>
<div class="formbody">
          <form action="penroformupdate.php" method="POST" onsubmit="return validateCheckboxes()">          
          <div class="frontdeskdetails">
          <h5>OTHER DETAILS</h5>
          
          <?php
          $denrtransactionno = htmlspecialchars($row['denrtransactionno'], ENT_QUOTES, 'UTF-8');
          $denrdaterecv = htmlspecialchars($row['denrdaterecv'], ENT_QUOTES, 'UTF-8');
          $denrdatetransmitted = htmlspecialchars($row['denrdatetransmitted'], ENT_QUOTES, 'UTF-8');
          $denrdocumentstatus = htmlspecialchars($row['denrdocumentstatus'], ENT_QUOTES, 'UTF-8');
          $denrformtime = htmlspecialchars($row['denrformtime'], ENT_QUOTES, 'UTF-8');
          ?>

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
         
          <label style="font-weight:bold; font-size:16px;">FRONT DESK</label> <br>
          <b style="font-size:14px;">Transaction No:</b>&nbsp;<div class="formgroup details" style="font-size:12px;"><?php echo $row['denrtransactionno']; ?></div>
          
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
          
          <b style="font-size:14px;">Date Receive:</b>&nbsp;<div class="formgroup details" style="font-size:12px;"><?php echo $row['denrdaterecv']; ?></div>
          <b style="font-size:14px;">Document Source:</b>&nbsp;<div class="formgroup details" style="font-size:12px;"><?php echo $row['denrdocumentsource']; ?></div>
          
          <b style="font-size:14px;">Office Origin:</b>&nbsp;
          <div class="formgroup details" style="font-size:12px;">
          <?php
           $row['denrofficeorigin'] = htmlspecialchars($row['denrofficeorigin'], ENT_QUOTES, 'UTF-8');
           echo $row['denrofficeorigin'];
           ?>
          </div>

          <b style="font-size:14px;">Date Transmitted:</b>&nbsp;<div class="formgroup details" style="font-size:12px;"><?php echo $row['denrdatetransmitted'] .' / '.$row['denrformtime'];; ?></div>
          <b style="font-size:14px;">Subject:</b>&nbsp;
          <div class="formgroup details" style="font-size:12px;">
          <?php
           $row['denrsubject'] = htmlspecialchars($row['denrsubject'], ENT_QUOTES, 'UTF-8');
           echo $row['denrsubject'];
           ?>
          </div>   
<hr>
          </div>
         
          <div class="penroform">
            <h5>PENRO FORM DETAILS</h5>
            <!--Duplicate validation --->
            <?php if(isset($_GET['d'])){ $_GET['d'] = 'Error! Document Already Exists!'; echo "<div class='text-danger' style='font-weight:bold;'>".$_GET['d']."</div>"; }?>

          <div class="formgroup">
              <div class="formgroupitem">
                <label>Processor:</label>
                <input type="text" name="penroformprocessor" id="penroformprocessor" readonly value="<?php echo $_SESSION['name'] ?>">
              </div>
              <div class="formgroupitem">
                <label>Date Processed:</label>
                <input type="date" name="penroformdateprocessed" id="penroformdateprocessed" required>
              </div>
              <div class="formgroupitem">
                <label hidden>Time Sent:</label>
                <input type="input" name="penroformtime" id="denrformtime" hidden required readonly style="font-weight:bold; font-size:1.5em;">
              </div>   
              </div>

            <div class="formgroup">
              <div class="formgroupitem">
                <label>Priority:</label>
                <input type="text" name="penroformpriority" id="penroformpriority" required>
              </div>
            </div>

            <div class="formgroup">
              <div class="formgroupitem">
                <label>Action:</label>
                <div class="checkbox-group" required>
                <input type="checkbox" id="cbitem1" name="penroformaction[]" value="For Strict Compliance">
                <label for="cbitem1">For Strict Compliance</label>
                <input type="checkbox" id="cbitem2" name="penroformaction[]" value="Lets Endorse to R.O. / CENRO">
                <label for="cbitem2">Lets Endorse to R.O. / CENRO</label>
                <input type="checkbox" id="cbitem3" name="penroformaction[]" value="For Appropriate Action">
                <label for="cbitem3">For Appropriate Action</label>
                <input type="checkbox" id="cbitem4" name="penroformaction[]" value="For Review and Evaluation">
                <label for="cbitem4">For Review and Evaluation</label>
                <input type="checkbox" id="cbitem5" name="penroformaction[]" value="For our Investigation">
                <label for="cbitem5">For our Investigation</label>
                <input type="checkbox" id="cbitem6" name="penroformaction[]" value="For Inspection Verification">
                <label for="cbitem6">For Inspection Verification</label>
                <input type="checkbox" id="cbitem7" name="penroformaction[]" value="See me">
                <label for="cbitem7">See me</label>
                <input type="checkbox" id="cbitem8" name="penroformaction[]" value="Others">
                <label for="cbitem8">Others</label>

                <div id="hiddenothers" style="display:none; height:40px; flex-direction:row;">
                <label for="otherInput">Specify:</label>
                <textarea id="otherInput" class="otherInput" name="otherActionInput" value=""></textarea>
                </div>
               
  </div>
  </div>                 
  </div>

            <div class="formgroup">
                <label>Division</label>
                <!--ERROR -->
                <div id="departmenttext" style="color: red;"></div>
                    <div class="formgroupitem">
                        <select name="penrodepartment" id="denrformdepartment" required>
                            <option value="" selected>Select Division</option>
                            <option value="TSD" >TSD</option>
                            <option value="MSD" >MSD</option>
                        </select>
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
function redirectToDetails(transactionNo) {
    window.location.href = 'details.php?transactionNo=' + encodeURIComponent(transactionNo);
}

const cbitem8 = document.getElementById('cbitem8');
const hiddenothers = document.getElementById('hiddenothers');

cbitem8.addEventListener('change', function() {
  if (this.checked) {
    hiddenothers.style.display = 'flex';
  } else {
    hiddenothers.style.display = 'none';
  }
});
//
    function validateCheckboxes() {
    // Get all checkboxes with name 'options'
    const checkboxes = document.querySelectorAll('input[name="penroformaction[]"]');
    // Check if at least one checkbox is checked
    const isChecked = Array.from(checkboxes).some(checkbox => checkbox.checked);

    if (!isChecked) {
        alert("Please select at least one option.");
        return false; // Prevent form submission
    }
    return true; // Allow form submission
}
function getCurrentDate() {
    const today = new Date();
      const year = today.getFullYear();
      const month = String(today.getMonth() + 1).padStart(2, '0');
      const day = String(today.getDate()).padStart(2, '0');
      const formattedDate = `${year}-${month}-${day}`;
      document.getElementById('penroformdateprocessed').value = formattedDate;
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

// Usage example: remove ?error from the current URL
removeQueryParameter('d');

</script>
</body>
</html>