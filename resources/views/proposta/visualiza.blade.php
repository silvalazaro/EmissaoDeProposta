@extends('layout.principal')

@section('conteudo')
@if(empty($proposta))
Selecione uma proposta
@else

<div data-role="section">        
      <h3>{{$proposta->nome}}</h3>
    <h4>
            
        <div class="alert alert-danger">
           STATUS - {{$proposta->historico[0]->status}}
        </div>
    </h4>
    
    <br>
    <h4>Serviços incluídos</h4>

    <fieldset data-role="controlgroup">        
        <table class="table table-striped table-bordered table-hover">
            <tr>	 
                <th>SEGUIMENTO</th>                
                <th>SERVIÇO</th>                
                <th>PREÇO</th>                   
            </tr>

            @foreach($proposta->servicos as $s)

            <tr>
                <td>
                    <label>                    
                        {{$s->seguimento}}
                    </label>
                </td>   
                <td>
                    <label>                    
                        {{$s->nome}}
                    </label>
                </td>            
                <td> <label>{{$s->preco}}</label></td>            
            </tr>

            @endforeach
        </table>
    </fieldset>
 <!-- fim Serviços cadastrados -->
   
</div>
@endif
@stop