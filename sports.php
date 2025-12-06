<?
session_start();
include "db.php";

if (!isset($_SESSION["Username"])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION["Role"] != "Teacher") {
    header("Location: homepage.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sport = mysqli_real_escape_string($conn, $_POST["Sport"]);
    $practice = mysqli_real_escape_string($conn, $_POST["PracticeDay"]);
    $action = $_POST["Action"];

    if ($action == "Add") {
        $sql = "INSERT INTO Sports (Sport, PracticeDay) VALUES ('$sport', '$practice')";
        mysqli_query($conn, $sql);
    }

    if ($action == "Update") {
        $sql = "UPDATE Sports SET PracticeDay='$practice' WHERE Sport='$sport'";
        mysqli_query($conn, $sql);
    }

    if ($action == "Delete") {
        $sql = "DELETE FROM Sports WHERE Sport='$sport'";
        mysqli_query($conn, $sql);
    }
}

$sports = mysqli_query($conn, "SELECT * FROM Sports ORDER BY Sport");
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
    <h2>Sports</h2>
    <table>
      <thead>
        <tr>
          <th>Sport</th>
          <th>Practice Day</th>
        </tr>
      </thead>
      <tbody>
        <?
        if ($sports) {
            while ($row = mysqli_fetch_assoc($sports)) {
                echo "<tr>";
                echo "<td>" . $row["Sport"] . "</td>";
                echo "<td>" . $row["PracticeDay"] . "</td>";
                echo "</tr>";
            }
        }
        ?>
      </tbody>
    </table>

    <h3 style="margin-top: 20px;">Manage Sports</h3>
    <form method="post" action="sports.php">
      <div class="form-row">
        <div>
          <label for="Sport">Sport</label>
          <input type="text" id="Sport" name="Sport" required/>
        </div>
        <div>
          <label for="PracticeDay">Practice Day</label>
          <select id="PracticeDay" name="PracticeDay" required>
            <option value="Monday">Monday</option>
            <option value="Tuesday">Tuesday</option>
            <option value="Wednesday">Wednesday</option>
            <option value="Thursday">Thursday</option>
            <option value="Friday">Friday</option>
          </select>
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
