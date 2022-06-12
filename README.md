# php_api_rest
REST API in PHP without any framework


In order to run the project you have to download the whole project and save it into a folder called "api_rest" inside htdocs.

Then you have to import the database directly from the file "rest_api_demo.sql". After that you have to set your local db credentials in
the config.php file inside the inc folder.

Now you are ready to go!


# Endpoints : 

1 - GET '/appointments?id=$doctor_id" => List all the appointments for a specific doctor based on his id.

Params : $doctor_id, type int, required.


2 - POST '/appointments' => Create a new Appointment

Request body example: 
{
   "doctor" : 1, (integer)
   "pacient": "Pedro Caballero", (string)
   "date" : "2022-03-13" (date)
}

3 - PUT 'appointments' => Accept or Reject a specific appointment based on its id.

Request body example: 
{
   "appointment_id" : 1, (integer)
   "status" : "ACCEPTED" (either "ACCEPTED" or "REJECTED")
}
