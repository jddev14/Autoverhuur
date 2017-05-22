<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\AutoverhuurPattern\Gateway\Huren_DataGateway;
use Illuminate\Support\Facades\Input as Input;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File; 

class HurenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    
    public function __construct(Huren_DataGateway $huuro)
    {

        $this->huuro = $huuro;


    }
 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'voornaam' => 'required',
            'achternaam' => 'required',
            'email' => 'required|email',
            'aantal_personen' => 'required|numeric',
            'aantal_dagen' => 'required|numeric|between:3,14',
            'datum_ingehuurd' => 'required|date',
            'datum_inlevering' => 'required|date',
        ]);
        
        if ($validator->fails()) {
            
            $errors = $validator->errors();
            return  Response::json(array(
                'status' => 'error',
                'message' => $errors
        ));
        }
        $data = $this->huuro->create($request->all());

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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->huuro->showdata($id);

        if ($data['status'] == 'success') {
            return  Response::json(array(
                'status' => 'success',
                'data' =>$data));



        }else{
            return  Response::json(array(
            'status' => 'error',
            'message' => $data['message']
        ));
           	}
    }

     public function update(Request $request, $id)
    {
        
         $data = $this->huuro->update($request->all(), $id);
           if ($data['status'] == 'success') {
            return $data;

        }else{
            return  Response::json(array(
                'status' => 'error',
                'message' => $data['message']
        ));
        }
    }

}
