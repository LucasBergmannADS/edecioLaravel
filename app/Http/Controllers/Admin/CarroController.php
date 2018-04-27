<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Carro;
use App\Marca;
use Illuminate\Support\Facades\Auth;


class CarroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (!Auth::check()) {
       return redirect ("/home");
    // The user is logged in...
}

        $dados = Carro::paginate(3);

        $soma = Carro::sum('preco');

        return view('admin.carros_list', ['carros' => $dados, 'soma' => $soma]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // informações auxiliares que serão utilizadas no form de cadastro
        $marcas = Marca::orderBy('nome')->get();        
        $combust = Carro::combust();

        return view('admin.carros_form', 
                    ['marcas'=>$marcas, 'comb'=>$combust, 'acao' => 1]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'modelo' => 'min:2|max:40',
            'ano' => 'numeric|min:1970|max:2020',
            //'preco' => 'numeric|min:1000|max:1000000'    
        ]);

        // obtém todos os campos do formulário
        $dados = $request->all();

        $inc = Carro::create($dados);

        if ($inc) {
            return redirect()->route('carros.index')
                   ->with('status', $request->modelo . ' inserido com sucesso!');     
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // posiciona no registro a ser alterado e obtém seus dados
        $reg = Carro::find($id);

        $marcas = Marca::orderBy('nome')->get();

        $combustiveis = Carro::combust();
        
        return view('admin.carros_form', ['reg' => $reg, 'marcas' => $marcas, 
                                          'acao' => 2,
                                          'comb' => $combustiveis]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // obtém os dados do form
        $dados = $request->all();

        // posiciona no registo a ser alterado
        $reg = Carro::find($id);

        // realiza a alteração
        $alt = $reg->update($dados);

        if ($alt) {
            return redirect()->route('carros.index')
                            ->with('status', $request->modelo . ' Alterado!');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car = Carro::find($id);
        if ($car->delete()) {
            return redirect()->route('carros.index')
                            ->with('status', $car->modelo . ' Excluído!');
        }
    }
}
