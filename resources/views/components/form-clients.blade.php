<div class="py-2">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <form class="row g-3" method="POST" action="{{ route('product.store') }}">
            @csrf
            <!-- Form fields -->
            <div class="col-md-8">
                <label for="client" class="form-label">Cliente</label>
                <select class="form-select" id="client" name="client">
                    <option selected>Selecione um cliente...</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="seller" class="form-label">Vendedor</label>
                <input type="text" class="form-control" id="seller" name="seller">
            </div>
            <div id="clientDetails" class="col-12 py-2 d-none">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Detalhes do Cliente Selecionado</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Nome:</strong> <span id="clientName"></span></p>
                                <p><strong>Sobrenome:</strong> <span id="clientLastName"></span></p>
                                <p><strong>Fone:</strong> <span id="clientPhone"></span></p>
                                <p><strong>Documento:</strong> <span id="clientDocument"></span></p>
                                <p><strong>RG:</strong> <span id="clientRG"></span></p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Endereço:</strong> <span id="clientAddress"></span></p>
                                <p><strong>Complemento:</strong> <span id="clientComplement"></span></p>
                                <p><strong>Cidade:</strong> <span id="clientCity"></span></p>
                                <p><strong>Estado:</strong> <span id="clientState"></span></p>
                                <p><strong>CEP:</strong> <span id="clientZip"></span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#client').change(function() {
            var clientId = $(this).val();
            if (clientId) {
                $.ajax({
                    url: '/client/' + clientId, // Endpoint para buscar os dados do cliente
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Preencher os detalhes do cliente
                        $('#clientName').text(data.nome);
                        $('#clientLastName').text(data.sobrenome);
                        $('#clientPhone').text(data.fone);
                        $('#clientDocument').text(data.documento);
                        $('#clientRG').text(data.rg);
                        $('#clientAddress').text(data.endereco);
                        $('#clientComplement').text(data.complemento);
                        $('#clientCity').text(data.cidade);
                        $('#clientState').text(data.estado);
                        $('#clientZip').text(data.cep);

                        // Mostrar a div de detalhes do cliente
                        $('#clientDetails').removeClass('d-none');
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                        // Limpar os detalhes do cliente caso haja erro na requisição
                        clearClientDetails();
                    }
                });
            } else {
                clearClientDetails(); // Limpar os detalhes do cliente se nenhum cliente for selecionado
            }
        });
    });

    function clearClientDetails() {
        $('#clientName').text('');
        $('#clientLastName').text('');
        $('#clientPhone').text('');
        $('#clientDocument').text('');
        $('#clientRG').text('');
        $('#clientAddress').text('');
        $('#clientComplement').text('');
        $('#clientCity').text('');
        $('#clientState').text('');
        $('#clientZip').text('');

        // Esconder a div de detalhes do cliente
        $('#clientDetails').addClass('d-none');
    }
</script>
