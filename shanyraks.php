<?
session_start();
include "db.php";

if (!isset($_SESSION["Username"])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION["Role"] != "Curator") {
    header("Location: homepage.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST["Shanyrak"]);
    $color = mysqli_real_escape_string($conn, $_POST["Colour"]);
    $action = $_POST["Action"];

    if ($action == "Add") {
        $sql = "INSERT INTO Shanyraks (Shanyrak, Colour) VALUES ('$name', '$color')";
        mysqli_query($conn, $sql);
    }

    if ($action == "Update") {
        $sql = "UPDATE Shanyraks SET Colour='$color' WHERE Shanyrak='$name'";
        mysqli_query($conn, $sql);
    }

    if ($action == "Delete") {
        $sql = "DELETE FROM Shanyraks WHERE Shanyrak='$name'";
        mysqli_query($conn, $sql);
    }
}

$records = mysqli_query($conn, "SELECT * FROM Shanyraks ORDER BY Shanyrak");
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
    <h2>Shanyraks</h2>
    <table>
      <thead>
        <tr>
          <th>Shanyrak</th>
          <th>Colour</th>
        </tr>
      </thead>
      <tbody>
        <?
        if ($records) {
            while ($row = mysqli_fetch_assoc($records)) {
                echo "<tr>";
                echo "<td>" . $row["Shanyrak"] . "</td>";
                echo "<td>" . $row["Colour"] . "</td>";
                echo "</tr>";
            }
        }
        ?>
      </tbody>
    </table>

    <h3 style="margin-top: 20px;">Manage Shanyraks</h3>
    <form method="post" action="shanyraks.php">
      <div class="form-row">
        <div>
          <label for="Shanyrak">Shanyrak</label>
          <input type="text" id="Shanyrak" name="Shanyrak" required/>
        </div>
        <div>
          <label for="Colour">Colour</label>
          <input type="text" id="Colour" name="Colour" required/>
        </div>
      </div>
      <div class="actions">
        <input type="submit" name="Action" value="Add"/>
        <input type="submit" name="Action" value="Update"/>
        <input type="submit" name="Action" value="Delete"/>
      </div>
    </form>
  </div>
</main>

<? include "footer.php"; ?>

</body>
</html>
