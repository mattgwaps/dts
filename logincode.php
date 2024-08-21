<?php
session_start();
include "../denr/denrconnection.php";

if (isset($_POST['login'])) {
    $username = trim($_POST['formusername']);
    $password = ($_POST['formpassword']);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Use prepared statement to prevent SQL injection
    $sql = "SELECT * FROM user_table WHERE denrusername = ? AND denrpassword = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username,$password);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($username === $row['denrusername'] && $password===$row['denrpassword'] && $row['denrdepartment'] === "Frontdesk") {
            // Set session variables
            $user = $row['denrusername'];
            $name = $row['denrname'];
            $department = $row['denrdepartment'];
            $workgroup = $row['denrworkgroup'];

            $_SESSION['username'] = $user;
            $_SESSION['name'] = $name;
            $_SESSION['department'] = $department;
            $_SESSION['workgroup'] = $workgroup;
            $_SESSION['password'] = $password;
            header("Location: /DENR/frontdesk/frontdeskhome.php");
            exit();
        }else if ($username === $row['denrusername'] && $password===$row['denrpassword'] && $row['denrdepartment'] === "PENRO") {
            // Set session variables
            $user = $row['denrusername'];
            $name = $row['denrname'];
            $department = $row['denrdepartment'];
            $workgroup = $row['denrworkgroup'];

            $_SESSION['username'] = $user;
            $_SESSION['name'] = $name;
            $_SESSION['department'] = $department;
            $_SESSION['workgroup'] = $workgroup;
            $_SESSION['password'] = $password;
            header("Location: /DENR/penro/penrohome.php");
            exit();
        }else if ($username === $row['denrusername'] && $password===$row['denrpassword'] && $row['denrdepartment'] === "TSD") {
            // Set session variables
            $user = $row['denrusername'];
            $name = $row['denrname'];
            $department = $row['denrdepartment'];
            $workgroup = $row['denrworkgroup'];

            $_SESSION['username'] = $user;
            $_SESSION['name'] = $name;
            $_SESSION['department'] = $department;
            $_SESSION['workgroup'] = $workgroup;
            $_SESSION['password'] = $password;
            header("Location: /DENR/tsd/tsdhome.php");
            exit();
        }else if ($username === $row['denrusername'] && $password===$row['denrpassword'] && $row['denrdepartment'] === "MSD") {
            // Set session variables
            $user = $row['denrusername'];
            $name = $row['denrname'];
            $department = $row['denrdepartment'];
            $workgroup = $row['denrworkgroup'];

            $_SESSION['username'] = $user;
            $_SESSION['name'] = $name;
            $_SESSION['department'] = $department;
            $_SESSION['workgroup'] = $workgroup;
            $_SESSION['password'] = $password;
            header("Location: /DENR/msd/msdhome.php");
            exit();
        }else if ($username === $row['denrusername'] && $password===$row['denrpassword'] && $row['denrdepartment'] == "DIVISION UNIT") {
            // Set session variables
            $user = $row['denrusername'];
            $name = $row['denrname'];
            $department = $row['denrdepartment'];
            $workgroup = $row['denrworkgroup'];

            $_SESSION['username'] = $user;
            $_SESSION['name'] = $name;
            $_SESSION['department'] = $department;
            $_SESSION['workgroup'] = $workgroup;
            $_SESSION['password'] = $password;
            header("Location: /DENR/unit/unithome.php");
            exit();
        }else if ($username === $row['denrusername'] && $password===$row['denrpassword'] && $row['denrdepartment'] === "admin") {
            // Set session variables
            $user = $row['denrusername'];
            $name = $row['denrname'];
            $department = $row['denrdepartment'];
            $workgroup = $row['denrworkgroup'];

            $_SESSION['username'] = $user;
            $_SESSION['name'] = $name;
            $_SESSION['department'] = $department;
            $_SESSION['workgroup'] = $workgroup;
            $_SESSION['password'] = $password;
            header("Location: /DENR/admin/adminhome.php");
            exit();
        }else{
            // Invalid password
            header("Location:/DENR/index.php?error");
        }
    } else {
        // User not found
        header("Location:/DENR/index.php?error");
    }
}
?>
