<?
session_start();
include "db.php";

if (!isset($_SESSION["Username"])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="css/style.css"/>
  <title>Sports Management System</title>
</head>
<body>

<? include "header.php"; ?>
<? include "nav.php"; ?>

<main>
  <div class="card">
    <h2>Welcome</h2>
    <p>Welcome <? echo $_SESSION["Username"]; ?> (<? echo $_SESSION["Role"]; ?>).</p>
    <p>Use the navigation to manage records based on your role.</p>
  </div>
</main>

<? include "footer.php"; ?>

</body>
</html>
