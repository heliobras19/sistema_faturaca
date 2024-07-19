<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Fatura;
use App\Models\Produto;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
      // Obtém as datas dos filtros, se fornecidas
    $dataInicio = $request->input('data_inicio');
    $dataFim = $request->input('data_fim');

    // Filtra as faturas com base nas datas
    $queryFaturas = Fatura::query();

    if ($dataInicio && $dataFim) {
        $queryFaturas->whereBetween('data_emissao', [$dataInicio, $dataFim]);
    }

    $totalVendas = $queryFaturas->sum('valor_total');
    $totalImpostos = $queryFaturas->sum('impostos');


    // Dados para os gráficos
    if ($dataInicio && $dataFim) {
        $produtos = Produto::whereHas('itensFatura', function($q) use ($dataInicio, $dataFim) {
            $q->whereHas('fatura', function($query) use ($dataInicio, $dataFim) {
                $query->whereBetween('data_emissao', [$dataInicio, $dataFim]);
            });
        })
        ->withCount('itensFatura')
        ->orderBy('itens_fatura_count', 'desc')
        ->take(10)
        ->get();

        $clientes = Cliente::whereHas('faturas', function($query) use ($dataInicio, $dataFim) {
            $query->whereBetween('data_emissao', [$dataInicio, $dataFim]);
        })
        ->withCount('faturas')
        ->orderBy('faturas_count', 'desc')
        ->take(10)
        ->get();
    }else {
        $produtos = Produto::withCount('itensFatura')
            ->orderBy('itens_fatura_count', 'desc')
            ->take(10)
            ->get();

        $clientes = Cliente::withCount('faturas')
            ->orderBy('faturas_count', 'desc')
            ->take(10)
            ->get();

    }
    

    return view('dashboard', compact('totalVendas', 'totalImpostos', 'produtos', 'clientes'));

    }
}
