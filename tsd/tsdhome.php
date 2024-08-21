<?php
session_start();
if(isset($_SESSION['username']) && isset($_SESSION['password']) && ($_SESSION['department'] === "TSD")){

}else{
  header("Location:/DENR/index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>127.0.0.1/home/<?php echo $_SESSION['username']; ?></title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/DENR/css/division/home.css">
  <script defer src="/DENR/js/rightclickvalidations.js"></script>

</head>
<body background="/denr/img/ur.jpg">
  <!-- Side Navbar -->
  <div class="side-nav">
    <ul class="nav flex-column">
      <li class="nav-item " style="margin-top:20px;">
        <a class="nav-link active" href="tsdhome.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="tsdprocesstable.php">Process</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="tsdtable.php">Documents</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="/denr/logout.php">Logout</a>
      </li>
      </ul>
  </div>

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
          <a class="nav-link" href="/denr/logout.php">LOGOUT</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
