<nav>
<?
if (isset($_SESSION["Role"])) {

    if ($_SESSION["Role"] == "Student") {
        echo "<a href='student_matches.php'>My Matches</a><br/>";
    }

    if ($_SESSION["Role"] == "Teacher") {
        echo "<a href='matches.php'>Manage Matches</a><br/>";
        echo "<a href='sports.php'>Manage Sports</a><br/>";
    }

    if ($_SESSION["Role"] == "Curator") {
        echo "<a href='students.php'>Manage Students</a><br/>";
        echo "<a href='shanyraks.php'>Manage Shanyraks</a><br/>";
    }

    echo "<a href='homepage.php'>Home</a><br/>";
    echo "<a href='logout.php'>Logout</a><br/>";

} else {
    echo "<a href='login.php'>Login</a><br/>";
    echo "<a href='register.php'>Register</a><br/>";
}
?>
</nav>
