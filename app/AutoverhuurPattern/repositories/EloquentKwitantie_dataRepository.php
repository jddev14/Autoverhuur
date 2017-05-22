<?php


namespace App\AutoverhuurPattern\Repositories;
use App\AutoverhuurPattern\Interfaces\Kwitantie_dataInterface;

use App\Kwitantie as Kwitantie;
use App\AutoverhuurPattern\Interfaces\Autos_dataInterface as Autos;
use Illuminate\Support\Facades\DB;

class EloquentKwitantie_dataRepository extends BaseRepository implements Kwitantie_dataInterface
{
    protected $i;
    protected $huren;
    
    public function __construct(Kwitantie $kwitantie, Autos $autos) {
        $this->kwitantie = $kwitantie;
        $this->autos =$autos;
    }
    
    public function getAllUsers()

    {

        return Kwitantie::all();

    }


    public function create(array $data,$user,$aantalbeschikbaar)

    {
            $arraysize=sizeof($aantalbeschikbaar);
            $totaalbedrag = 0;
            for($i=0;$i<$arraysize;$i++){
                if(isset($aantalbeschikbaar[$i]->id)){
                $auto_id =  $aantalbeschikbaar[$i]->id;  
                }else{
                  $auto_id =  $aantalbeschikbaar[$i];  
                }

                    $auto = $this->autos->getAuto($auto_id);
                    $totaalbedrag += $auto->prijs;
            }
             $id=DB::table('kwitantie')->insertGetId([

                 'klant_id' => $user,
                 'aantal_personen' => $data['aantal_personen'],
                 'aantal_dagen'=> $data['aantal_dagen'],
                 'datum_ingehuurd' => $data['datum_ingehuurd'],
                 'datum_ingeleverd' => $data['datum_ingeleverd'],
                 'datum_inlevering'=> $data['datum_inlevering'],
                 'totaal_bedrag'=> $totaalbedrag
             ]);
        
        return $id;

    }
  
    public function update(array $data,$id,$aantalbeschikbaar) {
       
        DB::table('kwitantie')->where('id', $id)->update([
        
            'datum_ingeleverd'=> $data['datum_ingeleverd']
        ]);
        $kwitantie = DB::table('kwitantie')->where('id', $id)->first();
        return $kwitantie;
      
    }
    public function getHuurOvereenkomst($id)
    {
        return DB::table('kwitantie')->where('id', $id)->first();
    }

    public function getLastDate($user) {
        return DB::table('kwitantie')->where('klant_id', $user->id)->max('datum_ingehuurd');
    }
   
}