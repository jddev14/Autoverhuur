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


  
    
    public function BeschikbareAutos() {
        
         $aantalbeschikbaar = $this->adi->getBeschikbareAutos();
         $autosdet = $this->showAuto($aantalbeschikbaar);
         if($autosdet){
     		
                           return array('status' => 'success', 'data' =>Response::json( [
          
                              
                                        'autos'=> $autosdet

  
                           ]));

			}else{
                      return array('status' => 'error', 'message' => 'Failed to load auto\'s!');         
      }
    }
   
    
  
    
   
}
