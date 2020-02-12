<?php
//require_once - include but for one time
require_once 'classes/crud.php';
$myObj = new CRUD;

if (isset($_POST["signup"])) {
    $uname = $_POST["username"];
    $password = $_POST["password"];
    $fname = $_POST["firstname"];
    $lname = $_POST["lastname"];



    $ans = $myObj->insertUser($uname, $password, $fname, $lname);

    if ($ans == 1) {
        header("Location: login.php");
    } else {
        echo "Error.";
    }
} elseif (isset($_POST["login"])) {
    $uname = $_POST["username"];
    $pass = $_POST["password"];
    $myObj->login($uname, $pass);
    //Admin course.php
} elseif (isset($_POST["addcourse"])) {
    $course = $_POST["course"];
    $genreF = $_POST["genreform"];
    $myObj->addCourse($course, $genreF);
} elseif (isset($_POST["addgenre"])) {
    $genre = $_POST["genre"];
    $myObj->addGenre($genre);
} elseif (isset($_POST["AddResourse"])) {

    //Picture -- name is an attribute before a picture attribute 
    $pic = $_FILES["picture"]["name"];
    $target_dir = "upload/";
    //basename - file name
    $target_file = $target_dir . basename($_FILES["picture"]["name"]);
    move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file);

    //Video -- to display + embed URL
    $video = $_POST["video"];
    $id = explode("?v=", $video);
    $VideoEmbed = "https://www.youtube.com/embed/" . $id[1];

    $lessonID = $_POST["LessonID"];
    $ans = $myObj->AddResource($pic, $VideoEmbed, $lessonID);

    if ($ans == 1) {
        move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file);
        header("Location: resources.php");
    } else {
        echo "Error.";
    }
} elseif (isset($_POST["addLessons"])) {
    $lesson = $_POST["lesson"];
    $course = $_POST["course"];
    $myObj->AddLessons($lesson, $course);
} elseif ($_GET['actiontype'] == 'delete') {
    $id = $_GET['id'];
    $myObj->deleteCourse($id);
} elseif ($_GET['actiontype'] == 'deleteR') {
    $id = $_GET['id'];
    $myObj->deleteResources($id);
} elseif (isset($_POST['edit'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $birthday = $_POST['bday'];
    $username = $_POST['uname'];
    $id = $_POST['id'];

    $myObj->updateUser($name, $address, $birthday, $username, $id);
}
