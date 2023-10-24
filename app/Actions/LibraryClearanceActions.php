<?php

namespace App\Actions;

use App\Database;
use App\Models\LibraryClearance;

class LibraryClearanceActions
{
    private Database $db;
    protected $errors = [];
    protected $table = 'library_clearance';
    protected $allowedMimes = ['jpg', 'png', 'jpg'];

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllSessions()
    {
        $query = "SELECT DISTINCT session FROM {$this->table} ORDER BY session";
        $statement = $this->db->connection()->prepare($query);
        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        $statement->execute();
        return $statement->fetchAll();
    }

    public function setStatus($regNo, $status)
    {
        $query = "UPDATE {$this->table} SET clearance_status = :status WHERE reg_no = :reg_no";
        $statement = $this->db->connection()->prepare($query);
        $statement->execute([':reg_no' => $regNo, ':status' => $status]);
        return true;
    }

    public function getStudentsBySession($session)
    {
        $query = "SELECT * FROM {$this->table} WHERE session = :session";
        $statement = $this->db->connection()->prepare($query);
        $statement->setFetchMode(\PDO::FETCH_CLASS, LibraryClearance::class);
        $statement->execute([':session' => $session]);
        return $statement->fetchAll();
    }

    public function storeLibraryCard(array $filesArray)
    {


        if ($filesArray["error"] === 4 || $filesArray["error"] === 6) {
            array_push($this->errors, "Select an image!");
            return;
        }
        if ($filesArray["error"] === 2) {
            array_push($this->errors, "Maximum upload size is 100KB!");
            return;
        }
        $student = authStudent();
        $regNo = $student->reg_no;
        $target_dir = "../../public/uploads/library-cards/";
        $fileExtension = strtolower(pathinfo(basename($filesArray["name"]), PATHINFO_EXTENSION));
        $fileName = str_replace('/', '_', $regNo) . '.' . $fileExtension;
        $target_file = $target_dir . $fileName;

        // Check if image file is a actual image or fake image
        $check = (empty($filesArray["tmp_name"])) ? false : getimagesize($filesArray["tmp_name"]);

        if ($check === false) {
            array_push($this->errors, "Selected file is not an image!");
            return;
        }
        //Check file size
        // if ($filesArray["size"] > 100000) {
        //     array_push($this->errors, "Maximum upload size is 100KB!");
        //     return;
        // }

        if (!in_array($fileExtension, $this->allowedMimes)) {
            array_push($this->errors, "Only JPG, JPEG, PNG files are allowed!");
        }

        if (move_uploaded_file($filesArray["tmp_name"], $target_file)) {
            $query = "INSERT INTO {$this->table} SET reg_no = :reg_no, library_card_image = :library_card_image, session = :session";
            $statement = $this->db->connection()->prepare($query);
            $statement->execute([
                ':reg_no' => $regNo,
                ':library_card_image' => $fileName,
                ':session' => $student->session
            ]);
            $_SESSION['clearanceRequestCreated'] = 'Your library card has been uploaded successfully and is awaiting verification.';
            return true;
        }
        array_push($this->errors, "Sorry, there was an error uploading your file.");
        return;
    }

    public function findStudent($regNo)
    {
        $query = "SELECT * FROM {$this->table} WHERE reg_no = :reg_no";
        $statement = $this->db->connection()->prepare($query);
        $statement->setFetchMode(\PDO::FETCH_CLASS, LibraryClearance::class);
        $statement->execute([':reg_no' => $regNo]);
        return $statement->fetch();
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
