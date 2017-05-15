<?php
/**
 * Created by PhpStorm.
 * User: JohnnyD
 * Date: 5/11/2016
 * Time: 10:25 AM
 */

namespace App\AutoverhuurPattern\Repositories;
use App\AutoverhuurPattern\Interfaces\Kwitantie_dataInterface;

use App\Huren as Huren;
use Illuminate\Support\Facades\DB;

class EloquentKwitantie_dataRepository extends BaseRepository implements Kwitantie_dataInterface
{
    protected $i;
    protected $huren;
    
    public function __construct(Huren $huren) {
        $this->huren = $huren;
    }
    
    public function getAllUsers()

    {

        return Huren::all();

    }


    public function create(array $data,$user,$aantalbeschikbaar)

    {
echo 'aki mi ta             ';
             $id=DB::table('kwitantie')->insertGetId([

                 'klant_id' => $user,
                 'aantal_personen' => $data['aantal_personen'],
                 'aantal_dagen'=> $data['aantal_dagen'],
                 'datum_ingehuurd' => $data['datum_ingehuurd'],
                 'datum_ingeleverd' => $data['datum_ingeleverd'],
                 'datum_inlevering'=> $data['datum_inlevering'],
                 'totaal_bedrag'=> 500
             ]);
        
        return $id;

    }

    public function getHuurOvereenkomst($id)
    {
        return DB::table('huren')->where('id', $id)->first();
    }

   
}