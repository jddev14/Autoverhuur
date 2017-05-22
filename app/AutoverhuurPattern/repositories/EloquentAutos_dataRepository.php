<?php
/**
 * Created by PhpStorm.
 * User: JohnnyD
 * Date: 5/11/2016
 * Time: 10:25 AM
 */

namespace App\AutoverhuurPattern\Repositories;
use App\AutoverhuurPattern\Interfaces\Autos_dataInterface;

use App\Autos as Autos;
use Illuminate\Support\Facades\DB;

class EloquentAutos_dataRepository extends BaseRepository implements Autos_dataInterface
{
    protected $i;
    protected $autos;
    
    public function __construct(Autos $autos) {
        $this->autos = $autos;
    }
    
    public function getAllUsers()

    {

        return Autos::all();

    }

    public function create(array $data,$user,$aantalbeschikbaar)

    {
       
        $id=DB::table('autos')->insertGetId([
            'auto_grootte'=> $data['auto_grootte'],
            'is_beschikbaar'=> $data['is_beschikbaar'],
            'courant_huurder_id' => null

        ]);
        
        return $id;

    }
    public function update(array $data,$klant_id,$aantalbeschikbaar){
        $arraysize=sizeof($aantalbeschikbaar);
        
        for($i=0;$i<$arraysize;$i++){
              if(isset($aantalbeschikbaar[$i]->id)){
            $auto_id =  $aantalbeschikbaar[$i]->id;  
            }else{
              $auto_id =  $aantalbeschikbaar[$i];  
            }
        $beschikbaarheid = DB::table('autos')->select('is_beschikbaar')->where('id',$auto_id)->get();    
   
        if($beschikbaarheid[0]->is_beschikbaar === 0){
            
        DB::table('autos')->where('id', $auto_id)->update([
        
            'is_beschikbaar'=> 1,
            'courant_huurder_id' => null

        ]);
        }else{
        DB::table('autos')->where('id', $auto_id)->update([
        
            'is_beschikbaar'=> 0,
            'courant_huurder_id' => $klant_id

        ]);
        }
        }
        return $this->getAutos($aantalbeschikbaar);
    }
  
    public function getisBeschikbaar($passagiers)
    {
        //return Autos::whereRaw('id = (select max(`id`) from weather_data)')->get();
        
        $beschikbaar = DB::table('autos')->where('auto_grootte', $passagiers)->value('is_beschikbaar');
        
        return $beschikbaar;
    }
    
    public function getaantalBeschikbaar($aantP)
    {
       
        switch ($aantP) {
    case $aantP <= 2:
         return $this->KaantalPersonen($aantP); 
      
    case $aantP > 2 && $aantP <= 4:
         return $this->KaantalPersonen($aantP); 
       
    case $aantP > 4 && $aantP <= 7:
         return $this->KaantalPersonen($aantP); 
        
    case $aantP > 7 && $aantP <= 24:
         return $this->GaantalPersonen($aantP); 
       
    default:
        echo "no available cars";
}
        //return Autos::whereRaw('id = (select max(`id`) from weather_data)')->get();
       
    }
    
    function KaantalPersonen($passagiers){
       
        $checkautos = ['auto_grootte' => $passagiers, 'is_beschikbaar' => 1 ];

        $aantalbeschikbaar  = array();
        $autoobject = DB::table('autos')->select('id')->where($checkautos)->first();
        array_push($aantalbeschikbaar, $autoobject);
        if(isset($aantalbeschikbaar)){
         
        
              return $aantalbeschikbaar;
      
      }else{
          return null;  
      }
        return $aantalbeschikbaar;
      
    }

    function GaantalPersonen($aantP){
    $beschikbaar = $this->getBeschikbareAutos();
  

    $aantautos = array();
    $arraysize=sizeof($beschikbaar);
    $aantaloptelsom=0;
    for ($i=0; $i<$arraysize; $i++){
     
      
      $auto = $this->getAuto($beschikbaar[$i]->id); 
      if($aantaloptelsom < $aantP ){
          $aantaloptelsom = $aantaloptelsom + $auto->auto_grootte;
          array_push($aantautos,$auto); 
       
      }else if($aantaloptelsom >= $aantP){
          break;
      }
 

    }
    
      if($aantaloptelsom >= $aantP){
         
        
              return $aantautos;
      
      }else{
          return null;  
      }
   
    }
    
    public function getBeschikbareAutos(){
        return DB::table('autos')->select('id','auto_grootte')->where('is_beschikbaar',1)->get();
    }
    
    public function checkAantalBeschikbaar($selecteerdeautos){
        $autosid = array();
       
         $arraysize=sizeof($selecteerdeautos);
    
    for ($i=0; $i<$arraysize; ){
        $checkautos = ['id' => $selecteerdeautos[$i], 'is_beschikbaar' => 1 ];
        $auto = DB::table('autos')->select('id')->where($checkautos)->first();
        array_push($autosid,$auto->id);
         
        $i++;
    }
   
         $arraysize2=sizeof($autosid);
         
    for ($i=0; $i<$arraysize2; $i++){
       if($autosid == $selecteerdeautos){
          
           return $selecteerdeautos;
       }else{
           return "false";
       }
    }
    }
    
       public function getAutos($autos)
    {
        
        $autosdet = array();
         $arraysize=sizeof($autos);
         
    for ($i=0; $i<$arraysize; $i++){
        if(isset($autos[$i]->auto_id)){
             $id = $autos[$i]->auto_id;
         }else if(isset ($autos[$i]->id)){
             $id = $autos[$i]->id;
         }else{
             $id = $autos[$i];
         }
        $auto = DB::table('autos')->where('id', $id)->first();
        array_push($autosdet,$auto);
    }
    
    return $autosdet;
    }
    
     public function getAuto($id)
    {
         return DB::table('autos')->where('id', $id)->first();
   
    }
       
    public function getLatestTime()
    {
        $lid=DB::table('weather_data')->max('id');
        $lt=DB::table('weather_data')->select('date')->where('id',$lid)->count();

        return $lt;
    }
}