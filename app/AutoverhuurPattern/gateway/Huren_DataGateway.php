<?php

namespace App\AutoverhuurPattern\Gateway;

//use App\Kairos_rpattern\Repositories\EloquentWeather_dataRepository;
use App\AutoverhuurPattern\Interfaces\Huren_dataInterface;
use App\AutoverhuurPattern\Interfaces\Klanten_dataInterface;
use App\AutoverhuurPattern\Interfaces\Autos_dataInterface;
use Illuminate\Support\Facades\Mail as Mail;
use App\Mail\BestellingVerzonden;
use Illuminate\Support\Facades\Response;


class Huren_DataGateway
{
    public function __construct(Huren_dataInterface $hdi, Klanten_dataInterface $kdi, Autos_dataInterface $adi)
    {

        $this->hdi= $hdi;
        $this->kdi= $kdi;
        $this->adi= $adi;
    }


    public function create($data) {
        
        /**
         *
         *kijk naar beschikbaarheid
         */

       $aantalbeschikbaar = $this->adi->getaantalBeschikbaar($data['aantal_personen']);

      
            if($aantalbeschikbaar){
                        
                $blank = 'just to put something';   
                $user = $this->showKlant($this->kdi->create($data,$blank,$aantalbeschikbaar));
                $klant_id = $user->id;
                $huurovereenkomst = $this->showHuurOvereenkomst($this->hdi->create($data,$klant_id,$aantalbeschikbaar));
                print_r($huurovereenkomst);
                $this->adi->update($aantalbeschikbaar,$klant_id);     
                $auto = $this->showAuto($huurovereenkomst->auto_id);
                Mail::to($user)->send(new BestellingVerzonden($user, $huurovereenkomst, $auto));
            }else{
              echo ': ';     
              echo 'car is not available';                
            }
       
       
    }
    
    public function showAuto($id) {
        
        $auto = $this->adi->getAuto($id);
        
        return $auto;
    }
    public function showKlant($id) {

        $klant = $this->kdi->getKlant($id);
    
        return $klant;
    }
    public function showHuurOvereenkomst($id) {

       
        $huurO = $this->hdi->getHuurOvereenkomst($id);
            
        return $huurO;
    }
}
