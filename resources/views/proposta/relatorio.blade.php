@extends('layout.principal')

@section('conteudo')
@if(empty($proposta))
Selecione uma proposta
@else

<div data-role="section">        
      <h3>{{$proposta->nome}}</h3>
    <h4>
            
     
 <!-- fim Serviços cadastrados -->
   
</div>
@endif
@stop