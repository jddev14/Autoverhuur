<?php
/**
 * Created by PhpStorm.
 * User: JohnnyD
 * Date: 5/11/2016
 * Time: 10:25 AM
 */

namespace App\AutoverhuurPattern\Repositories;
use App\AutoverhuurPattern\Interfaces\Huren_dataInterface;
use App\AutoverhuurPattern\Interfaces\Autos_dataInterface as Autos;
use App\AutoverhuurPattern\Interfaces\Kwitantie_dataInterface as Kwitantie_I;
use App\Huren as Huren;
use Illuminate\Support\Facades\DB;

class EloquentHuren_dataRepository extends BaseRepository implements Huren_dataInterface
{

    /**
     * @var Kwitante_R
     */
    protected $kwitantie;
    protected $i;
    protected $huren;
    
    public function __construct(Huren $huren, Kwitantie_I $kwitantie, Autos $autos) {
        $this->huren = $huren;
        $this->kwitantie = $kwitantie;
        $this->autos =$autos;
    }
    
    public function getAllUsers()

    {

        return Huren::all();

    }


    public function create(array $data,$user,$aantalbeschikbaar)

    {
 $arraysize=sizeof($aantalbeschikbaar);
 
 $kwitantie_id = $this->kwitantie->create($data,$user,$aantalbeschikbaar);
        for($i=0;$i<$arraysize;$i++){
             $auto = $this->autos->getAuto($aantalbeschikbaar[$i]->id);
             if(isset($aantalbeschikbaar[$i]->id)){
                 DB::table('huren')->insert([

                 'kwitantie_id'=>  $kwitantie_id,
                 'auto_id' => $aantalbeschikbaar[$i]->id,
                 'prijs' => $auto->prijs
                 
             ]);}else{
                 DB::table('huren')->insert([

                 'kwitantie_id'=>  $kwitantie_id,
                 'auto_id' => $aantalbeschikbaar[$i],
                 'prijs' => $auto->prijs
                 
             ]);
             }
        }
    
return $kwitantie_id;
    }

    public function getHOAutos($id)
    {
        return DB::table('huren')->select('auto_id')->where('kwitantie_id', $id)->get();
    }

   
}