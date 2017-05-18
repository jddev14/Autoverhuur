<?php
/**
 * Created by PhpStorm.
 * User: JohnnyD
 * Date: 5/11/2016
 * Time: 10:25 AM
 */

namespace App\AutoverhuurPattern\Repositories;
use App\AutoverhuurPattern\Interfaces\Klanten_dataInterface;

use App\Klanten as Klanten;
use Illuminate\Support\Facades\DB;

class EloquentKlanten_dataRepository extends BaseRepository implements Klanten_dataInterface
{
    protected $i;
    protected $klanten;
    
    public function __construct(Klanten $klanten) {
        $this->klanten = $klanten;
    }
    
    public function getAllUsers()

    {

        return Klanten::all();

    }


    public function create(array $data,$user,$aantalbeschikbaar)

    {
     
        
        $id=DB::table('klanten_info')->insertGetId([
            'voornaam'=> $data['voornaam'],
            'achternaam'=> $data['achternaam'],
            'email' => $data['email']
        ]);

        return $id;

    }

    public function checkEmail($email) {
        return DB::table('klanten_info')->where('email', $email)->first();
    }
    
    public function getKlant($id)
    {
        return DB::table('klanten_info')->where('id', $id)->first();
    }

}