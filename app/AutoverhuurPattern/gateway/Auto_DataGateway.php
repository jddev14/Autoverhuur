<?php

namespace App\AutoverhuurPattern\Gateway;


use App\AutoverhuurPattern\Interfaces\Huren_dataInterface;
use App\AutoverhuurPattern\Interfaces\Klanten_dataInterface;
use App\AutoverhuurPattern\Interfaces\Autos_dataInterface;
use Illuminate\Support\Facades\Response;


class Auto_DataGateway
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

      

       if($aantalbeschikbaar == null){
            echo 'car is not available';
       }else{
            if($aantalbeschikbaar/*m*/){
                        
            $blank = 'just to put something';   
            $user = $this->showKlant($this->kdi->create($data,$blank,$aantalbeschikbaar));
            $klant_id = $user->id;
            $huurovereenkomst = $this->showHuurOvereenkomst($this->hdi->create($data,$klant_id,$aantalbeschikbaar));
            $auto = $this->showAuto($huurovereenkomst->auto_id);
            Mail::to($user)->send(new BestellingVerzonden($user, $huurovereenkomst, $auto));
            }
       }
       
    }
    
    public function BeschikbareAutos() {
        
         $aantalbeschikbaar = $this->adi->getBeschikbareAutos();
        
        return $aantalbeschikbaar;
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
