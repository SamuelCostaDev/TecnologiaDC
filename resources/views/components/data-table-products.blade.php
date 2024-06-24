<div class="py-2">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <table id="table" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Referência</th>
                        <th>Tipo</th>
                        <th>Valor de Compra</th>
                        <th>Valor de Venda</th>
                        <th>Estoque Mínimo</th>
                        <th>Código de Barras</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $produto)
                        <tr>
                            <td>{{ $produto->nomeProduto }}</td>
                            <td>{{ $produto->referenciaProduto }}</td>
                            <td>{{ $produto->tipoProduto }}</td>
                            <td>{{ $produto->valorCompra }}</td>
                            <td>{{ $produto->valorVenda }}</td>
                            <td>{{ $produto->estoqueMinimo }}</td>
                            <td>{{ $produto->codigoBarra }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
