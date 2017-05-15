<?php
/**
 * Created by PhpStorm.
 * User: JohnnyD
 * Date: 5/11/2016
 * Time: 10:37 AM
 */

namespace App\AutoverhuurPattern\Interfaces;


interface Klanten_dataInterface {

    public function getAllUsers();

   // public function getUserById($id);
    public function create(array $klant,$user,$aantalbeschikbaar);
    public function getKlant($id);
   // public function getLatestTime();
}

