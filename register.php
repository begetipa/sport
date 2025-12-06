<?
session_start();
include "db.php";

$message = "";

$shanyraks = mysqli_query($conn, "SELECT * FROM Shanyraks ORDER BY Shanyrak");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST["Username"]);
    $password = $_POST["Password"];
    $confirm = $_POST["ConfirmPassword"];

    if ($password == $confirm) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $role = mysqli_real_escape_string($conn, $_POST["Role"]);

        $insertUser = "INSERT INTO Users (Username, Password, Role) VALUES ('$username', '$hash', '$role')";
        if (mysqli_query($conn, $insertUser)) {
            $surname = mysqli_real_escape_string($conn, $_POST["Surname"]);
            $firstname = mysqli_real_escape_string($conn, $_POST["Firstname"]);
            $birthday = $_POST["Birthday"];
            $height = $_POST["Height"];
            $gender = mysqli_real_escape_string($conn, $_POST["Gender"]);
            $internat = isset($_POST["Internat"]) ? 1 : 0;
            $class = mysqli_real_escape_string($conn, $_POST["Class"]);
            $shanyrakValue = mysqli_real_escape_string($conn, $_POST["Shanyrak"]);
            $medical = mysqli_real_escape_string($conn, $_POST["MedicalNotes"]);

            if ($surname != "" || $firstname != "") {
                $studentInsert = "INSERT INTO Students (Username, Surname, Firstname, Birthday, Height, Gender, Internat, Class, Shanyrak, MedicalNotes) VALUES ('$username', '$surname', '$firstname', '$birthday', '$height', '$gender', $internat, '$class', '$shanyrakValue', '$medical')";
                mysqli_query($conn, $studentInsert);
            }

            header("Location: login.php");
            exit;
        } else {
            $message = "Could not register user.";
        }
    } else {
        $message = "Passwords do not match.";
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
  <div class="card">
    <h2>Register</h2>
    <? if ($message != "") { echo "<div class='message'>$message</div>"; } ?>
    <form method="post" action="register.php">
      <div class="form-row">
        <div>
          <label for="Username">Username</label>
          <input type="text" id="Username" name="Username" required/>
        </div>
        <div>
          <label for="Role">Role</label>
          <select id="Role" name="Role" required>
            <option value="Student">Student</option>
            <option value="Teacher">Teacher</option>
            <option value="Curator">Curator</option>
          </select>
        </div>
      </div>

      <div class="form-row">
        <div>
          <label for="Password">Password</label>
          <input type="password" id="Password" name="Password" required/>
        </div>
        <div>
          <label for="ConfirmPassword">Confirm Password</label>
          <input type="password" id="ConfirmPassword" name="ConfirmPassword" required/>
        </div>
      </div>

      <h3>Student Details (optional)</h3>
      <div class="form-row">
        <div>
          <label for="Surname">Surname</label>
          <input type="text" id="Surname" name="Surname"/>
        </div>
        <div>
          <label for="Firstname">Firstname</label>
          <input type="text" id="Firstname" name="Firstname"/>
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
      </div>

      <div class="form-row">
        <div>
          <label for="Gender">Gender</label>
          <select id="Gender" name="Gender">
            <option value="">--</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
          </select>
        </div>
        <div>
          <label for="Internat">Internat</label>
          <input type="checkbox" id="Internat" name="Internat"/>
        </div>
      </div>

      <div class="form-row">
        <div>
          <label for="Class">Class</label>
          <input type="text" id="Class" name="Class" placeholder="7A, 10D"/>
        </div>
        <div>
          <label for="Shanyrak">Shanyrak</label>
          <select id="Shanyrak" name="Shanyrak">
            <option value="">--</option>
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

      <input type="submit" value="REGISTER"/>
    </form>
  </div>
</main>

<? include "footer.php"; ?>

</body>
</html>
