<?php
/**
 * Created by PhpStorm.
 * User: JohnnyD
 * Date: 5/9/2016
 * Time: 1:20 AM
 */

namespace App;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Kwitantie extends Eloquent {
    protected $table = 'kwitantie';
    // MASS ASSIGNMENT -------------------------------------------------------
    // define which attributes are mass assignable (for security)
    // we only want these 3 attributes able to be filled
    protected $fillable = ['klant_id','auto_id','aantal_personen','aantal_dagen','datum_ingehuurd', 'datum_ingeleverd','datum_inlevering','totaal_bedrag'];

}
