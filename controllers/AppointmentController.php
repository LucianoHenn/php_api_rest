<?php
class AppointmentController extends BaseController
{   
    private AppointmentModel $model;

    function __construct() {
       $this->model = new AppointmentModel();
   }

    public function findAllByDoctorId()    
    {
        try {   
    
                // Validate id
                if( !array_key_exists("id", $_GET)  || !is_numeric($_GET['id']))
                     $this->sendOutput(json_encode(array('error' => 'Id param must be of type integer')), 
                        array('Content-Type: application/json', 'HTTP/1.1 400 Bad Request')
                    );
                $res = $this->model->getAll($_GET['id']);
                foreach($res as &$appointment){
         
                  $appointment["status"] =  $appointment["status"] == 1 ? "NEW" : ($appointment["status"] == 2 ? "ACCEPTED" : "REJECTED");
               
                }
                
                $responseData = json_encode(["data" => $res]);
                 $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }

            
    }

    public function createNew(){
        $strErrorDesc = '';
        $body = json_decode(file_get_contents('php://input'));


        // first we validate the input
        if (! (bool) strtotime($body->date)){
            $this->sendOutput(json_encode(array('error' => 'Date param must be of a valid date type')), 
                        array('Content-Type: application/json', 'HTTP/1.1 400 Bad Request')
                    );
        }
        if( !is_numeric($body->doctor))
                     $this->sendOutput(json_encode(array('error' => 'Doctor param must be of type integer')), 
                        array('Content-Type: application/json', 'HTTP/1.1 400 Bad Request')
                    );
        if( !isset($body->pacient) || strlen($body->pacient) == 0)
                     $this->sendOutput(json_encode(array('error' => 'Field pacient is required')), 
                        array('Content-Type: application/json', 'HTTP/1.1 400 Bad Request')
                    );
         

            try {

                $appointment = new AppointmentModel();
                $res = $appointment->insert([
                    'doctor' => $body->doctor,
                    'pacient' => $body->pacient,
                    'date' => $body->date
                ]);
                $responseData = json_encode(["Appointment created succesfully",$res]);

            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
   
 
        // send output
        if (!$strErrorDesc) {
            $this->sendOutput(
                $responseData,
                array('Content-Type: application/json', 'HTTP/1.1 200 OK')
            );
        } else {
            $this->sendOutput(json_encode(array('error' => $strErrorDesc)), 
                array('Content-Type: application/json', $strErrorHeader)
            );
        }
    }

    public function updateStatus(){
          try {

                $body = json_decode(file_get_contents('php://input'));


                // VALIDATE INPUTS
                if( !isset($body->appointment_id ))
                     $this->sendOutput(json_encode(array('error' => 'Field apppointment_id needed')), 
                        array('Content-Type: application/json', 'HTTP/1.1 400 Bad Request')
                    );
                if( !is_numeric($body->appointment_id) )
                     $this->sendOutput(json_encode(array('error' => 'Field apppointment_id must be of type integer')), 
                        array('Content-Type: application/json', 'HTTP/1.1 400 Bad Request')
                    );
                if( !isset($body->status))
                     $this->sendOutput(json_encode(array('error' => 'Field status needed')), 
                        array('Content-Type: application/json', 'HTTP/1.1 400 Bad Request')
                    );
                if( $body->status != "ACCEPTED" && $body->status != "REJECTED" )
                     $this->sendOutput(json_encode(array('error' => 'Incorrect value for field status')), 
                        array('Content-Type: application/json', 'HTTP/1.1 400 Bad Request')
                    );
                $res = $this->model->put($body->appointment_id, $body->status);

                if($res == 1){
                    $responseData = json_encode("Appointment updated succesfully");
                      $this->sendOutput(
                    $responseData,
                    array('Content-Type: application/json', 'HTTP/1.1 200 OK')
                      );
                }else{
                    $responseData = json_encode("Couldnt update appointment");
                       $this->sendOutput(
                    $responseData,
                    array('Content-Type: application/json', 'HTTP/1.1 400 ERROR')
                       );
                }
                
          
            } catch (Error $e) {
                $strErrorDesc = $e->getMessage().'Something went wrong! Please contact support.';
                $strErrorHeader = 'HTTP/1.1 500 Internal Server Error';
            }
    }
}