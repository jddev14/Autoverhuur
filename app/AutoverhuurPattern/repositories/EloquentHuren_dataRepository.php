<?php
/**
 * Created by PhpStorm.
 * User: JohnnyD
 * Date: 5/11/2016
 * Time: 10:25 AM
 */

namespace App\AutoverhuurPattern\Repositories;
use App\AutoverhuurPattern\Interfaces\Huren_dataInterface;
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
    
    public function __construct(Huren $huren, Kwitantie_I $kwitantie) {
        $this->huren = $huren;
        $this->kwitantie = $kwitantie;
    }
    
    public function getAllUsers()

    {

        return Huren::all();

    }


    public function create(array $data,$user,$aantalbeschikbaar)

    {
 $arraysize=sizeof($aantalbeschikbaar);
 $kwitantie_id = $this->kwitantie->create($data,$user,$aantalbeschikbaar);
 print_r($kwitantie_id);
        for($i=0;$i<$arraysize;$i++){
             DB::table('huren')->insert([

                 'kwitantie_id'=>  $kwitantie_id,
                 'auto_id' => $aantalbeschikbaar[$i]->id,
                 'prijs' => $aantalbeschikbaar[$i]->prijs
                 
             ]);
        }
    

    }

    public function getHuurOvereenkomst($id)
    {
        return DB::table('huren')->where('id', $id)->first();
    }

   
}