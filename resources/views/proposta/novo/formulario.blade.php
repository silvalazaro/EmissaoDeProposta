@extends('layout.principal')

@section('conteudo')
@if(empty($servicos))
falha
@else


<div data-role="section">        
    
    <h3>Nova proposta - {{$cliente['nome']}}</h3>
    <br><br>
    {!! Form::open(array('action' => 'PropostaController@adiciona', 'class' => 'form', 'files'=>true)) !!}
    {{Form::label('Título da Proposta')}}
    {!! Form::text('nome', null, 
    array('required', 
    'class'=>'form-control', 
    'placeholder'=>'Dê um título à proposta')) !!} 
    <input type="hidden" name="id_cliente" value="1">
    <label for="descricao">Descrição</label>
    {!! Form::textarea('descricao', null, 
    array('class'=>'form-control', 
    'placeholder'=>'Se necessário, digite uma breve descrição')) !!} 

    <!-- Serviços -->    
    
    <fieldset data-role="controlgroup">        
        <table class="table table-striped table-bordered table-hover">
            <tr>	 
                <th>ESCOLHA OS SERVIÇOS</th>                
                <th>PREÇO</th>          
            </tr>
            @foreach($servicos as $s)
            <tr>
                <td>
                    <label>
                        <input name="servicos_escolhidos[]" type="checkbox" value="{{$s->id}}">
                        {{$s->nome}}
                    </label>
                </td>            
                <td> <label>{{$s->preco}}</label></td>                
            </tr>
            @endforeach
        </table>
    </fieldset>
   

    <div class="form-group">        
        <button type="submit" data-position-to="window" id="btn-submit">
           CONFIRMAR
        </button>       
    </div>
    
</div>
@endif
@stop