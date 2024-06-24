<div class="py-2">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <form class="row g-3" method="POST" action="{{ route('product.store') }}">
            @csrf
            <!-- Form fields -->
            <div class="col-md-10">
                <label for="nameProductLabel" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nameProduct" name="nameProduct">
            </div>
            <div class="col-md-2">
                <label for="referenceLabel" class="form-label">Referência</label>
                <input type="text" class="form-control" id="referenceProduct" name="referenceProduct">
            </div>
            <div class="col-md-4">
                <label for="productType" class="form-label">Tipo de Produto</label>
                <select id="productType" class="form-select" name="productType">
                    <option selected>Selecione...</option>
                    <option>Alimentos e Bebidas</option>
                    <option>Eletrodomésticos</option>
                    <option>Eletrônicos</option>
                    <option>Roupas e Acessórios</option>
                    <option>Produtos de Higiene Pessoal</option>
                    <option>Móveis</option>
                    <option>Produtos de Limpeza</option>
                </select>
            </div>
            <div class="col-md-4">
                <label for="purchasePrice" class="form-label">Valor de Compra</label>
                <input type="text" class="form-control" id="purchasePrice" name="purchasePrice">
            </div>
            <div class="col-md-4">
                <label for="saleValue" class="form-label">Valor de Venda</label>
                <input type="text" class="form-control" id="saleValue" name="saleValue">
            </div>
            <div class="col-md-4">
                <label for="stock" class="form-label">Estoque minimo</label>
                <input type="number" class="form-control" id="minimumStock" name="minimumStock">
            </div>
            <div class="col-md-4">
                <label for="barCode" class="form-label">Código de Barras</label>
                <input type="number" class="form-control" id="barCode" name="barCode">
            </div>
            <div class="col-12 d-grid gap-2 d-md-flex justify-content-md-end">
                <input class="btn btn-primary me-md-2" type="submit" value="Submit">
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        function formatCurrency(value) {
            value = value.replace(/\D/g, "");
            value = (value / 100).toFixed(2) + "";
            value = value.replace(".", ",");
            value = value.replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1.");
            return value;
        }

        function applyCurrencyMask(input) {
            input.addEventListener('input', function() {
                let formattedValue = formatCurrency(input.value);
                input.value = formattedValue;
            });
        }

        const purchasePriceInput = document.getElementById('purchasePrice');
        const saleValueInput = document.getElementById('saleValue');

        applyCurrencyMask(purchasePriceInput);
        applyCurrencyMask(saleValueInput);
    });
</script>
