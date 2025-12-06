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
    $action = $_POST["Action"];
    $username = mysqli_real_escape_string($conn, $_POST["Username"]);
    $sport = mysqli_real_escape_string($conn, $_POST["Sport"]);
    $numMatches = intval($_POST["NumMatches"]);

    if ($action == "Add") {
        $sql = "INSERT INTO Matches (Username, Sport, NumMatches) VALUES ('$username', '$sport', $numMatches)";
        mysqli_query($conn, $sql);
    }

    if ($action == "Update") {
        $sql = "UPDATE Matches SET NumMatches=$numMatches WHERE Username='$username' AND Sport='$sport'";
        mysqli_query($conn, $sql);
    }

    if ($action == "Delete") {
        $sql = "DELETE FROM Matches WHERE Username='$username' AND Sport='$sport'";
        mysqli_query($conn, $sql);
    }
}

$sql = "SELECT S.Firstname, S.Surname, M.Username, M.Sport, M.NumMatches FROM Students S JOIN Matches M ON S.Username = M.Username ORDER BY S.Surname, S.Firstname";
$matches = mysqli_query($conn, $sql);
$studentOptions = mysqli_query($conn, "SELECT Username, Firstname, Surname FROM Students ORDER BY Surname, Firstname");
$sportOptions = mysqli_query($conn, "SELECT Sport FROM Sports ORDER BY Sport");
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
    <h2>Manage Matches</h2>
    <table>
      <thead>
        <tr>
          <th>Firstname</th>
          <th>Surname</th>
          <th>Sport</th>
          <th>NumMatches</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?
        if ($matches) {
            while ($row = mysqli_fetch_assoc($matches)) {
                echo "<form method='post' action='matches.php'>";
                echo "<tr>";
                echo "<td>" . $row["Firstname"] . "</td>";
                echo "<td>" . $row["Surname"] . "</td>";
                echo "<td>" . $row["Sport"] . "</td>";
                echo "<td><input type='number' name='NumMatches' value='" . $row["NumMatches"] . "' style='width:100px'/></td>";
                echo "<td class='actions'>";
                echo "<input type='hidden' name='Username' value='" . $row["Username"] . "'/>";
                echo "<input type='hidden' name='Sport' value='" . $row["Sport"] . "'/>";
                echo "<input type='submit' name='Action' value='Update'/>";
                echo "<input type='submit' name='Action' value='Delete'/>";
                echo "</td>";
                echo "</tr>";
                echo "</form>";
            }
        }
        ?>
      </tbody>
    </table>

    <h3 style="margin-top: 20px;">Add New Match Record</h3>
    <form method="post" action="matches.php">
      <div class="form-row">
        <div>
          <label for="Username">Student</label>
          <select id="Username" name="Username" required>
            <?
            if ($studentOptions) {
                while ($s = mysqli_fetch_assoc($studentOptions)) {
                    $optionLabel = $s["Surname"] . " " . $s["Firstname"] . " (" . $s["Username"] . ")";
                    echo "<option value='" . $s["Username"] . "'>" . $optionLabel . "</option>";
                }
            }
            ?>
          </select>
        </div>
        <div>
          <label for="Sport">Sport</label>
          <select id="Sport" name="Sport" required>
            <?
            if ($sportOptions) {
                while ($sp = mysqli_fetch_assoc($sportOptions)) {
                    $sportName = $sp["Sport"];
                    echo "<option value='$sportName'>$sportName</option>";
                }
            }
            ?>
          </select>
        </div>
        <div>
          <label for="NumMatches">NumMatches</label>
          <input type="number" id="NumMatches" name="NumMatches" value="0" required/>
        </div>
      </div>
      <input type="submit" name="Action" value="Add"/>
    </form>
  </div>
</main>

<? include "footer.php"; ?>

</body>
</html>
