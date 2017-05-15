<?php
/**
 * Created by PhpStorm.
 * User: JohnnyD
 * Date: 5/9/2016
 * Time: 1:20 AM
 */

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;
class Autos extends Eloquent {
    protected $table = 'autos';
    // MASS ASSIGNMENT -------------------------------------------------------
    // define which attributes are mass assignable (for security)
    // we only want these 3 attributes able to be filled
    protected $fillable = ['auto_grootte','is_beschikbaar','prijs','courant_huurder_id'];

}