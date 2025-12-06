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

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST["Username"]);
    $surname = mysqli_real_escape_string($conn, $_POST["Surname"]);
    $firstname = mysqli_real_escape_string($conn, $_POST["Firstname"]);
    $birthday = $_POST["Birthday"];
    $height = $_POST["Height"];
    $gender = mysqli_real_escape_string($conn, $_POST["Gender"]);
    $internat = isset($_POST["Internat"]) ? 1 : 0;
    $class = mysqli_real_escape_string($conn, $_POST["Class"]);
    $shanyrak = mysqli_real_escape_string($conn, $_POST["Shanyrak"]);
    $medical = mysqli_real_escape_string($conn, $_POST["MedicalNotes"]);

    $action = $_POST["Action"];

    if ($action == "Add") {
        $sql = "INSERT INTO Students (Username, Surname, Firstname, Birthday, Height, Gender, Internat, Class, Shanyrak, MedicalNotes) VALUES ('$username', '$surname', '$firstname', '$birthday', '$height', '$gender', $internat, '$class', '$shanyrak', '$medical')";
        mysqli_query($conn, $sql);
    }

    if ($action == "Update") {
        $sql = "UPDATE Students SET Surname='$surname', Firstname='$firstname', Birthday='$birthday', Height='$height', Gender='$gender', Internat=$internat, Class='$class', Shanyrak='$shanyrak', MedicalNotes='$medical' WHERE Username='$username'";
        mysqli_query($conn, $sql);
    }

    if ($action == "Delete") {
        $sql = "DELETE FROM Students WHERE Username='$username'";
        mysqli_query($conn, $sql);
    }
}

$students = mysqli_query($conn, "SELECT * FROM Students ORDER BY Surname, Firstname");
$shanyraks = mysqli_query($conn, "SELECT * FROM Shanyraks ORDER BY Shanyrak");
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
    <h2>Students</h2>
    <table>
      <thead>
        <tr>
          <th>Username</th>
          <th>Surname</th>
          <th>Firstname</th>
          <th>Birthday</th>
          <th>Height</th>
          <th>Gender</th>
          <th>Internat</th>
          <th>Class</th>
          <th>Shanyrak</th>
          <th>Medical Notes</th>
        </tr>
      </thead>
      <tbody>
        <?
        if ($students) {
            while ($row = mysqli_fetch_assoc($students)) {
                echo "<tr>";
                echo "<td>" . $row["Username"] . "</td>";
                echo "<td>" . $row["Surname"] . "</td>";
                echo "<td>" . $row["Firstname"] . "</td>";
                echo "<td>" . $row["Birthday"] . "</td>";
                echo "<td>" . $row["Height"] . "</td>";
                echo "<td>" . $row["Gender"] . "</td>";
                echo "<td>" . ($row["Internat"] ? "Yes" : "No") . "</td>";
                echo "<td>" . $row["Class"] . "</td>";
                echo "<td>" . $row["Shanyrak"] . "</td>";
                echo "<td>" . $row["MedicalNotes"] . "</td>";
                echo "</tr>";
            }
        }
        ?>
      </tbody>
    </table>

    <h3 style="margin-top: 20px;">Add / Update / Delete Student</h3>
    <form method="post" action="students.php">
      <div class="form-row">
        <div>
          <label for="Username">Username</label>
          <input type="text" id="Username" name="Username" required/>
        </div>
        <div>
          <label for="Surname">Surname</label>
          <input type="text" id="Surname" name="Surname" required/>
        </div>
        <div>
          <label for="Firstname">Firstname</label>
          <input type="text" id="Firstname" name="Firstname" required/>
        </div>
      </div>

      <div class="form-row">
        <div>
          <label for="Birthday">Birthday</label>
          <input type="date" id="Birthday" name="Birthday"/>
        </div>
        <div>
          <label for="Height">Height</label>
          <input type="number" step="0.01" id="Height" name="Height"/>
        </div>
        <div>
          <label for="Gender">Gender</label>
          <select id="Gender" name="Gender">
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </div>
      </div>

      <div class="form-row">
        <div>
          <label for="Internat">Internat</label>
          <input type="checkbox" id="Internat" name="Internat"/>
        </div>
        <div>
          <label for="Class">Class</label>
          <input type="text" id="Class" name="Class" placeholder="7A, 10B"/>
        </div>
        <div>
          <label for="Shanyrak">Shanyrak</label>
          <select id="Shanyrak" name="Shanyrak">
            <?
            if ($shanyraks) {
                while ($s = mysqli_fetch_assoc($shanyraks)) {
                    $name = $s["Shanyrak"];
                    echo "<option value='$name'>$name</option>";
                }
            }
            ?>
          </select>
        </div>
      </div>

      <label for="MedicalNotes">Medical Notes</label>
      <textarea id="MedicalNotes" name="MedicalNotes"></textarea>

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
