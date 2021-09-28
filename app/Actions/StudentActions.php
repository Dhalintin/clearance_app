<?php

namespace App\Actions;

use App\Database;
use App\Models\Student;

class StudentActions
{
    private Database $db;
    protected $errors = [];
    protected $table = "students";

    public function __construct() {
        $this->db = new Database();
    }

    public function getErrors() {
        return $this->errors;
    }

    public function register(array $input) {
        if (empty($input['regNo']) || empty($input['password']) || empty($input['clearancePin'])) {
            array_push($this->errors, "All fields are required");
            return;
        }

        if (strlen($input['password']) < 8) {
            array_push($this->errors, "Password is too short!");
            return;
        }

        $existingStudent = $this->findByRegNo($input['regNo']);

        if ($existingStudent) {
            array_push($this->errors, "You have started clearance already!");
            return;
        }

        $pinValidator = new ClearancePinActions();
        $pin = $pinValidator->validate($input['clearancePin']);
        if (!$pin) {
            array_push($this->errors, "Enter a valid pin!");
            return;
        }

        $query = "INSERT INTO students (reg_no, clearance_pin, password, created_at) VALUES(:reg_no, :clearance_pin, :password, NOW())";
        $statement = $this->db->connection()->prepare($query);
        $statement->execute(['reg_no' => $input['regNo'], 'clearance_pin' => $input['clearancePin'], 'password' => password_hash($input['password'], PASSWORD_DEFAULT)]);
        $pinValidator->setAsUsed($pin->pin_no);
        $_SESSION['student'] = $input['regNo'];
        return true;
    }

    public function login(array $input) {
        if (empty($input['regNo']) || empty($input['password'])) {
            array_push($this->errors, "All fields are required");
            return;
        }

        $student = $this->findByRegNo($input['regNo']);

        if ($student) {
            if (!password_verify($input['password'], $student->password)) {
                array_push($this->errors, "Incorect details");
            } else {
                $_SESSION['student'] = $input['regNo'];
                header("Location: /student/dashboard.php");
                exit();
            }
        } else {
            array_push($this->errors, "Your records were not found");
        }
        return;
    }

    public function findByRegNo($regNo) {
        $query = "SELECT * FROM {$this->table} WHERE reg_no = :reg_no";
        $statement = $this->db->connection()->prepare($query);
        $statement->setFetchMode(\PDO::FETCH_CLASS, Student::class);
        $statement->execute(['reg_no' => $regNo]);
        return $statement->fetch();
    }
}