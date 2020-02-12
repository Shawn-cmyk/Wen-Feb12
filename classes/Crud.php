<?php
session_start();
require_once 'Database.php';

/*extends - whatever is in parent class(public) can be used in child class
- inheritence
- no need to create objects
enctype="multipart/form-data" is to upload photos
*/

class CRUD extends Database
{
    public function insertUser($username, $password, $fname, $lname)
    {
        $new_pass = md5($password);

        $sql = "INSERT INTO users(Username, Password, First_Name, Last_Name)
            VALUES('$username', '$new_pass', '$fname', '$lname')";
        if ($this->conn->query($sql)) {
            return 1;
        } else {
            echo "Insertion failed." . $this->conn->error;
            return 0;
        }
    }

    public function login($uname, $pass)
    {
        $new_pass = md5($pass);

        $sql = "SELECT * FROM users WHERE username ='$uname' AND password ='$new_pass'";
        $result = $this->conn->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $_SESSION["Id"] = $row["Id"];

            if ($row["Status"] == 'U') {
                header("Location: innerindex.php");
            } else {
                header("Location: dashboard.php");
            }
        } else {
            echo "Error. " . $this->conn->error;
        }
    }

    public function getAllcourses()
    {
        $sql = "SELECT * FROM genre INNER JOIN courses ON genre.G_Id = courses.Gen_Id";
        $result = $this->conn->query($sql);

        $row = array(); // initiate array for later use (used inside while loop)
        while ($rows = $result->fetch_assoc()) { //creating while loop to get all of the data inside the database
            $row[] = $rows; //passing the data from the database inside the initiated row array
        }

        return $row; //returning row which holds the data from the database back to function displayUsers
    }

    public function addCourse($course, $genreF)
    {

        $sql = "INSERT INTO courses(Cou_Name, Gen_Id)
            VALUES('$course', '$genreF')";
        if ($this->conn->query($sql)) {
            header("Location: dashboard.php");
        } else {
            echo "Insertion failed." . $this->conn->error;
            return 0;
        }
    }

    public function addGenre($genre)
    {

        $sql = "INSERT INTO genre(G_Name)
            VALUES('$genre')";
        if ($this->conn->query($sql)) {
            header("Location: dashboard.php");
        } else {
            echo "Insertion failed." . $this->conn->error;
            return 0;
        }
    }

    public function getAllgenre()
    {
        $sql = "SELECT * FROM genre";
        $result = $this->conn->query($sql);

        $row = array(); // initiate array for later use (used inside while loop)
        while ($rows = $result->fetch_assoc()) { //creating while loop to get all of the data inside the database
            $row[] = $rows; //passing the data from the database inside the initiated row array
        }

        return $row; //returning row which holds the data from the database back to function displayUsers
    }


    public function getAllcourse()
    {
        $sql = "SELECT * FROM course ";
        $result = $this->conn->query($sql);

        $row = array(); // initiate array for later use (used inside while loop)
        while ($rows = $result->fetch_assoc()) { //creating while loop to get all of the data inside the database
            $row[] = $rows; //passing the data from the database inside the initiated row array
        }

        return $row; //returning row which holds the data from the database back to function displayUsers
    }

    public function getAlllessons()
    {
        $sql = "SELECT * FROM lessons ";
        $result = $this->conn->query($sql);

        $row = array(); // initiate array for later use (used inside while loop)
        while ($rows = $result->fetch_assoc()) { //creating while loop to get all of the data inside the database
            $row[] = $rows; //passing the data from the database inside the initiated row array
        }

        return $row; //returning row which holds the data from the database back to function displayUsers
    }



    public function getAllresources($Cid)
    {
        $sql = "SELECT * FROM resources INNER JOIN lessons ON resources.L_Id = lessons.Les_Id INNER JOIN courses ON courses.Cou_Id = lessons.C_Id WHERE Cou_Id ='$Cid'";
        $result = $this->conn->query($sql);

        $row = array(); // initiate array for later use (used inside while loop)
        while ($rows = $result->fetch_assoc()) { //creating while loop to get all of the data inside the database
            $row[] = $rows; //passing the data from the database inside the initiated row array
        }

        return $row; //returning row which holds the data from the database back to function displayUsers
    }


    public function AddResource($pic, $VideoEmbed, $lessonID)
    {
        $sql = "INSERT INTO resources( Res_Filename, Video, L_Id)
                            VALUES('$pic','$VideoEmbed','$lessonID')";
        if ($this->conn->query($sql)) {
            return 1;
        } else {
            echo "Insertion failed. " . $this->conn->error;
            return 0;
        }
    }

    public function AddLessons($lesson, $course)
    {
        $sql = "INSERT INTO lessons(Les_Name,Cou_Id)
                            VALUES('$lesson', '$course')";
        if ($this->conn->query($sql)) {
            header("Location: resources.php");
        } else {
            echo "Insertion failed." . $this->conn->error;
            return 0;
        }
    }


    public function deleteCourse($id)
    {
        $sql = "DELETE FROM courses WHERE Cou_Id ='$id'";
        $result = $this->conn->query($sql);

        if ($result) {
            header("Location: dashboard.php");
        } else {
            echo "Connection error." . $this->conn->error;
        }
    }

    public function deleteResources($id)
    {
        $sql = "DELETE FROM resources WHERE id ='$id'";
        $result = $this->conn->query($sql);

        if ($result) {
            header("Location: resources.php");
        } else {
            echo "Connection error." . $this->conn->error;
        }
    }

    function getOneUser($id)
    {
        $sql = "SELECT * FROM courses WHERE id = '$id'";
        $result = $this->conn->query($sql);

        $row = $result->fetch_assoc();
        return $row;
    }

    function updateUser($name, $address, $birthday, $username, $id)
    {
        $sql = "UPDATE courses SET name='$name', address='$address', bday='$birthday', username='$username' WHERE id='$id' ";
        $result = $this->conn->query($sql);


        if ($result == FALSE) {
            die('cannot update user' . $this->conn->error);
        } else {
            header('location:dashboard.php');
        }
    }
}
