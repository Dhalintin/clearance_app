<?php

namespace App\Actions;

use App\Database;
use App\Models\Student;

class StudentActions
{
    private Database $db;
    protected $errors = [];
    protected $table = "students";

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function login(array $input)
    {
        $student = $this->findByRegNo($input['regNo']);
        if ($student) {
            if (!password_verify($input['password'], $student->password)) {
                array_push($this->errors, "Incorect details");
            } else {
                header("Location: /student/dashboard.php");
                exit();
            }
        } else {
            array_push($this->errors, "Your records were not found");
        }
        header("Location: /student/login.php");
        exit();
    }

    public function findByRegNo($regNo)
    {
        $query = "SELECT * FROM {$this->table} WHERE reg_no = :reg_no";
        $statement = $this->db->connection()->prepare($query);
        $statement->setFetchMode(\PDO::FETCH_CLASS, Student::class);
        $statement->execute(['reg_no' => $regNo]);
        return $statement->fetch();
    }
}
