<?php
/**
 * Created by PhpStorm.
 * User: JohnnyD
 * Date: 5/11/2016
 * Time: 10:37 AM
 */

namespace App\AutoverhuurPattern\Interfaces;


interface Autos_dataInterface {

    public function getAllUsers();

    // public function getUserById($id);
    public function create(array $data,$user,$aantalbeschikbaar);
    public function update(array $aantalbeschikbaar, $user);
    public function getisBeschikbaar($aantP);
    public function getaantalBeschikbaar($aantP);
    public function getBeschikbareAutos();
    public function getAuto($id);
    public function getLatestTime();
    
}

