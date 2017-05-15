<?php
/**
 * Created by PhpStorm.
 * User: JohnnyD
 * Date: 5/9/2016
 * Time: 1:20 AM
 */

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;
class Klanten extends Eloquent {
    protected $table = 'klanten_info';
    // MASS ASSIGNMENT -------------------------------------------------------
    // define which attributes are mass assignable (for security)
    // we only want these 3 attributes able to be filled
    protected $fillable = ['voornaam','achternaam', 'email', 'aantal_personen','aantal_dagen'];

}