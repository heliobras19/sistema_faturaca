<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Fatura;
use App\Models\ItemFatura;
use App\Models\Produto;
use Illuminate\Http\Request;

class FaturaController extends Controller
{
        public function index()
    {
        $faturas = Fatura::with('cliente')->get();
        return view('faturas.index', compact('faturas'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $produtos = Produto::all();
        return view('faturas.create', compact('clientes', 'produtos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero_fatura' => 'required|unique:faturas,numero_fatura',
            'data_emissao' => 'required|date',
            'cliente_id' => 'required|exists:clientes,id',
            'estado' => 'required|string',
            'itens.*.produto_id' => 'required|exists:produtos,id',
            'itens.*.quantidade' => 'required|integer|min:1',
        ]);

        $valor_total = 0;
        foreach ($request->itens as $item) {
            $produto = Produto::find($item['produto_id']);
            $valor_total += $produto->preco * $item['quantidade'];
        }

        $impostos = $valor_total * 0.14;

        $fatura = Fatura::create([
            'numero_fatura' => $request->numero_fatura,
            'data_emissao' => $request->data_emissao,
            'cliente_id' => $request->cliente_id,
            'valor_total' => $valor_total,
            'impostos' => $impostos,
            'estado' => $request->estado,
        ]);

        foreach ($request->itens as $item) {
            $produto = Produto::find($item['produto_id']);
            ItemFatura::create([
                'fatura_id' => $fatura->id,
                'produto_id' => $item['produto_id'],
                'quantidade' => $item['quantidade'],
                'preco_unitario' => $produto->preco,
            ]);
        }

        return redirect()->route('faturas.index')->with('success', 'Fatura criada com sucesso.');
    }

    public function show(Fatura $fatura)
    {
        return view('fatura_compra.index', compact('fatura'));
    }

    public function edit(Fatura $fatura)
    {
        $clientes = Cliente::all();
        $produtos = Produto::all();
        return view('faturas.edit', compact('fatura', 'clientes', 'produtos'));
    }

    public function update(Request $request, Fatura $fatura)
    {
        $request->validate([
            'numero_fatura' => 'required|unique:faturas,numero_fatura,' . $fatura->id,
            'data_emissao' => 'required|date',
            'cliente_id' => 'required|exists:clientes,id',
            'estado' => 'required|string',
            'itens.*.produto_id' => 'required|exists:produtos,id',
            'itens.*.quantidade' => 'required|integer|min:1',
        ]);

        $valor_total = 0;
        foreach ($request->itens as $item) {
            $produto = Produto::find($item['produto_id']);
            $valor_total += $produto->preco * $item['quantidade'];
        }

        $impostos = $valor_total * 0.14;
        $valor_total += $impostos;

        $fatura->update([
            'numero_fatura' => $request->numero_fatura,
            'data_emissao' => $request->data_emissao,
            'cliente_id' => $request->cliente_id,
            'valor_total' => $valor_total,
            'impostos' => $impostos,
            'estado' => $request->estado,
        ]);

        $fatura->itens()->delete();
        foreach ($request->itens as $item) {
            $produto = Produto::find($item['produto_id']);
            ItemFatura::create([
                'fatura_id' => $fatura->id,
                'produto_id' => $item['produto_id'],
                'quantidade' => $item['quantidade'],
                'preco_unitario' => $produto->preco
            ]);
        }

        return redirect()->route('faturas.index')->with('success', 'Fatura atualizada com sucesso.');
    }

    public function destroy(Fatura $fatura)
    {
        $fatura->delete();
        return redirect()->route('faturas.index')->with('success', 'Fatura excluída com sucesso.');
    }
}
