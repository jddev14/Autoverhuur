<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use App\AutoverhuurPattern\Gateway\Auto_DataGateway;

class AutosController extends Controller
{
    /**
     * Display a listing of the available cars.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function __construct(Auto_DataGateway $autodata)
    {

        $this->autodata = $autodata;
        
    }
    
    public function index()
    {
       $data = $this->autodata->BeschikbareAutos();
        if ($data['status'] == 'success') {
            return $data;

        }else{
            return  Response::json(array(
                'status' => 'error',
                'message' => $data['message']
        ));
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
