<?php
session_start();
if (!isset($_SESSION['username']) || !isset($_SESSION['password']) || $_SESSION['department'] !== "MSD") {
    header("Location:/DENR/index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>127.0.0.1/table/process/<?php echo htmlspecialchars($_SESSION['username']); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="/DENR/css/division/processtable.css">
    <script defer src="/DENR/js/rightclickvalidations.js"></script>
    <script defer src="/DENR/js/msdprocesstable.js"></script>
</head>
<body background="/denr/img/ur.jpg">
<!-- Top Navbar -->
<nav class="navbar top-nav">
    <div class="container-fluid">
        <img src="/denr/img/logo.ico" alt="logo" style="width:3rem"> 
        <a class="navbar-brand">PENRO LEYTE</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" style="background:whitesmoke;">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <p class="nav-link">Processor: <?php echo "<br>" . htmlspecialchars($_SESSION['name']); ?></p>
                </li>
                <li class="nav-item">
                    <p class="nav-link">Division: <?php echo "<br>" . htmlspecialchars($_SESSION['department']); ?></p>
                </li>
                <li class="nav-item">
                    <p class="nav-link">Workgroup: <?php echo "<br>" . htmlspecialchars($_SESSION['workgroup']); ?></p>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="msdhome.php">BACK</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5 p-5 bg-dark text-light" style="height:68vh; overflow:auto;">
    <table id="example" class="display" style="width:100%; overflow:auto;">
        <form action="" method="POST">
            <div class="mb-3" style="display:flex; justify-content:space-between;">
                <div style="background:#213438; font-weight:bold; padding:5px; font-size:14px;">
                    <span>Process Table</span>
                </div>
                <div>
                    <input type="text" name="inputSearch"> 
                    <input type="submit" name="search" value="SEARCH">
                </div>
            </div>
        </form>
        <thead>
            <tr> 
                <th class="border border-white border-2">Transaction Number</th>
                <th class="border border-white border-2">Date Receive</th>
                <th class="border border-white border-2">Subject</th>
                <th class="border border-white border-2">Document Source</th>
                <th class="border border-white border-2">Office Origin</th>
                <th class="border border-white border-2">Date Processed</th>
                <th class="border border-white border-2">Document Status</th>
                <th class="border border-white border-2">Action</th>
            </tr>
        </thead>
        <?php
        include "../denrconnection.php"; 
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        if (isset($_POST['search'])) {
            $search = trim($_POST["inputSearch"]);
            
            if ($search === "") {
                echo "<tbody><tr>";
                echo "<td colspan='8' style='color:#FF6969; font-weight:bold; width:100%; text-align:center;'>Error: Search should not be empty or contain whitespace.</td>";
                echo "</tr></tbody>";
            } else {
                $sql = "SELECT * FROM msd_table WHERE (denrtransactionno LIKE ? OR denrofficeorigin LIKE ? OR denrdocumentstatus LIKE ? OR denrsubject LIKE ?) AND penrodepartment = 'TSD' ORDER BY denrtransactionno DESC";
                $stmt = mysqli_prepare($conn, $sql);
                $searchParam = "%$search%";
                mysqli_stmt_bind_param($stmt, "ssss", $searchParam, $searchParam, $searchParam, $searchParam);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                
                if (mysqli_num_rows($result) > 0) {
                    while ($rows = mysqli_fetch_assoc($result)) {
                        $stringdenrtransactionno = htmlspecialchars((string)$rows['denrtransactionno']); // Convert the string for URL 
                        $date = DateTime::createFromFormat('Y-m-d', $rows['denrdaterecv']); // Parse the date
                        $formdaterecv = htmlspecialchars($date->format('F j, Y')); // Convert to alphanumeric format and escape special characters
                        $date = DateTime::createFromFormat('Y-m-d', $rows['denrdatetransmitted']); 
                        $formdatetransmitted = htmlspecialchars($date->format('F j, Y')); 
                        
                        echo "<tbody><tr ondblclick='updateRow(\"" . $stringdenrtransactionno . "\")' onmouseover='hoverEffect(this)' onmouseout='removeHoverEffect(this)'>";
                        echo "<td class='border border-white border-2' style='text-align:center;'>" . htmlspecialchars($rows['denrtransactionno']) . "</td>";
                        echo "<td class='border border-white border-2' style='text-align:center;'>" . $formdaterecv . "</td>";
                        echo "<td class='border border-white border-2 text-wrap' style='text-align:center;'>" . htmlspecialchars($rows['denrsubject']) . "</td>";
                        echo "<td class='border border-white border-2' style='text-align:center;'>" . htmlspecialchars($rows['denrdocumentsource']) . "</td>";
                        echo "<td class='border border-white border-2' style='text-align:center;'>" . htmlspecialchars($rows['denrofficeorigin']) . "</td>";
                        echo "<td class='border border-white border-2' style='text-align:center;'>" . $formdaterecv . " / " . htmlspecialchars($rows['denrformtime']) . "</td>";
                        
                        // Conditional styling for the status column
                        if ($rows['denrdocumentstatus'] == "On Process") {
                            echo "<td class='border border-white border-2' style='text-align:center;'>
                            <p style='background-color: #ed5e2c; border-radius: 50px; width: 150px; padding: 5px; margin:10px; width:90%;'>" . htmlspecialchars($rows['denrdocumentstatus']) . "</p></td>";
                        } elseif ($rows['denrdocumentstatus'] == "Transmitted") {
                            echo "<td class='border border-white border-2'>
                            <p style='background-color: #44b7fc; border-radius: 50px; width: 150px; padding: 5px; text-align:center; margin:10px; width:90%;'>" . htmlspecialchars($rows['denrdocumentstatus']) . "</p></td>";
                        } elseif ($rows['denrdocumentstatus'] == "Closed") {
                            echo "<td class='border border-white border-2'>
                            <p style='background-color: #ee6b6e; border-radius: 50px; width: 150px; padding: 5px; text-align:center; margin:10px; width:90%;'>" . htmlspecialchars($rows['denrdocumentstatus']) . "</p></td>";
                        } else {
                            echo "<td class='border border-white border-2'>" . htmlspecialchars($rows['denrdocumentstatus']) . "</td>";
                        }
                        echo "<td class='border border-white border-2' style='text-align:center;'><div><a href='msdreturnform.php?denrtransactionno=" . $rows['denrtransactionno'] . "'>Return</a></div></td>";
                        echo "</tr></tbody>";
                    }
                } else {
                    echo "<tbody><tr>";
                    echo "<td colspan='8' style='text-align:center;'>No Record Found.</td>";
                    echo "</tr></tbody>";
                }
            }
        } else {
            $sql = "SELECT * FROM msd_table ORDER BY id DESC";
            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            
            if (mysqli_num_rows($result) > 0) {
                while ($rows = mysqli_fetch_assoc($result)) {
                    $stringdenrtransactionno = htmlspecialchars((string)$rows['denrtransactionno']); // Convert the string for URL 
                    $date = DateTime::createFromFormat('Y-m-d', $rows['denrdaterecv']); // Parse the date
                    $formdaterecv = htmlspecialchars($date->format('F j, Y')); // Convert to alphanumeric format and escape special characters
                    $date = DateTime::createFromFormat('Y-m-d', $rows['denrdatetransmitted']); 
                    $formdatetransmitted = htmlspecialchars($date->format('F j, Y')); 
                    
                    echo "<tbody><tr ondblclick='updateRow(\"" . $stringdenrtransactionno . "\")' onmouseover='hoverEffect(this)' onmouseout='removeHoverEffect(this)'>";
                    echo "<td class='border border-white border-2' style='text-align:center;'>" . htmlspecialchars($rows['denrtransactionno']) . "</td>";
                    echo "<td class='border border-white border-2' style='text-align:center;'>" . $formdaterecv . "</td>";
                    echo "<td class='border border-white border-2 text-wrap' style='text-align:center;'>" . htmlspecialchars($rows['denrsubject']) . "</td>";
                    echo "<td class='border border-white border-2' style='text-align:center;'>" . htmlspecialchars($rows['denrdocumentsource']) . "</td>";
                    echo "<td class='border border-white border-2' style='text-align:center;'>" . htmlspecialchars($rows['denrofficeorigin']) . "</td>";
                    echo "<td class='border border-white border-2' style='text-align:center;'>" . $formdaterecv . " / " . htmlspecialchars($rows['denrformtime']) . "</td>";
                    
                    // Conditional styling for the status column
                    if ($rows['denrdocumentstatus'] == "On Process") {
                        echo "<td class='border border-white border-2' style='text-align:center;'>
                        <p style='background-color: #ed5e2c; border-radius: 50px; width: 150px; padding: 5px; margin:10px; width:90%;'>" . htmlspecialchars($rows['denrdocumentstatus']) . "</p></td>";
                    } elseif ($rows['denrdocumentstatus'] == "Transmitted") {
                        echo "<td class='border border-white border-2'>
                        <p style='background-color: #44b7fc; border-radius: 50px; width: 150px; padding: 5px; text-align:center; margin:10px; width:90%;'>" . htmlspecialchars($rows['denrdocumentstatus']) . "</p></td>";
                    } elseif ($rows['denrdocumentstatus'] == "Closed") {
                        echo "<td class='border border-white border-2'>
                        <p style='background-color: #ee6b6e; border-radius: 50px; width: 150px; padding: 5px; text-align:center; margin:10px; width:90%;'>" . htmlspecialchars($rows['denrdocumentstatus']) . "</p></td>";
                    } else {
                        echo "<td class='border border-white border-2'>" . htmlspecialchars($rows['denrdocumentstatus']) . "</td>";
                    }
                    echo "<td class='border border-white border-2' style='text-align:center;'><div><a href='msdreturnform.php?denrtransactionno=" . $rows['denrtransactionno'] . "'>Return</a></div></td>";
                    echo "</tr></tbody>";
                }
            } else {
                echo "<tbody><tr>";
                echo "<td colspan='8'>EMPTY</td>";
                echo "</tr></tbody>";
            }
        }
        ?>
    </table>
</div>
</body>
</html>
