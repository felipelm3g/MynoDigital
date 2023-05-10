const regexnome = /^[a-zA-ZÀ-ú0-9 ÃãÕõÑñ]*$/;

var InputNome = "";
var InputTelefone = "";
var InputRua = "";
var InputBairro = "";
var InputCity = "";
var InputUf = "";

var telcadas = false;
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
}

function LimparFormNewCli() {
    InputNome.value = "";
    InputTelefone.value = "";
    InputRua.value = "";
    InputNumb.value = "";
    InputComplt.value = "";
    InputRef.value = "";
    InputBairro.value = "";
    InputCity.value = "";
    InputUf.value = "";
    InputNome.classList.remove("is-invalid");
    InputTelefone.classList.remove("is-invalid");
    InputRua.classList.remove("is-invalid");
    InputNumb.classList.remove("is-invalid");
    InputComplt.classList.remove("is-invalid");
    InputRef.classList.remove("is-invalid");
    InputBairro.classList.remove("is-invalid");
    InputCity.classList.remove("is-invalid");
    InputUf.classList.remove("is-invalid");
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

function onInput(obj) {

    obj.classList.remove("is-invalid");
    let idvalid = "Valid" + obj.id;
    let TxtValid = document.getElementById(idvalid);

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
            var numero = obj.value;
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
            if (numero.length == 10 || numero.length == 11) {
                var info = {
                    'tel': numero,
                };

                let ajax = $.ajax({
                    url: "form/checktel.php",
                    type: 'POST',
                    data: info,
                    dataType: 'json',
                    async: true,
                    beforeSend: function () {
                        console.log("Checando telefone...");
                    },
                })
                        .done(function (data) {
                            console.log(data);
                            if (data.cod == 200) {
                                TxtValid.innerHTML = "Telefone já cadastrado";
                                obj.classList.add("is-invalid");
                                telcadas = true;
                            } else {
                                telcadas = false;
                            }
                        })
                        .fail(function (jqXHR, textStatus, errorThrown) {
                            console.log(jqXHR);
                            TxtValid.innerHTML = "Erro de verificação";
                            obj.classList.add("is-invalid");
                        });
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

            if (telcadas) {
                TxtValid.innerHTML = "Telefone já cadastrado";
                obj.classList.add("is-invalid");
                return false;
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
                if (InputRua.value == "") {
                    buscarCEP(obj.value);
                }
            }
            validCep = true;
            break;
    }
}

function ValidAllFields() {
    if (!validNome) {
        console.error("nome");
        return false;
    }
    if (!validTelefone) {
        console.error("telefone");
        return false;
    }
    if (!validRua) {
        console.error("rua");
        return false;
    }
    if (!validNumb) {
        console.error("numero");
        return false;
    }
    if (!validComplt) {
        console.error("complemento");
        return false;
    }
    if (!validRef) {
        console.error("referencia");
        return false;
    }
    if (!validBairro) {
        console.error("bairro");
        return false;
    }
    if (!validCity) {
        console.error("cidade");
        return false;
    }
    if (!validUf) {
        console.error("estado");
        return false;
    }
    if (!validCep) {
        console.error("cep");
        return false;
    }
    return true;
}

function CriarCliente() {

    const formulario = document.querySelector('form');
    const elementos = formulario.elements;

    for (let i = 0; i < elementos.length; i++) {
        const elemento = elementos[i];
        elemento.dispatchEvent(new Event('change'));
    }

    if (!ValidAllFields()) {
        return false;
    }

    var info = {
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
        url: "form/criarcliente.php",
        type: 'POST',
        data: info,
        dataType: 'json',
        async: true,
        beforeSend: function () {
            console.log("Criando usuario no sistema...");
        },
    })
            .done(function (data) {
                if (data.status) {
                    $('#ModalCriarCliente').modal('hide');
                    let link = "cliente/" + data.mensagem;
                    AbrirLink(link);
                } else {
                    alert("Erro ao tentar criar Cliente");
                }
                console.log(data);
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
            });
}