<?php

namespace qualitex;

use Illuminate\Database\Eloquent\Model;

class Servico extends Model
{
    public static function getSeguimentos(){
		return ['Análises Ambientais', 'Serviços Operacionais'];
	}
}
