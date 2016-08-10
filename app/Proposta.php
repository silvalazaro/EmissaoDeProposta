<?php

namespace qualitex;

use Illuminate\Database\Eloquent\Model;

class Proposta extends Model {

    public $timestamps = false; //
    
    protected $historico;
    protected $servicos;
    
    protected $fillable = ['nome', 'id_cliente', 'descricao'];
    
}
