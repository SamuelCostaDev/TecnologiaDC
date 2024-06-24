<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    <a class="nav-link active" id="step1-tab" data-bs-toggle="tab" href="#step1" role="tab" aria-controls="step1" aria-selected="true">ITENS</a>
                    <a class="nav-link" id="step3-tab" data-bs-toggle="tab" href="#step3" role="tab" aria-controls="step3" aria-selected="false">PAGAMENTO</a>
                </div>
            </nav>
        </div>
        <div class="card-body">
            <form id="multiStepForm">
                <!-- Compra de Itens -->
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="step1" role="tabpanel" aria-labelledby="step1-tab">
                        <h3>Step 1</h3>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="product" class="form-label">Produto</label>
                                <select class="form-select" id="product" name="product">
                                    <option selected>Selecione um produto...</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->nomeProduto }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="amount" class="form-label">Quantidade</label>
                                <input type="number" class="form-control" id="amount" name="amount" value="0">
                            </div>
                            <div class="col-md-2">
                                <label for="unitaryValue" class="form-label">Valor Unitário</label>
                                <input type="text" class="form-control" id="unitaryValue" name="unitaryValue">
                            </div>
                            <div class="col-md-2">
                                <label for="subTotal" class="form-label">SubTotal</label>
                                <input type="number" class="form-control" id="subTotal" name="subTotal" readonly>
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="button" class="btn btn-outline-info" id="addProduct">+</button>
                            </div>
                        </div>
                        <h3 class="mt-5">Produtos Adicionados</h3>
                        <table class="table" id="productsTable">
                            <thead>
                                <tr>
                                    <th>Produto</th>
                                    <th>Quantidade</th>
                                    <th>Valor Unitário</th>
                                    <th>SubTotal</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <button type="button" class="btn btn-primary next-step mt-3">Avançar</button>
                    </div>
                    <!-- Pagamento -->
                    <div class="tab-pane fade" id="step2" role="tabpanel" aria-labelledby="step2-tab">
                        <h3>Step 2</h3>
                        <div class="row">
                            <div class="col-md-4">
                                <label for="paymentMethod" class="form-label">Forma de Pagamento</label>
                                <select class="form-select" id="paymentMethod" name="paymentMethod">
                                    <option selected>Selecione a forma de pagamento...</option>
                                    <option value="pix">PIX</option>
                                    <option value="boleto">Boleto</option>
                                    <option value="cartão">Cartão de Crédito</option>
                                    <option value="debito">Débito</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label for="installments" class="form-label">Parcelas</label>
                                <input type="number" class="form-control" id="installments" name="installments" value="1" min="1">
                            </div>
                        </div>
                        <h3 class="mt-5">Parcelas</h3>
                        <table class="table" id="installmentsTable">
                            <thead>
                                <tr>
                                    <th>Parcela</th>
                                    <th>Data de Vencimento</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <button type="button" class="btn btn-secondary prev-step mt-3">Voltar</button>
                        <button type="submit" class="btn btn-success mt-3" id="btnComprar">Comprar</button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
<script>
$(document).ready(function() {
    var currentStep = 0;
    var steps = $('.tab-pane');
    var products = [];
    var totalAmount = 0;

    function showStep(step) {
        steps.removeClass('show active').eq(step).addClass('show active');
        $('.nav-link').removeClass('active').eq(step).addClass('active');
    }

    $('.next-step').on('click', function() {
        if (currentStep < steps.length - 1) {
            currentStep++;
            showStep(currentStep);
        }
    });

    $('.prev-step').on('click', function() {
        if (currentStep > 0) {
            currentStep--;
            showStep(currentStep);
        }
    });

    showStep(currentStep); // Mostrar o primeiro passo

    // Event listener para capturar mudanças no campo de quantidade
    $('#amount').on('input', function() {
        calculateSubTotal();
    });

    // Event listener para capturar mudanças no campo de valor unitário
    $('#unitaryValue').on('input', function() {
        calculateSubTotal();
    });

    // Função para calcular o subtotal
    function calculateSubTotal() {
        var quantidade = parseInt($('#amount').val());
        var valorUnitario = parseFloat($('#unitaryValue').val());
        if (!isNaN(quantidade) && !isNaN(valorUnitario)) {
            var subtotal = quantidade * valorUnitario;
            $('#subTotal').val(subtotal.toFixed(2));
        } else {
            $('#subTotal').val('');
        }
    }

    // Event listener para mudanças no produto selecionado
    $('#product').change(function() {
        var productId = $(this).val();
        if (productId) {
            $.ajax({
                url: '/product/' + productId, // Endpoint para buscar os dados do produto
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var valorCompra = parseFloat(data.valorCompra); // Convertendo para número
                    if (!isNaN(valorCompra)) {
                        $('#unitaryValue').val(valorCompra.toFixed(2)); // Define o valor unitário
                        $('#amount').val(1); // Define a quantidade como 1
                        calculateSubTotal(); // Recalcula o subtotal ao carregar os dados do produto
                    } else {
                        console.error('Invalid value for data.valorCompra:', data.valorCompra);
                        clearProductDetails(); // Limpar os detalhes do produto em caso de valor inválido
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching product data:', error);
                    clearProductDetails(); // Limpar os detalhes do produto em caso de erro na requisição
                }
            });
        } else {
            clearProductDetails(); // Limpar os detalhes do produto se nenhum produto for selecionado
        }
    });

    // Função para limpar os detalhes do produto
    function clearProductDetails() {
        $('#unitaryValue').val('');
        $('#subTotal').val('');
    }

    // Adicionar produto à lista
    $('#addProduct').on('click', function() {
        var productId = $('#product').val();
        var productName = $('#product option:selected').text();
        var amount = parseInt($('#amount').val());
        var unitaryValue = parseFloat($('#unitaryValue').val());
        var subTotal = parseFloat($('#subTotal').val());

        if (productId && amount && unitaryValue && subTotal) {
            var product = {
                productId: productId,
                productName: productName,
                amount: amount,
                unitaryValue: unitaryValue,
                subTotal: subTotal
            };
            products.push(product);
            updateProductTable();
            clearProductDetails();
            $('#amount').val(0);
            $('#product').val('Selecione um produto...');
        } else {
            alert('Preencha todos os campos corretamente.');
        }
    });

    // Atualizar tabela de produtos
    function updateProductTable() {
        var tableBody = $('#productsTable tbody');
        tableBody.empty();
        totalAmount = 0; // Reiniciar o total antes de calcular novamente

        products.forEach(function(product, index) {
            var row = '<tr>' +
                '<td>' + product.productName + '</td>' +
                '<td><input type="number" class="form-control edit-amount" data-index="' + index + '" value="' + product.amount + '" readonly></td>' +
                '<td><input type="text" class="form-control edit-unitaryValue" data-index="' + index + '" value="' + product.unitaryValue.toFixed(2) + '" readonly></td>' +
                '<td class="edit-subTotal">' + product.subTotal.toFixed(2) + '</td>' +
                '<td><button type="button" class="btn btn-warning btn-sm edit-product" data-index="' + index + '">Editar</button>' +
                ' <button type="button" class="btn btn-danger btn-sm remove-product" data-index="' + index + '">Remover</button></td>' +
                '</tr>';
            tableBody.append(row);

            // Adicionar ao totalAmount
            totalAmount += product.subTotal;
        });

        // Exibir o valor total na tabela
        var totalRow = '<tr>' +
            '<td colspan="3" class="text-end"><strong>Total:</strong></td>' +
            '<td><strong>' + totalAmount.toFixed(2) + '</strong></td>' +
            '<td></td>' +
            '</tr>';
        tableBody.append(totalRow);

        $('.edit-product').on('click', function() {
            var index = $(this).data('index');
            var $row = $(this).closest('tr');
            var $amount = $row.find('.edit-amount');
            var $unitaryValue = $row.find('.edit-unitaryValue');
            var $button = $(this);

            if ($button.text() === 'Editar') {
                $amount.prop('readonly', false);
                $unitaryValue.prop('readonly', false);
                $button.removeClass('btn-warning').addClass('btn-success').text('Salvar');
            } else {
                var amount = parseInt($amount.val());
                var unitaryValue = parseFloat($unitaryValue.val());
                if (!isNaN(amount) && !isNaN(unitaryValue)) {
                    products[index].amount = amount;
                    products[index].unitaryValue = unitaryValue;
                    products[index].subTotal = amount * unitaryValue;
                    $amount.prop('readonly', true);
                    $unitaryValue.prop('readonly', true);
                    $button.removeClass('btn-success').addClass('btn-warning').text('Editar');
                    updateProductTable();
                } else {
                    alert('Por favor, insira valores válidos para quantidade e valor unitário.');
                }
            }
        });

        $('.remove-product').on('click', function() {
            var index = $(this).data('index');
            products.splice(index, 1);
            updateProductTable();
        });

        // Atualizar parcelas
        updateInstallments();
    }

    // Função para atualizar a tabela de parcelas
    function updateInstallments() {
        var installments = parseInt($('#installments').val());
        var installmentValue = totalAmount / installments;
        var tableBody = $('#installmentsTable tbody');
        tableBody.empty();

        for (var i = 1; i <= installments; i++) {
            var dueDate = new Date();
            dueDate.setMonth(dueDate.getMonth() + i);
            var dueDateStr = dueDate.toISOString().split('T')[0];

            var row = '<tr>' +
                '<td>' + i + '</td>' +
                '<td><input type="date" class="form-control installment-date" value="' + dueDateStr + '" data-index="' + i + '"></td>' +
                '<td><input type="number" class="form-control installment-value" value="' + installmentValue.toFixed(2) + '" data-index="' + i + '"></td>' +
                '</tr>';
            tableBody.append(row);
        }

        $('.installment-date').on('change', function() {
            var index = $(this).data('index');
            var newDate = $(this).val();
            updateInstallmentDates(index, newDate);
        });

        $('.installment-value').on('input', function() {
            var index = $(this).data('index');
            var newValue = parseFloat($(this).val());
            updateInstallmentValues(index, newValue);
        });
    }

    // Função para atualizar as datas das parcelas
    function updateInstallmentDates(startIndex, newDate) {
        var tableBody = $('#installmentsTable tbody');
        var rows = tableBody.find('tr');

        for (var i = startIndex - 1; i < rows.length; i++) {
            var date = new Date(newDate);
            date.setMonth(date.getMonth() + (i - startIndex + 1));
            var dateStr = date.toISOString().split('T')[0];
            $(rows[i]).find('.installment-date').val(dateStr);
        }
    }

    // Função para atualizar os valores das parcelas
    function updateInstallmentValues(index, newValue) {
        var tableBody = $('#installmentsTable tbody');
        var rows = tableBody.find('tr');
        var remainingAmount = totalAmount - newValue;
        var remainingInstallments = rows.length - index;

        if (remainingInstallments > 0) {
            var remainingValue = remainingAmount / remainingInstallments;
            for (var i = index; i < rows.length; i++) {
                $(rows[i]).find('.installment-value').val(remainingValue.toFixed(2));
            }
        }
    }
    $('#multiStepForm').on('submit', function(e) {
    // Calcula o total das parcelas
    var installmentsTotal = 0;
    $('#installmentsTable tbody').find('.installment-value').each(function() {
        installmentsTotal += parseFloat($(this).val());
    });

    // Verifica se o total das parcelas é maior que o total da compra
    if (installmentsTotal > totalAmount) {
        e.preventDefault(); // Impede o envio do formulário

        // Mostra um alerta indicando que as parcelas não podem ser maiores que o total da compra
        alert('O valor das parcelas não pode ser maior que o total da compra. Verifique os valores e tente novamente.');
    }
    });


    $('#btnComprar').on('click', function() {
        var installmentsTotal = 0;
        $('#installmentsTable tbody').find('.installment-value').each(function() {
            installmentsTotal += parseFloat($(this).val());
        });

        if (installmentsTotal > totalAmount) {
            alert('O valor das parcelas não pode ser maior que o total da compra. Verifique os valores e tente novamente.');
        } else {
            $('#multiStepForm').submit(); // Envie o formulário se a validação passar
        }
    });
    // Event listener para mudanças no número de parcelas
    $('#installments').on('input', function() {
        updateInstallments();
    });

    // Inicializar a tabela de parcelas ao carregar o passo de pagamento
    $('#step2-tab').on('click', function() {
        updateInstallments();
    });
});

</script>
