<?
session_start();
include "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST["Username"]);
    $password = $_POST["Password"];

    $sql = "SELECT * FROM Users WHERE Username='$username'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row["Password"])) {
            $_SESSION["Username"] = $row["Username"];
            $_SESSION["Role"] = $row["Role"];
            header("Location: homepage.php");
            exit;
        } else {
            $message = "Incorrect username or password.";
        }
    } else {
        $message = "Incorrect username or password.";
    }
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
  <div class="card" style="max-width: 400px; margin: 0 auto;">
    <h2>Login</h2>
    <? if ($message != "") { echo "<div class='message'>$message</div>"; } ?>
    <form method="post" action="login.php">
      <label for="Username">Username</label>
      <input type="text" id="Username" name="Username" required/>

      <label for="Password">Password</label>
      <input type="password" id="Password" name="Password" required/>

      <input type="submit" value="LOG IN"/>
    </form>
  </div>
</main>

<? include "footer.php"; ?>

</body>
</html>
