<?php
/**
 * Created by PhpStorm.
 * User: JohnnyD
 * Date: 5/11/2016
 * Time: 10:37 AM
 */

namespace App\AutoverhuurPattern\Interfaces;


interface Huren_dataInterface {

    public function getAllHuren();

    public function create(array $data,$user,$aantalbeschikbaar);
    public function getHOAutos($id);

}

