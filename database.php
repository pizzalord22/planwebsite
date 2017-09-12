<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
/**
 * Created by PhpStorm.
 * User: Mark
 * Date: 14-2-2017
 * Time: 13:09
 */

/*
 *  add error handling for all functions
 *
*/

require_once('errorHandler_class.php');

class Database
{
    // create vars to use in the functions
    protected $_con;
    protected $_sql;
    protected $_result;
    protected $_projectID;
    protected $startDate;

    // the constructor creates a connection with the database
    function __construct()
    {
        $this->_con = mysqli_connect('localhost', 'root', '', 'planning');
        if (mysqli_connect_errno()) {
            throw new Exception(mysqli_connect_error(), mysqli_connect_errno());
        }
    }

    // select query to get info out of the tables
    function select($select, $table, $where = 'true')
    {
        $this->_sql = 'SELECT ' . $select . '  FROM ' . $table . ' where ' . $where;
        $this->_result = mysqli_query($this->_con, $this->_sql);
    }

    /**
     * this function will show the projects and the task that belong to that project
     */
    function showProject()
    {
        $this->select('*', 'projecten');
        $queryHolder = $this->_result;
        /*$this->_result = mysqli_query($this->_con, $this->_sql);*/
        if ($queryHolder === False) {
            die(mysqli_error($this->_sql));
        }
        while ($row = mysqli_fetch_array($queryHolder)) {
            $this->_projectID = $row['projectID'];
            echo '<div class="col-md-4">';
            echo '<div class="projectWrapper">';
            echo '<div class="projectName">' . $row['projectNaam'] . '</div>';
            $this->showTasks();
            echo '<div class="link"><a href="testFile.php?page=project&projectID=' . $this->_projectID . '">Go to project</a></div>';
            echo '</div>';
            echo '</div>';
        }
    }

    private function showTasks()
    {
        $this->select("taakNaam", "taken", "projectID = " . $this->_projectID);
        if ($this->_result === False) {
            die(mysqli_error($this->_sql));
        }

        while ($row = mysqli_fetch_array($this->_result)) {
            echo '<div class="task">- ' . $row['taakNaam'] . '</div>';
        }
    }

    // update a project or task (wip)
    protected function update($table, $update, $value, $where = 'true')
    {
        $this->_sql = 'UPDATE ' . $table . ' SET ' . $update . ' = ' . $value . ' WHERE ' . $where;
        $this->_result = mysqli_real_escape_string($this->_con, $this->_sql);
    }

    // delete a project or task (wip)
    // if a project is deleted all asociated task should be removed
    protected function delete($table, $key, $value = '')
    {
        $this->_sql = 'DELETE FROM' . $table . ' WHERE ' . $key . ' = ' . $value;
    }

    function date()
    {
        $this->startDate = date('Y-m-d');
        return $this->startDate;
    }
}

class  CreateProject extends Database
{

    function insert($projectNaam, $description, $eindDatum)
    {
        //remove debug info when done
        if (isset($_POST['ProjectName'])) {
            if (isset($_POST['endDate'])) {
                $startDateCheck = new DateTime($this->date());
                $endDateCheck = new DateTime($_POST['endDate']);
                if ($startDateCheck->format('Y-m-d') < $endDateCheck->format('Y-m-d')) {
                    if (isset($projectNaam)) {
                        //debug info
                        echo 'test date comparison... <br/>';
                        echo '~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ <br/>';
                        echo $eindDatum . ' is later then ' . $this->date() . '<br/>';
                        // end of debug info
                        $this->_sql = "INSERT INTO projecten (projectNaam,description,beginDatum,eindDatum)
                        VALUES ('" . $projectNaam . "', '" . $description . "', '" . $this->startDate . "', '" . $eindDatum . "')";
                        if ($this->_con->query($this->_sql) === TRUE) {
                            echo "New record created successfully";
                        } else {
                            echo "Error: " . $this->_sql . "<br>" . $this->_con->error;
                        }
                    }
                }
            }
        } else {
            echo 'something went wrong when processing your query';
        }
        $_POST['projectName'] = '';
    }
}

class createTask extends Database
{
    function insert($projectid, $taskname, $description, $eindDatum, $gebruiker)
    {
        if (isset($_POST['taskName'])) {
            if (isset($_POST['taskDescription'])) {
                if (isset($_POST['startDate'])) {
                    if (isset($_POST['endDate'])) {
                        $startDateCheck = new DateTime($this->date());
                        $endDateCheck = new DateTime($_POST['endDate']);
                        if ($startDateCheck->format('Y-m-d') < $endDateCheck->format('Y-m-d')) {
                            $this->_sql = "INSERT INTO taken (ProjectID, taakNaam, description, beginDatum, eindDatum, gebruiker)
                            VALUES ('" . $projectid . "''" . $taskname . "''" . $description . "''" . $this->date() . "''" . $eindDatum . "''" . $gebruiker . "')";
                            if ($this->_con->query($this->_sql) === TRUE) {
                                echo "New record created successfully";
                            } else {
                                echo "Error: " . $this->_sql . "<br>" . $this->_con->error;
                            }
                        }
                    }
                }
            }
        } else {
            echo 'something went wrong when processing your query';
        }
        $_POST['taskName'] = '';
    }
}

class insertClass extends Database
{
    private $rows;
    private $values;

    private function prepareRows($rows)
    {
        $realInput = explode(" ", $rows);
        $this->rows = '(';
        for ($i = 0; $i < count($realInput); $i++) {
            if ($i == 0) {
                $this->rows .= "`" . $realInput[$i] . "`";
            } else {
                $this->rows .= ", `" . $realInput[$i] . "`";
            }
        }
        $this->rows .= ")";
        echo $this->rows . '<br/>';
        return $this->rows;
    }

    private function prepareValues($values)
    {
        $realInput = explode(" ", $values);
        echo "amount of values: " . count($realInput) . "<br>";
        for ($i = 0; $i < count($realInput); $i++) {
            if ($i != 0) {
                $this->values .= ",\"" . $realInput[$i] . "\"";
                echo 'i = ' . $i . '<br/>';
            } else {
                $this->values .= "\"" . $realInput[$i] . "\"";
                echo 'b = ' . $i . '<br/>';
            }
        }
        $this->values .= ")";
        echo $this->values . '<br/>';
        return $this->values;
    }

    function insert($table, $rows, $values)
    {
        $this->_sql = "INSERT INTO " . mysqli_real_escape_string($this->_con, $table) . " " . mysqli_real_escape_string($this->_con, $this->prepareRows($rows)) . " VALUES (" . mysqli_real_escape_string($this->_con, $this->prepareValues($values));
        if ($this->_con->query($this->_sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $this->_sql . "<br>" /* . $this->_con->error*/
            ;
        }
    }
}

class register extends Database
{
    private $username;
    private $password;

    function passwordCheck($pass, $passCheck)
    {
        if ($pass === $passCheck) {
            $this->password = password_hash(mysqli_real_escape_string($this->_con, $pass), PASSWORD_DEFAULT);
            $x = "password check complete \n passwords: " . $pass . " and " . $passCheck . " do compare";
        } else {
            $x = "something went wrong using: " . $pass . " and " . $passCheck;
        }
        return $x;
    }

    function setUsername($username)
    {
        return $this->username = mysqli_real_escape_string($this->_con, $username);
    }

    function insert($values)
    {
        $this->_sql = "INSERT INTO gebruikers (gebruikersNaam, wachtwoord) VALUES (" . $values . ")";
    }

    function createUser($username, $pass, $passCheck)
    {
        $this->passwordCheck($pass, $passCheck);
        $this->setUsername($username);
        $this->insert("'" . $this->username . "','" . $this->password . "'");
        if ($this->_con->query($this->_sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $this->_sql . "<br>" . $this->_con->error;
        }
    }
}

class login extends Database
{
    private $password;

    private function Loginselect($username)
    {
        $this->select("password", "gebruikers", "gebruikersNaam = '\" . mysqli_real_escape_string($this->_con, $username) . \"'");
        if ($this->_result->num_rows > 0) {
            while($row = mssql_fetch_assoc($this->_result)){
                $this->password = $row['password'];
            }
            /*while ($row = $this->_result->fetch_assoc()) {
                $this->password = $row['password'];
            }*/
        } else {
            echo "<span style=\"color:red;\">ERROR</span> username not found";
        }

    }

    /*
     *  function select($row, $table, $where = "null"){
     *      $this->_sql = "SELECT ".$row." FROM ".$table." WHERE ".$where;
     *  }
    */
    function userLogin($username, $password)
    {
        $this->Loginselect($username);
        if (password_verify($password, $this->password)) {
            $_SESSION["login"] = True;
            echo "login successful";
        } else {
            echo "login failed username:" . $username . " or password is wrong";
        }
    }
}

class logout extends Database
{
    function userLogout()
    {
        $_SESSION["login"] = false;
    }
}


/*$preparedRows = '(' . implode(', ', array_map(function($element) {
        return '`' . $element . '`';
    }, $realInput)) . ')';*/