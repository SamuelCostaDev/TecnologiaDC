<div class="py-2">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <table id="table" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Sobrenome</th>
                        <th>Fone</th>
                        <th>Documento</th>
                        <th>RG</th>
                        <th>Endereço</th>
                        <th>Complemento</th>
                        <th>Cidade</th>
                        <th>Estado</th>
                        <th>CEP</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $cliente)
                        <tr>
                            <td>{{ $cliente->nome }}</td>
                            <td>{{ $cliente->sobrenome }}</td>
                            <td>{{ $cliente->fone }}</td>
                            <td>{{ $cliente->documento }}</td>
                            <td>{{ $cliente->rg }}</td>
                            <td>{{ $cliente->endereco }}</td>
                            <td>{{ $cliente->complemento }}</td>
                            <td>{{ $cliente->cidade }}</td>
                            <td>{{ $cliente->estado }}</td>
                            <td>{{ $cliente->cep }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
