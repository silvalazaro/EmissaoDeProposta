@extends('layout.principal')

@section('conteudo')
@if(empty($servicos))
falha
@else


<div data-role="section">        
	
<h1>Nova proposta</h1>
{{Form::label('Título da Proposta')}}
{!! Form::text('nome', null, 
        array('required', 
        'class'=>'form-control', 
'placeholder'=>'Dê um título à proposta')) !!} 

{{Form::label('Descrição')}}
{!! Form::text('descricao', null, 
        array('required', 
        'class'=>'form-control', 
'placeholder'=>'Se necessário, digite uma breve descrição')) !!} 

<select name="seguimento" id="seguimento">
	<option value=""></option>
	@foreach($seguimentos as $key => $value)
	<option class="seguimento">{{$value}}</option>
	@endforeach
 </select>


  <select name="servico" id="servico">
	<option value=""></option>
	@foreach($servicos as $s)
	<option class="{{$s->seguimento}}" value="{{$s->id}}" >{{$s->nome}}</option>
	@endforeach
 </select>

<!-- Serviços cadastrados -->
@if(empty($proposta_servico))
  <div class="alert alert-danger">
    Nenhum serviço adicionado.
  </div>
 
 @else
  <h2>{{$discente->name}}</h2>
  <table class="table table-striped table-bordered table-hover">
      <tr>	 
          <th>Nome</th>
          <th>E-mail</th>
          <th>Login</th>
          <th>Telefone</th>
          <th>Informacoes</th>
		  <th>Acao</th>
      </tr>
      
    <tr class="{{$discente->telefone<=1 ? 'danger' : '' }}">
      <td> {{$discente->name}} </td>   
	  <td> {{$discente->email}} </td>
	  <td> {{$discente->login}} </td>
	  <td> {{$discente->telefone}} </td>
	  <td> {{$discente->informacoes}} </td>
      
      <td> 
	   <a href="{{action('UsuarioController@mostra', $discente->id)}}"> 
          <span class="glyphicon glyphicon-trash">Alterar</span>
        </a>
        <a href="{{action('UsuarioController@remove', $discente->id)}}"> 
          <span class="glyphicon glyphicon-trash">Remover</span>
        </a>
		
      </td>
    </tr>
   
  </table>
 @endif
<!-- fim Serviços cadastrados -->
<input type="text" id="nome" value="">
</form>	
</div>
@endif
@stop