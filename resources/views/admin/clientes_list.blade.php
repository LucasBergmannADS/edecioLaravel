@extends('adminlte::page')

@section('title', 'Cadastro de Usuarios')

@section('content_header')
    <h1>Cadastro de Usuarios
    <a href="{{ route('users.create') }}" 
       class="btn btn-primary pull-right" role="button">Novo</a>
    </h1>
@endsection

@section('content')

@if (session('status'))
    <div class="alert alert-success">
      {{ session('status') }}
    </div>  
@endif

<table class="table table-striped">
  <tr>
    <th> Id </th>
    <th> Nome </th>
     <th> E-mail </th>
    <th> Ações </th>
  </tr>  
@forelse($clientes as $c)
  <tr>
    <td> {{$c->id}} </td>
    <td> {{$c->nome}} </td>
    <td> {{$c->email}} </td>
    <td> {{date_format($c->created_at, 'd/m/Y')}} </td>
    <td> 
        <a href="{{route('carros.edit', $c->id)}}" 
            class="btn btn-warning btn-sm" title="Alterar"
            role="button"><i class="fa fa-edit"></i></a> &nbsp;&nbsp;
        <form style="display: inline-block"
              method="post"
              action="{{route('usuarios.destroy', $c->id)}}"
              onsubmit="return confirm('Confirma Exclusão?')">
               {{method_field('delete')}}
               {{csrf_field()}}
              <button type="submit" title="Excluir"
                      class="btn btn-danger btn-sm"><i class="far fa-trash-alt"></i></button>
        </form>  
    </td>
  </tr>
  @if ($loop->last)
    <tr>
      <td colspan=8> Soma dos preços dos veículos cadastrados R$: 
        {{number_format($soma, 2, ',', '.')}} </td>
    </tr>  
    <tr>
      <td colspan=8> Preço Médio dos veículos cadastrados R$: 
        {{number_format($c->avg('preco'), 2, ',', '.')}} </td>
    </tr>  
  @endif

@empty
  <tr><td colspan=8> Não há carros cadastrados ou filtro da pesquisa não 
                     encontrou registros </td></tr>
@endforelse
</table>



@endsection



@section('js')
  <script defer src="https://use.fontawesome.com/releases/v5.0.10/js/all.js" integrity="sha384-slN8GvtUJGnv6ca26v8EzVaR9DC58QEwsIk9q1QXdCU8Yu8ck/tL/5szYlBbqmS+" crossorigin="anonymous"></script>
@endsection