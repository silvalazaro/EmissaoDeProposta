<?php

namespace qualitex\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use qualitex\Http\Requests;
use qualitex\Servico;
use qualitex\Proposta;
use Illuminate\Support\Facades\Input;

class PropostaController extends Controller {

    // teste
    public function novo() {
        $dados = null;
        $dados['cliente']['nome'] = "joao";
        $dados['seguimentos'] = Servico::getSeguimentos();
        $dados['servicos'] = $this->getListaServicos();
        return view('proposta.novo.formulario')->with($dados);
    }

    // teste
    private function getDadosParaFormulario() {
        $dados = [];
        $dados['cliente']['nome'] = "joao";
        $dados['seguimentos'] = Servico::getSeguimentos();
        $dados['servicos'] = $this->getListaServicos();
        return $dados;
    }

    // ok
    private function requestSalvaProposta() {

        // obtem dados formulario
        $form = $this->getDadosFormularioRequest();


        // cria e preenche proposta
        $proposta = new Proposta();
        $proposta->nome = $form['nome'];
        $proposta->id_cliente = $form['id_cliente'];
        $proposta->descricao = $form['descricao'];
        // vencimento data atual mais 60 dias
        $proposta->vencimento = date('Y-m-d', strtotime("+60 days", strtotime(date('Y-m-d'))));

        // salva proposta e obtem id
        $proposta->save();

        // salva dados dos servicos
        $this->salvaPropostaServico($proposta->id, $form['servicos_escolhidos']);

        // define estado iniciao
        $this->defineStatus($proposta->id, 'EM ELABORAÇÃO');

        return $proposta->id;
    }

    // ok
    public function defineStatus($id_proposta, $status) {
        DB::table('historico_propostas')
                ->insert(['id_propostas' => $id_proposta, 'status' => $status,
                    'data' => date('Y-m-d'), 'usuario_editor' => 1]);
    }

    // ok
    private function salvaPropostaServico($id_proposta, $arrayServicosID) {

        $servicos = ServicoController::getServicosFiltroIDs($arrayServicosID);
        foreach ($servicos as $s) {
            if ($s)
                DB::table('servicos_propostas')
                        ->insert(['id_propostas' => $id_proposta, 'id_servicos' => $s->id,
                            'preco' => $s->preco]);
        }
    }

    // ok
    private function getDadosFormularioRequest() {
        $form = [];
        $form['nome'] = Input::get('nome');
        $form['id_cliente'] = Input::get('id_cliente');
        $form['descricao'] = Input::get('descricao');
        $form['servicos_escolhidos'] = Input::get('servicos_escolhidos');

        $dados_preenchidos = true;

        foreach ($form as $f)
            if (empty($f))
                return false;
        return $form;
    }

    // teste
    public function adiciona() {
        $dados = null;
        $id_proposta = $this->requestSalvaProposta();

        return redirect()->action('PropostaController@altera', ['id' => $id_proposta]);
    }

    public function altera($id = null) {

        if (!$id)
            return null;
        $proposta = $this->findProposta($id);

        return view('proposta.novo.verifica')->with('proposta', $proposta);
    }

    public function findProposta($id) {

        $proposta = Proposta::find($id);

        $this->atualizaCampos($proposta);

        return $proposta;
    }

    // ok
    public function atualizaCampos(Proposta $proposta) {
        $proposta->historico = $this->getHistorico($proposta->id);
        $proposta->servicos = $this->getServicos($proposta->id);
    }

    public function getHistorico($id_proposta) {
        $historico_proposta = DB::table('historico_propostas')
                ->join('users', 'users.id', '=', 'historico_propostas.usuario_editor')
                ->select('status', 'data', 'users.name as editor')
                ->where('historico_propostas.id_propostas', '=', $id_proposta)
                ->orderBy('data', 'desc')
                ->get();
        return $historico_proposta;
    }

    public function getServicos($id_proposta) {

        $sevicos_proposta = DB::table('servicos_propostas')
                ->join('servicos', 'servicos.id', '=', 'servicos_propostas.id_servicos')
                ->select('servicos_propostas.preco as preco', 'servicos.id as id', 'servicos.nome as nome', 'servicos.seguimento as seguimento')
                ->where('servicos_propostas.id_propostas', '=', $id_proposta)
                ->get();

        return $sevicos_proposta;
    }

    public function getListaServicos() {
        $servicos = DB::table('servicos')
                ->select()
                ->get();
        if (!$servicos)
            return null;
        return $servicos;
    }

    public function getProposta() {
        
    }

    public function criaPropostaRequest() {
        
    }

    public function adicionaServicoForm($proposta) {

        $dados['proposta'] = $proposta = $this->findProposta($proposta);
        $dados['servicos'] = ServicoController::getServicosExceto(ServicoController::arraySomenteIDs($proposta->servicos));
        return view('proposta.novo.adicionarServicos')->with($dados);
    }

    public function setPendenteDeAprovacao($proposta) {

        $status = $this->getHistorico($proposta);
        if ($status)            
                $this->defineStatus($proposta, 'PENDENTE DE APROVAÇÃO');

        return redirect()->action('PropostaController@mostra', $proposta);
    }

    public function mostra($proposta) {
        $proposta = $this->findProposta($proposta);

        return view('proposta.visualiza')->with('proposta', $proposta);
    }

    public function adicionaServico($proposta) {
        $servicos = Input::get('servicos_escolhidos');
        $this->salvaPropostaServico($proposta, $servicos);
        return 'ok';

        return view('proposta.novo.adicionarServicos')->with($dados);
    }

    public function removeServico($proposta, $servico) {
        DB::table('servicos_propostas')
                ->where('id_propostas', '=', $proposta)
                ->where('id_servicos', '=', $servico)
                ->delete();

        return redirect()->action('PropostaController@altera', ['id' => $proposta]);
    }

    public function getTipoEstadoProposta() {
        
    }
	public function lista(){
		
	}
	
	// pdf

    public function relatorioPDF($proposta) {
		$proposta = $this->findProposta($proposta);
		
		return view('proposta.relatorio')->with('proposta', $proposta);
		
        $pdf = \App::make('dompdf.wrapper');
		
        $pdf->loadHTML(view('teste'));
		
        return $pdf->stream();
    }

}
