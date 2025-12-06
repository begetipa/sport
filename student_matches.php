<?
session_start();
include "db.php";

if (!isset($_SESSION["Username"])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION["Role"] != "Student") {
    header("Location: homepage.php");
    exit;
}

$username = mysqli_real_escape_string($conn, $_SESSION["Username"]);
$sql = "SELECT S.Firstname, S.Surname, M.Sport, M.NumMatches FROM Students S JOIN Matches M ON S.Username = M.Username WHERE S.Username = '$username'";
$matches = mysqli_query($conn, $sql);
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
    <h2>My Matches</h2>
    <table>
      <thead>
        <tr>
          <th>Firstname</th>
          <th>Surname</th>
          <th>Sport</th>
          <th>NumMatches</th>
        </tr>
      </thead>
      <tbody>
        <?
        if ($matches) {
            while ($row = mysqli_fetch_assoc($matches)) {
                echo "<tr>";
                echo "<td>" . $row["Firstname"] . "</td>";
                echo "<td>" . $row["Surname"] . "</td>";
                echo "<td>" . $row["Sport"] . "</td>";
                echo "<td>" . $row["NumMatches"] . "</td>";
                echo "</tr>";
            }
        }
        ?>
      </tbody>
    </table>
  </div>
</main>

<? include "footer.php"; ?>

</body>
</html>
