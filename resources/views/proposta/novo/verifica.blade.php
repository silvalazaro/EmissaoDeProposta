@extends('layout.principal')

@section('conteudo')
@if(empty($proposta))
Selecione uma proposta
@else


<div data-role="section">        

    <h3>PROPOSTA</h3>
    <h3>{{$proposta->nome}}</h3>
    <br>
    <h4>Serviços incluídos</h4>

    <fieldset data-role="controlgroup">        
        <table class="table table-striped table-bordered table-hover">
            <tr>	 
                <th>SEGUIMENTO</th>                
                <th>SERVIÇO</th>                
                <th>PREÇO</th>
                <th>REMOVER</th>          
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
                <td> 
                    <a href="{{action('PropostaController@removeServico', [$proposta->id, $s->id])}}"> 
                        <span class="glyphicon glyphicon-trash"></span>
                    </a>
            </tr>

            @endforeach
        </table>
    </fieldset>


    <!-- fim Serviços cadastrados -->
    <div class="form-group">
        <a href="{{action('PropostaController@adicionaServicoForm', $proposta->id)}}">
            ACRESCENTAR SERVIÇOS
        </a>
    </div>
    <div class="form-group">      
        <a href="{{action('PropostaController@setPendenteDeAprovacao', $proposta->id)}}">
            CONCLUIR PROPOSTA
        </a>
    </div>
</div>
@endif
@stop