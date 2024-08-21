<?php
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
  <link rel="stylesheet" href="/DENR/css/division/form.css">
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
          <form action="msdformupdate.php" method="POST" onsubmit="return validateCheckboxes()">
          <div class="frontdeskdetails">
          <h5>DETAILS</h5>

          <?php
          $denrtransactionno = htmlspecialchars($row['denrtransactionno'], ENT_QUOTES, 'UTF-8');
          $denrdaterecv = htmlspecialchars($row['denrdaterecv'], ENT_QUOTES, 'UTF-8');
          $denrdatetransmitted = htmlspecialchars($row['denrdatetransmitted'], ENT_QUOTES, 'UTF-8');
          $denrdocumentstatus = htmlspecialchars($row['denrdocumentstatus'], ENT_QUOTES, 'UTF-8');
          $denrformtime = htmlspecialchars($row['denrformtime'], ENT_QUOTES, 'UTF-8');

          $penropriority = htmlspecialchars($row['penropriority'], FILTER_SANITIZE_STRING);
          $penroprocessor = htmlspecialchars($row['penroprocessor'], FILTER_SANITIZE_STRING);
          $penrodateprocessed = htmlspecialchars($row['penrodateprocessed'], FILTER_SANITIZE_STRING);
          $penroformtime = htmlspecialchars($row['penroformtime'], FILTER_SANITIZE_STRING);
          $penroaction = htmlspecialchars($row['penroaction'], FILTER_SANITIZE_STRING);
          $penrodepartment = htmlspecialchars($row['penrodepartment'], FILTER_SANITIZE_STRING);
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
          
          <!---Display  Information with no special characters--->
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

          <label style="font-weight:bold; font-size:20px;">PENRO</label><br> <b style="font-size:20px;">Processor:</b>&nbsp;<div class="formgroup details"><?php echo $row['penroprocessor']; ?></div>
          <b>Date Processed:</b>&nbsp;<div class="formgroup details"><?php echo $row['penrodateprocessed']." / ".$row['penroformtime']; ?></div>

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
          </div>
         
          <div class="penroform">
            <h2 style="text-align:center;">MSD FORM DETAILS</h2>
          <div class="formgroup">
              <div class="formgroupitem">
                <label>Processor:</label>
                <input type="text" name="deptprocessor" id="deptprocessor" readonly value="<?php echo $_SESSION['name'] ?>" required>
              </div>
              <div class="formgroupitem">
                <label>Date Processed:</label>
                <input type="date" name="deptdateprocessed" id="deptdateprocessed" required>
              </div>
              <div class="formgroupitem">
                <label hidden>Time Processed:</label>
                <input type="text" name="depttime" id="denrformtime" required readonly hidden>
              </div>
              </div>

            <div class="formgroup">
              <div class="formgroupitem">
                <label>Priority:</label>
                <input type="text" name="deptpriority" id="deptpriority" required>
              </div>
            </div>

            <div class="formgroup">
              <div class="formgroupitem">
              <span>Action:</span>
                <div class="checkbox-group" required>
                <input type="checkbox" id="cbitem1" name="deptaction[]" value="For immediate compliance">
                <label for="cbitem1">For immediate compliance</label>
                <input type="checkbox" id="cbitem2" name="deptaction[]" value="For Indorsement Preparation">
                <label for="cbitem2">For Indorsement Preparation</label>
                <input type="checkbox" id="cbitem3" name="deptaction[]" value="For Inspection">
                <label for="cbitem3">For Inspection</label>
                <input type="checkbox" id="cbitem4" name="deptaction[]" value="For Comments / Recommendation">
                <label for="cbitem4">For Comments / Recommendation</label>
                <input type="checkbox" id="cbitem5" name="deptaction[]" value="For Investigation">
                <label for="cbitem5">For Investigation</label>
                <input type="checkbox" id="cbitem6" name="deptaction[]" value="For Initial">
                <label for="cbitem6">For Initial</label>
                <input type="checkbox" id="cbitem7" name="deptaction[]" value="For Signature">
                <label for="cbitem7">For Signature</label>
                <input type="checkbox" id="cbitem8" name="deptaction[]" value="For Appropriate Action">
                <label for="cbitem8">For Appropriate Action</label>
                <input type="checkbox" id="cbitem9" name="deptaction[]" value="Others">
                <label for="cbitem9">Others</label>

                <div id="hiddenothers" style="display:none; height:40px; flex-direction:row;">
                <label for="otherInput">Specify:</label>
                <textarea id="otherInput" class="otherInput" name="otherActionInput" value=""></textarea>
                </div>
  </div>
  </div>                 
  </div>       
            
                <div class="formgroup">
                    <div class="formgroupitem">
                    <span>WorkGroup</span>
                        <select name="deptworkgroup" id="denrformworkgroupMSD" required>
                        <option value="" selected>Select MSD</option>
                            <option value="ACCOUNTING">ACCOUNTING</option>
                            <option value="ADMINISTRATIVE & FINANCE SECTION">ADMINISTRATIVE & FINANCE SECTION</option>
                           <option value="BUDGETING">BUDGETING</option>
                            <option value="CASHIERING">CASHIERING</option>
                            <option value="HUMAN RESOURCE DEVELOPMENT">HUMAN RESOURCE DEVELOPMENT</option>
                            <option value="ICT">ICT</option>
                            <option value="PLANNING AND MONITORING SECTION">PLANNING AND MONITORING SECTION</option>
                            <option value="PROCUREMENT & SUPPLY/ GENERAL SERVICES">PROCUREMENT & SUPPLY/ GENERAL SERVICES</option>
                            <option value="RECORDS">RECORDS</option> 
                        </select>
                    </div>

                    <!--MSD--->
                    <div class="formgroupitem ">
                    <span>To:</span>
                        <select name="deptto" required>
                        <option value="" selected>Select Here</option>
                                <optgroup label="ACCOUNTING">
                                <option value="GRACE S. BALATERO">GRACE S. BALATERO</option>
                                </optgroup>

                                <optgroup label="ADMINISTRATIVE & FINANCE SECTION">
                                <option value="KARL ANTHONY M. QUEJADA">KARL ANTHONY M. QUEJADA</option>
                                </optgroup>

                                <optgroup label="BUDGETING">
                                <option value="ELVIRA T. GOTGOTAO">ELVIRA T. GOTGOTAO</option>
                                </optgroup>

                                <optgroup label="CASHIERING">
                                <option value="DAMZEL S. SOLIDOR">DAMZEL S. SOLIDOR</option>
                                </optgroup>

                                <optgroup label="HUMAN RESOURCE DEVELOPMENT">
                                <option value="MARY GRACE A. BUCU">MARY GRACE A. BUCU</option>
                                </optgroup>

                                
                                <optgroup label="ICT Unit">
                                <option value="Anabelle Agrava ">Anabelle Agrava </option>
                                </optgroup>

                                <optgroup label="PLANNING AND MONITORING SECTION ">
                                <option value="ENGR. WILMA B. TAGANNA">ENGR. WILMA B. TAGANNA</option>
                                </optgroup>

                                <optgroup label="PROCUREMENT & SUPPLY/ GENERAL SERVICES">
                                <option value="LARRY A. MANDRAS">LARRY A. MANDRAS</option>
                                </optgroup>

                                <optgroup label="RECORDS">
                                <option value="LOVELY ANN C. BASILIO">LOVELY ANN C. BASILIO</option>
                              
                        </select>
                    </div>   
                    <!--MSD--->
                </div>

            <div class="formgroup">
                <div class="formgroupitem" style="margin-bottom:1em;">
                <input type="submit" name="submit" value="Submit">

                </div> 
                
            </div>
</form>
            </div><!--Penro Form--->

    </div><!--Container--->
    </div><!--Formbody--->

    <script>   
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


function validateCheckboxes() {
    // Get all checkboxes with name 'options'
    const checkboxes = document.querySelectorAll('input[name="deptaction[]"]');
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
      document.getElementById('deptdateprocessed').value = formattedDate;
}

// Automatically generate reference number and current date when the page loads
window.onload = function() {
    getCurrentDate();
};
</script>
</body>
</html>