<?php
/**
 * Created by PhpStorm.
 * User: JohnnyD
 * Date: 5/11/2016
 * Time: 10:37 AM
 */

namespace App\AutoverhuurPattern\Interfaces;


interface Kwitantie_dataInterface {

    public function getAllUsers();

   // public function getUserById($id);
    public function create(array $data,$user,$aantalbeschikbaar);
    public function getHuurOvereenkomst($id);
    public function getLastDate($user);
    public function update(array $data,$id,$aantalbeschikbaar);
   // public function getLatestTime();
}

