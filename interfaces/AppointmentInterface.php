<?php

interface AppointmentInterface
{
    public function getAll($id);
    public function put($id, $data);
    public function insert(Array $data);
}