<?php
require_once PROJECT_ROOT_PATH . "/models/Database.php";


class AppointmentModel extends Database implements AppointmentInterface
{
    public function getAll($id)
    {   
        // check if exist dr with that id
        if ( count($this->select("SELECT * FROM doctors WHERE id = ? ", ["i", $id])) > 0 )
            return $this->select("SELECT * FROM appointments WHERE doctor_id = ? ", ["i", $id]);
        // otherwise we send an error
        header("HTTP/1.1 400 Bad Request");
                echo json_encode(["error" => "There is no doctor matching that id"]);
                exit();
        
    }

      public function insert(Array $data)
    {
        $statement = "
            INSERT INTO appointments 
                (doctor_id, pacient, date)
            VALUES
                (?, ?, ?);
        ";

            // check if exist dr with that id
        if ( ! count($this->select("SELECT * FROM doctors WHERE id = ? ", ["i",  $data['doctor']])) > 0 )
         {
              header("HTTP/1.1 400 Bad Request");
                echo json_encode(["error" => "There is no doctor matching that id"]);
                exit();
         }
       

        try {
            $statement = $this->connection->prepare($statement);
            $statement->execute([
                $data['doctor'],
                $data['pacient'],
                $data['date'],
            ]);

            $appointmentId = $this->connection->insert_id;

            if($appointmentId)
                {
                $input['id'] = $appointmentId;
                return $input;
                exit();
                }
        } catch (Exception $e) {
            exit($e->getMessage());
        }    
    }

    public function put($id, $data){
        $sql = "UPDATE appointments SET status=? WHERE id=?";
        $stmt= $this->connection->prepare($sql);
        $status = $data == "ACCEPTED" ? 2 : 3;
        $stmt->bind_param("ii", $status, $id);
        $stmt->execute();

        return $this->connection->affected_rows;
    }

}