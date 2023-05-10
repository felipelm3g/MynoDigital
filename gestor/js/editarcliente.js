const regexnome = /^[a-zA-ZÀ-ú0-9 ÃãÕõÑñ]*$/;

var InputNome = "";
var InputTelefone = "";
var InputRua = "";
var InputNumb = "";
var InputComplt = "";
var InputRef = "";
var InputBairro = "";
var InputCity = "";
var InputUf = "";
var InputCep = "";

var validNome = false;
var validTelefone = false;
var validRua = false;
var validNumb = false;
var validComplt = false;
var validRef = false;
var validBairro = false;
var validCity = false;
var validUf = false;
var validCep = false;

var InputNomeLast = "";
var InputTelefoneLast = "";
var InputRuaLast = "";
var InputNumbLast = "";
var InputCompltLast = "";
var InputRefLast = "";
var InputBairroLast = "";
var InputCityLast = "";
var InputUfLast = "";
var InputCepLast = "";

var btnsalvar = "";

function Inicializacao() {
    InputNome = document.getElementById("InputNome");
    InputTelefone = document.getElementById("InputTelefone");
    InputRua = document.getElementById("InputRua");
    InputNumb = document.getElementById("InputNumb");
    InputComplt = document.getElementById("InputComplt");
    InputRef = document.getElementById("InputRef");
    InputBairro = document.getElementById("InputBairro");
    InputCity = document.getElementById("InputCity");
    InputUf = document.getElementById("InputUf");
    InputCep = document.getElementById("InputCep");
    btnsalvar = document.getElementById("btnsalvar");
}

function buscarCEP(inputcep) {

    let cep = inputcep.replace(/[^0-9]/g, '');

    let url = "https://viacep.com.br/ws/" + cep + "/json/";

    let ajax = $.ajax({
        url: url,
        type: 'GET',
        async: false,
        beforeSend: function () {
            console.log("Buscando CEP");
        },
    })
            .done(function (data) {
                if (data.erro) {
                    console.log("Erro");
                } else {
                    InputRua.value = data.logradouro;
                    InputBairro.value = data.bairro;
                    InputCity.value = data.localidade;
                    InputUf.value = data.uf;
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
            });
    return;
}

function Editar(obj) {
    //Preencher Campos Last
    InputNomeLast = InputNome.value;
    InputTelefoneLast = InputTelefone.value;
    InputRuaLast = InputRua.value;
    InputNumbLast = InputNumb.value;
    InputCompltLast = InputComplt.value;
    InputRefLast = InputRef.value;
    InputBairroLast = InputBairro.value;
    InputCityLast = InputCity.value;
    InputUfLast = InputUf.value;
    InputCepLast = InputCep.value;

    InputNome.disabled = false;
    InputTelefone.disabled = false;
    InputRua.disabled = false;
    InputNumb.disabled = false;
    InputComplt.disabled = false;
    InputRef.disabled = false;
    InputBairro.disabled = false;
    InputCity.disabled = false;
    InputUf.disabled = false;
    InputCep.disabled = false;

    btnsalvar.innerHTML = "<button onclick='Salvar();' class='btn btn-success btn-sm float-end me-2'><i class='fa-solid fa-floppy-disk'></i> &nbsp;Salvar</button>";

    obj.innerHTML = "<i class='fa-solid fa-xmark'></i> &nbsp;Cancelar";
    obj.onclick = function () {
        Cancelar(this)
    };
}
function Cancelar(obj) {
    //Reatribuir Valores
    InputNome.value = InputNomeLast;
    InputTelefone.value = InputTelefoneLast;
    InputRua.value = InputRuaLast;
    InputNumb.value = InputNumbLast;
    InputComplt.value = InputCompltLast;
    InputRef.value = InputRefLast;
    InputBairro.value = InputBairroLast;
    InputCity.value = InputCityLast;
    InputUf.value = InputUfLast;
    InputCep.value = InputCepLast;

    //Zerar campos Lasta
    InputNomeLast = "";
    InputTelefoneLast = "";
    InputRuaLast = "";
    InputNumbLast = "";
    InputCompltLast = "";
    InputRefLast = "";
    InputBairroLast = "";
    InputCityLast = "";
    InputUfLast = "";
    InputCepLast = "";

    InputNome.disabled = true;
    InputTelefone.disabled = true;
    InputRua.disabled = true;
    InputNumb.disabled = true;
    InputComplt.disabled = true;
    InputRef.disabled = true;
    InputBairro.disabled = true;
    InputCity.disabled = true;
    InputUf.disabled = true;
    InputCep.disabled = true;

    btnsalvar.innerHTML = "";

    obj.innerHTML = "<i class='fa-solid fa-pen-to-square'></i> &nbsp;Editar";
    obj.onclick = function () {
        Editar(this)
    };
}

function onInput(obj) {

    obj.classList.remove("is-invalid");

    switch (obj.id) {
        case "InputNome":
            //Se passar de 80, pega somente os 80 primeiros digitos
            obj.value = obj.value.substring(0, 80);

            //Primeira letra maiuscula
            palavras = obj.value.split(' ');
            for (let i = 0; i < palavras.length; i++) {
                palavras[i] = palavras[i].charAt(0).toUpperCase() + palavras[i].slice(1);
            }
            obj.value = palavras.join(' ').substring(0, 80);
            break;

        case "InputTelefone":
            obj.value = obj.value.replace(/\D/g, "");
            obj.value = obj.value.substring(0, 11);
            switch (obj.value.length) {
                case 10:
                    obj.value = obj.value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
                    break;
                case 11:
                    obj.value = obj.value.replace(/(\d{2})(\d{1})(\d{4})(\d{4})/, '($1) $2 $3-$4');
                    break;
                default:
                    if (obj.value.length > 11) {
                        obj.value = obj.value.substring(0, 11);
                        onInput(obj);
                    }
                    break;
            }
            break;

        case "InputCep":
            obj.value = obj.value.replace(/\D/g, "");
            obj.value = obj.value.substring(0, 8);
            obj.value = obj.value.replace(/(\d{5})(\d{3})/, "$1-$2");
            break;
    }
}
function onChange(obj) {

    obj.classList.remove("is-invalid");
    let idvalid = "Valid" + obj.id;
    let TxtValid = document.getElementById(idvalid);

    switch (obj.id) {
        case "InputNome":
            validNome = false;

            //Validar se está preenchido
            if (obj.value.length <= 0) {
                TxtValid.innerHTML = "Preenchimento é obrigatório";
                obj.classList.add("is-invalid");
                return false;
            }

            //Se passar de 80, pega somente os 80 primeiros digitos
            obj.value = obj.value.substring(0, 80);

            //Verificar se existe sobrenome
            palavras = obj.value.split(' ');
            if (palavras.length < 2) {
                TxtValid.innerHTML = "Por favor insira seu sobrenome";
                obj.classList.add("is-invalid");
                return false;
            }

            //Aplicar Regex
            if (!regexnome.test(obj.value)) {
                TxtValid.innerHTML = "Nome é inválido";
                obj.classList.add("is-invalid");
                return false;
            }

            //Validado
            validNome = true;
            break;

        case "InputTelefone":
            validTelefone = false;

            //Validar se está preenchido
            if (obj.value.length <= 0) {
                TxtValid.innerHTML = "Preenchimento é obrigatório";
                obj.classList.add("is-invalid");
                return false;
            }

            obj.value = obj.value.replace(/\D/g, "");
            switch (obj.value.length) {
                case 10:
                    obj.value = obj.value.replace(/(\d{2})(\d{4})(\d{4})/, '($1) $2-$3');
                    break;
                case 11:
                    obj.value = obj.value.replace(/(\d{2})(\d{1})(\d{4})(\d{4})/, '($1) $2 $3-$4');
                    break;
                default:
                    if (obj.value.length > 11) {
                        obj.value = obj.value.substring(0, 11);
                        onChange(obj);
                    }
                    return false;
                    break;
            }
            validTelefone = true;
            break;

        case "InputRua":
            validRua = false;
            if (obj.value.length > 0) {
                //Aplicar Regex
                if (!regexnome.test(obj.value)) {
                    TxtValid.innerHTML = "Rua é inválido";
                    obj.classList.add("is-invalid");
                    return false;
                }
            }
            validRua = true;
            break;

        case "InputNumb":
            validNumb = false;
            if (obj.value.length > 0) {
                //Aplicar Regex
                if (!regexnome.test(obj.value)) {
                    TxtValid.innerHTML = "Numero é inválido";
                    obj.classList.add("is-invalid");
                    return false;
                }
            }
            validNumb = true;
            break;

        case "InputComplt":
            validComplt = false;
            if (obj.value.length > 0) {
                //Aplicar Regex
                if (!regexnome.test(obj.value)) {
                    TxtValid.innerHTML = "Complemento é inválido";
                    obj.classList.add("is-invalid");
                    return false;
                }
            }
            validComplt = true;
            break;

        case "InputRef":
            validRef = false;
            if (obj.value.length > 0) {
                //Aplicar Regex
                if (!regexnome.test(obj.value)) {
                    TxtValid.innerHTML = "Ponto de referencia é inválido";
                    obj.classList.add("is-invalid");
                    return false;
                }
            }
            validRef = true;
            break;

        case "InputBairro":
            validBairro = false;
            if (obj.value.length > 0) {
                //Aplicar Regex
                if (!regexnome.test(obj.value)) {
                    TxtValid.innerHTML = "Bairro é inválido";
                    obj.classList.add("is-invalid");
                    return false;
                }
            }
            validBairro = true;
            break;


        case "InputCity":
            validCity = false;
            if (obj.value.length > 0) {
                //Aplicar Regex
                if (!regexnome.test(obj.value)) {
                    TxtValid.innerHTML = "Cidade é inválido";
                    obj.classList.add("is-invalid");
                    return false;
                }
            }
            validCity = true;
            break;

        case "InputUf":
            validUf = false;
            if (obj.value.length > 0) {
                //Aplicar Regex
                if (!regexnome.test(obj.value)) {
                    TxtValid.innerHTML = "Estado é inválido";
                    obj.classList.add("is-invalid");
                    return false;
                }
            }
            validUf = true;
            break;

        case "InputCep":
            validCep = false;
            if (obj.value.length > 0) {
                obj.value = obj.value.replace(/\D/g, "");
                obj.value = obj.value.substring(0, 9);
                obj.value = obj.value.replace(/(\d{5})(\d{3})/, "$1-$2");
                buscarCEP(obj.value);
            }
            validCep = true;
            break;
    }
}

function ValidAllFields() {

    if (!validNome) {
        return false;
    }

    if (!validTelefone) {
        return false;
    }

    if (!validRua) {
        return false;
    }

    if (!validNumb) {
        return false;
    }

    if (!validComplt) {
        return false;
    }

    if (!validRef) {
        return false;
    }

    if (!validBairro) {
        return false;
    }

    if (!validCity) {
        return false;
    }

    if (!validUf) {
        return false;
    }

    if (!validCep) {
        return false;
    }

    return true;
}

function Alteracao() {
    if (InputNomeLast != InputNome.value) {
        return true;
    }
    if (InputTelefoneLast != InputTelefone.value) {
        return true;
    }
    if (InputRuaLast != InputRua.value) {
        return true;
    }
    if (InputNumbLast != InputNumb.value) {
        return true;
    }
    if (InputCompltLast != InputComplt.value) {
        return true;
    }
    if (InputRefLast != InputRef.value) {
        return true;
    }
    if (InputBairroLast != InputBairro.value) {
        return true;
    }
    if (InputCityLast != InputCity.value) {
        return true;
    }
    if (InputUfLast != InputUf.value) {
        return true;
    }
    if (InputCepLast != InputCep.value) {
        return true;
    }
    return false;
}

function Salvar() {
    const formulario = document.querySelector('form');
    const elementos = formulario.elements;

    for (let i = 0; i < elementos.length; i++) {
        const elemento = elementos[i];
        elemento.dispatchEvent(new Event('change'));
    }

    if (!ValidAllFields()) {
        return false;
    }

    if (!Alteracao()) {
        ExibirMsg("Não houve alterações para serem salvas", "I", false);
        return false;
    }

    var info = {
        'cod': codcliente,
        'nome': InputNome.value,
        'tel': InputTelefone.value,
        'cep': InputCep.value,
        'rua': InputRua.value,
        'num': InputNumb.value,
        'cmp': InputComplt.value,
        'ref': InputRef.value,
        'bai': InputBairro.value,
        'cid': InputCity.value,
        'est': InputUf.value,
    };

    console.log(info);

    let ajax = $.ajax({
        url: "../form/editarcliente.php",
        type: 'POST',
        data: info,
        dataType: 'json',
        async: true,
        beforeSend: function () {
            console.log("Criando usuario no sistema...");
            $('#ModalLoading').modal('show');
        },
    })
            .done(function (data) {
                $('#ModalLoading').modal('hide');
                if (data.status) {
                    document.location.reload(true);
                } else {
                    alert("Erro ao tentar editar Cliente");
                }
                console.log(data);
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                $('#ModalLoading').modal('show');
            });
}

