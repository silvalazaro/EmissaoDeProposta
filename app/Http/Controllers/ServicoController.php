<?php

namespace qualitex\Http\Controllers;

use Illuminate\Http\Request;
use qualitex\Http\Requests;
use qualitex\Servico;
use Illuminate\Support\Facades\DB;

class ServicoController extends Controller {

    public function listaJSON() {
        $servicos = Servico::all();
        return response()->json(["servicos" => $servicos->toArray()
        ]);
    }

    public function lista() {
        return Servico::all();
    }

    public static function getServicosExceto($arrayServicosID) {
        if(!$arrayServicosID)
            return $servicos = Servico::all();
        $servicos = Servico::all()
                ->except($arrayServicosID);
        return $servicos;
    }
    
    public static function arraySomenteIDs($servicos){
        $array = [];
        foreach($servicos as $s){
           array_push($array, $s->id);
        }
        return $array;        
    }
    
    
    public static function getServicosFiltroIDs($arrayServicosID) {       
        $servicos = DB::table('servicos')
                ->select()
                ->whereIn('id', $arrayServicosID)
                ->get();
        return $servicos;
    }
    public function listaPorSeguimento() {
        
    }

}
