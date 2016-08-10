<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

Route::get('/', 'PropostaController@novo');

Route::auth();

Route::get('/teste', function() {
    return view('teste');
});

Route::group(['prefix' => 'proposta', /* 'before' => 'auth' */], function () {

    // funcionando
    Route::get('/nova', ['as' => 'proposta_nova', 'uses' => 'PropostaController@novo']);
    Route::post('/nova', ['as' => 'proposta_adiciona', 'uses' => 'PropostaController@adiciona']);
	Route::get('/lista', ['as' => 'proposta_nova', 'uses' => 'PropostaController@lista']);
    Route::get('/visualiza/{id}', ['as' => 'proposta_situ', 'uses' => 'PropostaController@mostra']);
    Route::get('/verifica/{id}', ['as' => 'proposta_verifica', 'uses' => 'PropostaController@altera']);
    Route::get('/pendenteDeAprovacao/{proposta}/', ['as' => 'proposta_pend_ap', 'uses' => 'PropostaController@setPendenteDeAprovacao']);
    Route::get('/{proposta}/servico/adiciona', ['as' => 'proposta_adiciona_se', 'uses' => 'PropostaController@adicionaServicoForm']);
    Route::post('/{proposta}/servico/adiciona', ['as' => 'proposta_adiciona_po', 'uses' => 'PropostaController@adicionaServico']);
    Route::get('/{proposta}/servico/remove/{servico}', ['as' => 'proposta_nova', 'uses' => 'PropostaController@removeServico']);
    Route::get('/relatorio/pdf/{id}', ['as' => 'proposta_relatorio', 'uses' => 'PropostaController@relatorioPDF']);
});


Route::group(['prefix' => 'servico', /* 'before' => 'auth' */], function () {
    Route::get('/lista', ['as' => 'servicos_lista', 'uses' => 'ServicoController@lista']);
    Route::get('/lista/json', ['as' => 'servico_json', 'uses' => 'ServicoController@listaJSON']);
	Route::get('/novo', ['as' => 'servico_no', 'uses' => 'ServicoController@novo']);
});
Route::get('toys', 'ToyController@listing');

Route::get('/home', 'HomeController@index');
