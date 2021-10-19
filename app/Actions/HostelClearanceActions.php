<?php

namespace App\Actions;

use App\Database;
use App\Models\HostelClearance;

class HostelClearanceActions
{
    private Database $db;
    protected $errors = [];
    protected $table = 'hostel_clearance';
    protected $allowedMimes = ['jpg', 'png', 'jpg'];

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllSessions()
    {
        $query = "SELECT DISTINCT accomodation_session FROM {$this->table} ORDER BY accomodation_session";
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

    public function findExistingRecords(string $session, array $regNos)
    {
        $query = "SELECT * FROM {$this->table} WHERE accomodation_session =  :session";
        $statement = $this->db->connection()->prepare($query);
        $statement->setFetchMode(\PDO::FETCH_CLASS, HostelClearance::class);
        $statement->execute([
            ':session' => $session
        ]);
        $result = $statement->fetchAll();
        $duplicates = [];
        foreach ($result as $item) {
            if (in_array($item->reg_no, $regNos)) {
                $duplicates[] = $item;
            }
        }
        return $duplicates;
    }

    public function addBatchRecord(array $input)
    {
        if (empty($input['session']) || empty($input['regNos'])) {
            array_push($this->errors, "Enter at least one student record");
            return;
        }
        $values = [];
        foreach ($input['regNos'] as $key =>  $regNo) {
            if (in_array($regNo, $values)) {
                unset($input['regNos'][$key]);
                continue;
            }
            $values['regNo' . $key] = $regNo;
        }
        $existingRecords = $this->findExistingRecords($input['session'], $input['regNos']);
        if (count($existingRecords) !== 0) {
            $this->errors['duplicates'] = $existingRecords;
            return;
        }
        $query = "INSERT INTO {$this->table} (accomodation_session, reg_no) VALUES ";
        $valuesStatement = implode(", ", array_map(function ($key, $item) {
            return "(:session, :regNo{$key})";
        }, array_keys($input['regNos']), array_values($input['regNos'])));
        $query .= $valuesStatement;
        $statement = $this->db->connection()->prepare($query);
        $values[':session'] = $input['session'];
        $statement->execute($values);
        return true;
    }

    public function getStudentsBySession($session)
    {
        $query = "SELECT * FROM {$this->table} WHERE accomodation_session = :session";
        $statement = $this->db->connection()->prepare($query);
        $statement->setFetchMode(\PDO::FETCH_CLASS, HostelClearance::class);
        $statement->execute([':session' => $session]);
        $students = $statement->fetchAll();
        $regNos = array_map(function ($item) {
            return $item->reg_no;
        }, $students);
        $studentRecords = $this->getBatchRecord($regNos);

        return array_map(function ($student) use ($studentRecords) {
            foreach ($studentRecords as $record) {
                if ($record['reg_no'] === $student->reg_no) {
                    $student->hostelRecords[] = $record;
                }
            }
            return $student->hostelRecords;
        }, $students);
    }

    public function getBatchRecord($regNos)
    {
        $valuesStatement = "(" . implode(", ", array_map(function ($key, $item) {
            return ":regNo{$key}";
        }, array_keys($regNos), array_values($regNos))) . ")";
        $values = [];
        foreach ($regNos as $key =>  $regNo) {
            if (in_array($regNo, $values)) {
                unset($regNos[$key]);
                continue;
            }
            $values['regNo' . $key] = $regNo;
        }
        $query = "SELECT * FROM {$this->table} WHERE reg_no IN " . $valuesStatement;
        $statement = $this->db->connection()->prepare($query);
        $statement->setFetchMode(\PDO::FETCH_ASSOC);
        $statement->execute($values);
        return $statement->fetchAll();
    }

    public function storeReceipt(array $filesArray, $session)
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
        $target_dir = "../../public/uploads/hostel-receipts/";
        $fileExtension = strtolower(pathinfo(basename($filesArray["name"]), PATHINFO_EXTENSION));
        $fileName = str_replace('/', '_', $regNo . $session) . '.' . $fileExtension;
        $target_file = $target_dir . $fileName;

        // Check if image file is a actual image or fake image
        $check = (empty($filesArray["tmp_name"])) ? false : getimagesize($filesArray["tmp_name"]);
        if ($check === false) {
            array_push($this->errors, "Selected file is not an image!");
            return;
        }
        // Check file size
        if ($filesArray["size"] > 100000) {
            array_push($this->errors, "Maximum upload size is 100KB!");
            return;
        }
        if (!in_array($fileExtension, $this->allowedMimes)) {
            array_push($this->errors, "Only JPG, JPEG, PNG files are allowed!");
        }
        if (move_uploaded_file($filesArray["tmp_name"], $target_file)) {
            $query = "UPDATE {$this->table} SET receipt_image = :receipt_image WHERE reg_no = :reg_no AND accomodation_session = :session";
            $statement = $this->db->connection()->prepare($query);
            $statement->execute([
                ':reg_no' => $regNo,
                ':receipt_image' => $fileName,
                ':session' => $session
            ]);
            $_SESSION['clearanceRequestCreated'] = 'Your receipt has been uploaded successfully and is awaiting verification.';
            return true;
        }
        array_push($this->errors, "Sorry, there was an error uploading your file.");
        return;
    }

    public function findStudentRecords($regNo)
    {
        $query = "SELECT * FROM {$this->table} WHERE reg_no = :reg_no";
        $statement = $this->db->connection()->prepare($query);
        $statement->setFetchMode(\PDO::FETCH_CLASS, HostelClearance::class);
        $statement->execute([':reg_no' => $regNo]);
        return $statement->fetchAll();
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
