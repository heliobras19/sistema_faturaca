<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Fatura</title>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
        .container { width: 100%; max-width: 900px; margin: 0 auto; padding: 20px; }
        .page-header { margin-bottom: 20px; }
        .page-title { font-size: 24px; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-150 { font-size: 1.5em; }
        .text-120 { font-size: 1.2em; }
        .text-110 { font-size: 1.1em; }
        .text-95 { font-size: 0.95em; }
        .text-success-d3 { color: #28a745; }
        .text-secondary-d1 { color: #6c757d; }
        .bgc-primary-l3 { background-color: #d1e7dd; }
        .bgc-default-tp1 { background-color: #f8f9fa; }
        .text-grey-d2 { color: #6c757d; }
        .bgc-default-l4 { background-color: #e9ecef; }
        .text-white { color: #fff; }
        .py-25 { padding-top: 25px; padding-bottom: 25px; }
        .mb-4 { margin-bottom: 1.5rem; }
        .mr-1 { margin-right: 0.25rem; }
        .mx-1px { margin: 0 0.0625rem; }
        .btn { display: inline-block; padding: 0.5rem 1rem; font-size: 1rem; text-align: center; border-radius: 0.25rem; text-decoration: none; }
        .btn-light { background-color: #f8f9fa; color: #6c757d; }
        .btn-info { background-color: #17a2b8; color: #fff; }
        .btn-bold { font-weight: bold; }
        .float-right { float: right; }
    </style>
</head>
<body>
    <div class="container">
        <div class="page-header text-blue-d2">
            <h1 class="page-title text-secondary-d1">
                Fatura
                <small class="page-info">
                    <i class="fa fa-angle-double-right text-80"></i>
                    ID: {{ $fatura->numero_fatura }}
                </small>
            </h1>

            <div class="page-tools">
                <div class="action-buttons">
                    <a class="btn bg-white btn-light mx-1px text-95" href="#" onclick="print()" data-title="Print">
                        <i class="mr-1 fa fa-print text-primary-m1 text-120 w-2"></i>
                        Imprimir
                    </a>
                </div>
            </div>
        </div>

        <div class="container px-0">
            <div class="row mt-4">
                <div class="col-12 col-lg-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center text-150">
                                <span class="text-default-d3">SISTEMA DE FATURAS</span>
                            </div>
                        </div>
                    </div>
                    <!-- .row -->

                    <hr class="row brc-default-l1 mx-n1 mb-4" />

                    <div class="row">
                        <div class="col-sm-6">
                            <div>
                                <span class="text-sm text-grey-m2 align-middle">Para:</span>
                                <span class="text-600 text-110 text-blue align-middle">{{ $fatura->cliente->nome }}</span>
                            </div>
                            <div class="text-grey-m2">
                                <div class="my-1">
                                    {{ $fatura->cliente->endereco }}
                                </div>
                                <div class="my-1"><i class="fa fa-phone fa-flip-horizontal text-secondary"></i> <b class="text-600">{{ $fatura->cliente->telefone }}</b></div>
                            </div>
                        </div>
                        <!-- /.col -->

                        <div class="text-95 col-sm-6 align-self-start d-sm-flex justify-content-end">
                            <hr class="d-sm-none" />
                            <div class="text-grey-m2">
                                <div class="mt-1 mb-2 text-secondary-m1 text-600 text-125">
                                    Fatura
                                </div>

                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">ID:</span> {{ $fatura->numero_fatura }}</div>

                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Data de Emissão:</span> {{ $fatura->data_emissao }}</div>

                                <div class="my-2"><i class="fa fa-circle text-blue-m2 text-xs mr-1"></i> <span class="text-600 text-90">Status:</span> <!-- Badge for invoice status -->
                                <span class="badge badge-pill text-white px-25 {{ $fatura->estado === 'Paga' ? 'bg-success' : 'bg-warning' }}">
                                    {{ $fatura->estado }}
                                </span>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>

                    <div class="mt-4">
                     <div class="row text-600 text-black bgc-default-tp1 py-25">
                        <div class="d-none d-sm-block col-1" style="font-weight: bold;">#</div>
                        <div class="col-9 col-sm-5" style="font-weight: bold;">Descrição</div>
                        <div class="d-none d-sm-block col-4 col-sm-2" style="font-weight: bold;">Qtd</div>
                        <div class="d-none d-sm-block col-sm-2" style="font-weight: bold;">Preço Unitário</div>
                        <div class="col-2" style="font-weight: bold;">Total</div>
                    </div>


                        @php
                            $items = $fatura->itens;
                        @endphp

                        <div class="text-95 text-secondary-d3">
                            @foreach ($items as $index => $item)
                                <div class="row mb-2 mb-sm-0 py-25 {{ $index % 2 == 0 ? '' : 'bgc-default-l4' }}">
                                    <div class="d-none d-sm-block col-1">{{ $index + 1 }}</div>
                                    <div class="col-9 col-sm-5">{{ $item->produto->nome }}</div>
                                    <div class="d-none d-sm-block col-2">{{ $item->quantidade }}</div>
                                    <div class="d-none d-sm-block col-2 text-95">{{number_format( $item->preco_unitario, 2) }}</div>
                                    <div class="col-2 text-secondary-d2">{{ number_format($item->preco_unitario*$item->quantidade, 2) }}</div>
                                </div>
                            @endforeach
                        </div>

                        <div class="row border-b-2 brc-default-l2"></div>

                        <div class="row mt-3">
                            <div class="col-12 col-sm-7 text-grey-d2 text-95 mt-2 mt-lg-0">
                               
                            </div>

                            <div class="col-12 col-sm-5 text-grey text-90 order-first order-sm-last">
                                <div class="row my-2">
                                    <div class="col-7 text-right">
                                        SubTotal
                                    </div>
                                    <div class="col-5">
                                        <span class="text-120 text-secondary-d1">AOA {{ number_format($fatura->valor_total, 2) }}</span>
                                    </div>
                                </div>

                                <div class="row my-2">
                                    <div class="col-7 text-right">
                                        Imposto (14%)
                                    </div>
                                    <div class="col-5">
                                        <span class="text-110 text-secondary-d1">AOA {{ number_format($fatura->impostos, 2) }}</span>
                                    </div>
                                </div>

                                <div class="row my-2 align-items-center bgc-primary-l3 p-2">
                                    <div class="col-5 text-right">
                                        Valor Total
                                    </div>
                                    <div class="col-7">
                                        <span class="text-150 text-success-d3 opacity-2">AOA {{ number_format($fatura->imposto+$fatura->valor_total, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr />
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
