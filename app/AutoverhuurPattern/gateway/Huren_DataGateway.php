<?php

namespace App\AutoverhuurPattern\Gateway;

//use App\Kairos_rpattern\Repositories\EloquentWeather_dataRepository;
use App\AutoverhuurPattern\Interfaces\Huren_dataInterface;
use App\AutoverhuurPattern\Interfaces\Klanten_dataInterface;
use App\AutoverhuurPattern\Interfaces\Kwitantie_dataInterface;
use App\AutoverhuurPattern\Interfaces\Autos_dataInterface;
use Illuminate\Support\Facades\Mail as Mail;
use App\Mail\BestellingVerzonden;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;

class Huren_DataGateway
{
    public function __construct(Huren_dataInterface $hdi, Klanten_dataInterface $kdi, Autos_dataInterface $adi, Kwitantie_dataInterface $kwdi )
    {

        $this->hdi= $hdi;
        $this->kdi= $kdi;
        $this->adi= $adi;
        $this->kwdi = $kwdi;
    }


    public function create($data) {
        
        /**
         *
         *kijk naar beschikbaarheid
         */
       
            if(isset($data['aantalbeschikbaar'])){
                  $aantalbeschikbaar = $data['aantalbeschikbaar']; 
            }else{
                $aantalbeschikbaar = $this->adi->getaantalBeschikbaar($data['aantal_personen']); 
                
            }
          
            if(isset($aantalbeschikbaar[0])){
                     
                $blank = 'just to put something'; 
                $already_user = $this->kdi->checkEmail($data['email']);
                    if($already_user){
                    $checkdays = $this->CheckDays($already_user);  
                    if($checkdays>14){
                        print_r($checkdays);
                         $user =  $already_user;                  
                    }else{
                         return array('status' => 'error', 'message' => 'there must be an interval of 14 days to rent again. Current interval: '.$checkdays.' days');
                    }
                    }else{
                    $user = $this->showKlant($this->kdi->create($data,$blank,$aantalbeschikbaar));
                    }
                $klant_id = $user->id;
                $huurovereenkomst = $this->showHuurOvereenkomst($this->hdi->create($data,$klant_id,$aantalbeschikbaar));
                $this->adi->update($data,$klant_id,$aantalbeschikbaar);  
                
                $autos = $this->showHOAutos($huurovereenkomst->id);
                $autosdet = $this->showAuto($autos);
                Mail::to($user)->send(new BestellingVerzonden($user, $huurovereenkomst, $autosdet));
                
                     	if(count(Mail::failures()) > 0){
            
                           return array('status' => 'error', 'message' => Mail::failures());

			} else {
                           return array('status' => 'success', 'data' =>Response::json( [
          
                            'HuurOvereenkomst' => [
                            'voornaam' => $user->voornaam,
                            'achternaam'=> $user->achternaam,
                            'Email'=> $user->email,
                                'Kwitantie'=> [
                                    'aantal_personen'=> $huurovereenkomst->aantal_personen,
                                    'aantal_dagen'=> $huurovereenkomst->aantal_dagen,
                                    'datum_ingehuurd'=> $huurovereenkomst->datum_ingehuurd,
                                    'datum_inlevering'=> $huurovereenkomst->datum_inlevering,
                                    'totaal_bedrag'=> $huurovereenkomst->totaal_bedrag,
                                    'autos'=> $this->KWAutos($autosdet)

                                ]
                           ]]));

			}
            }else{
             return array('status' => 'error', 'message' => 'there are not enough cars to proceed your order');             
            }
             
    }
    
    public function KWAutos($autosdet){
        $arraysize=sizeof($autosdet);
        $kwautos = array();
        for($i = 0;$i<$arraysize;$i++){
            $kwauto = array(
                'auto_'.$i => array(
                           'auto_groote'=> $autosdet[$i]->auto_grootte,
                           'prijs' => $autosdet[$i]->prijs
                           )
            );
            array_push($kwautos, $kwauto);
                        }
                     
                        return $kwautos;
    }
    public function showAuto($autos) {
        
        $auto = $this->adi->getAutos($autos);
        
        return $auto;
    }
    public function showKlant($id) {

        $klant = $this->kdi->getKlant($id);
    
        return $klant;
    }
    public function showHOAutos($id) {

       
        $huurO = $this->hdi->getHOAutos($id);
            
        return $huurO;
    }
    public function showHuurOvereenkomst($id) {

       
        $huurO = $this->kwdi->getHuurOvereenkomst($id);
            
        return $huurO;
    }
    
    public function CheckDays($user) {
    $getlastdate = $this->kwdi->getLastDate($user);    
    $lastdate = Carbon::parse($getlastdate);
    $now = Carbon::now('America/Curacao');

    $diff = $lastdate->diffInDays($now); 
    return $diff;
    }
}
