<div class="py-2">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <form class="row g-3" method="POST" action="{{ route('client.store') }}">
            @csrf
            <!-- Radio buttons inline -->
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="PF" checked>
                <label class="form-check-label" for="PF">
                    Pessoa Fisica
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="flexRadioDefault" id="PJ">
                <label class="form-check-label" for="PJ">
                    Pessoa Juridica
                </label>
            </div>

            <!-- Form fields -->
            <div class="col-md-6">
                <label for="firstName" class="form-label" id="name">Nome</label>
                <input type="text" class="form-control" id="firstName" name="firstName">
            </div>
            <div class="col-md-4">
                <label for="lastName" class="form-label" id="surname">Sobrenome</label>
                <input type="text" class="form-control" id="lastName" name="lastName">
            </div>
            <div class="col-md-2">
                <label for="Fone" class="form-label" >Fone</label>
                <input type="text" class="form-control" id="fone" name="fone">
            </div>
            <div class="col-md-6">
                <label for="documento" class="form-label"  id="labelDocumento">CPF</label>
                <input type="text" class="form-control" id="documento" name="documento">
            </div>
            <div class="col-md-6">
                <label for="inputPassword4" class="form-label">RG</label>
                <input type="text" class="form-control" id="rg" name="rg">
            </div>
            <div class="col-6">
                <label for="inputAddress" class="form-label">Endereço</label>
                <input type="text" class="form-control" id="address" name="endereco">
            </div>
            <div class="col-6">
                <label for="inputAddress2" class="form-label">Complemento</label>
                <input type="text" class="form-control" id="complement" name="complemento">
            </div>
            <div class="col-md-6">
                <label for="inputCity" class="form-label">Cidade</label>
                <input type="text" class="form-control" id="city" name="cidade">
            </div>
            <div class="col-md-4">
                <label for="inputState" class="form-label">Estado</label>
                <select id="inputState" class="form-select" name="estado">
                    <option selected>Choose...</option>
                    <option>...</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="inputZip" class="form-label">CEP</label>
                <input type="text" class="form-control" id="inputZip" name="cep">
            </div>
            <div class="col-12 d-grid gap-2 d-md-flex justify-content-md-end">
                <input class="btn btn-primary me-md-2" type="submit" value="Submit">
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pfRadio = document.getElementById('PF');
        const pjRadio = document.getElementById('PJ');
        const identifierLabel = document.getElementById('labelDocumento');
        const identifierInput = document.getElementById('documento');
        const identifierName = document.getElementById('name');
        const identifierSurname = document.getElementById('surname');
        const formFields = document.querySelectorAll('input[type="text"]');
        const phoneInput = document.getElementById('fone');

        function updateIdentifier() {
            if (pjRadio.checked) {
                identifierLabel.innerText = 'CNPJ';
                identifierInput.placeholder = '00.000.000/0000-00';
                identifierName.innerText = 'Razão Social';
                identifierSurname.innerText = 'Nome Fantasia';
            } else {
                identifierLabel.innerText = 'CPF';
                identifierInput.placeholder = '000.000.000-00';
                identifierName.innerText = 'Nome';
                identifierSurname.innerText = 'Sobrenome';
            }

            clearFormFields();
        }

        function clearFormFields() {
            formFields.forEach(field => {
                field.value = '';
            });
        }
        
        pfRadio.addEventListener('change', updateIdentifier);
        pjRadio.addEventListener('change', updateIdentifier);
        phoneInput.addEventListener('input', function (event) {
            let input = event.target.value.replace(/\D/g, '');
            input = input.substring(0, 11);
            let formattedInput = '';

            if (input.length > 0) {
                formattedInput += '(' + input.substring(0, 2) + ') ';
            }
            if (input.length >= 3) {
                formattedInput += input.substring(2, 3) + ' ';
            }
            if (input.length >= 7) {
                formattedInput += input.substring(3, 7) + '-';
                formattedInput += input.substring(7, 11);
            } else if (input.length >= 3) {
                formattedInput += input.substring(3, 7);
            }

            event.target.value = formattedInput;
        });

                // Função para formatar CPF e CNPJ
                identifierInput.addEventListener('input', function (event) {
            let input = event.target.value.replace(/\D/g, '');
            let formattedInput = '';

            if (pjRadio.checked) {
                input = input.substring(0, 14);
                if (input.length > 0) {
                    formattedInput += input.substring(0, 2) + '.';
                }
                if (input.length >= 6) {
                    formattedInput += input.substring(2, 5) + '.';
                    formattedInput += input.substring(5, 8) + '/';
                    formattedInput += input.substring(8, 12) + '-';
                    formattedInput += input.substring(12, 14);
                } else if (input.length >= 3) {
                    formattedInput += input.substring(2, 5) + '.';
                    formattedInput += input.substring(5, 8) + '/';
                    formattedInput += input.substring(8, 12);
                }
            } else {
                input = input.substring(0, 11);
                if (input.length > 0) {
                    formattedInput += input.substring(0, 3) + '.';
                }
                if (input.length >= 6) {
                    formattedInput += input.substring(3, 6) + '.';
                    formattedInput += input.substring(6, 9) + '-';
                    formattedInput += input.substring(9, 11);
                } else if (input.length >= 3) {
                    formattedInput += input.substring(3, 6) + '.';
                    formattedInput += input.substring(6, 9);
                }
            }

            event.target.value = formattedInput;
        });
    });
</script>