const regexemail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
const regexnome = /^[a-zA-ZÀ-ú0-9 ÃãÕõÑñ]*$/;
const regexnick = /^[a-zA-Z0-9_.-]{3,15}$/;

var inputEmpresa;
var inputName;
var inputPlan;
var inputUser;
var inputEmail;
var inputPassword;
var inputPassconf;

var validEmpresa = false;
var validName = false;
var validUser = false;
var validEmail = false;
var validPassword = false;
var validPassconf = false;

function Inicializacao() {
    inputEmpresa = document.getElementById("inputEmpresa");
    inputName = document.getElementById("inputName");
    inputPlan = document.getElementById("inputPlan");
    inputUser = document.getElementById("inputUser");
    inputEmail = document.getElementById("inputEmail");
    inputPassword = document.getElementById("inputPassword");
    inputPassconf = document.getElementById("inputPassconf");
}

function Lockfields() {
    inputEmpresa.disabled = true;
    inputName.disabled = true;
    inputPlan.disabled = true;
    inputUser.disabled = true;
    inputEmail.disabled = true;
    inputPassword.disabled = true;
    inputPassconf.disabled = true;
}

function UnLockfields() {
    inputEmpresa.disabled = false;
    inputName.disabled = false;
    inputPlan.disabled = false;
    inputUser.disabled = false;
    inputEmail.disabled = false;
    inputPassword.disabled = false;
    inputPassconf.disabled = false;
}

function IniciaLoad() {
    Lockfields();
}

function FinalizaLoad() {
    UnLockfields();
}

function ValidOnInput(obj) {
    console.log("Validando OnInput");

    obj.classList.remove("is-invalid");

    switch (obj.id) {
        case "inputEmpresa":
            //Se passar de 80, pega somente os 80 primeiros digitos
            obj.value = obj.value.substring(0, 80);

            //Primeira letra maiuscula
            palavras = obj.value.split(' ');
            for (let i = 0; i < palavras.length; i++) {
                palavras[i] = palavras[i].charAt(0).toUpperCase() + palavras[i].slice(1);
            }
            obj.value = palavras.join(' ').substring(0, 80);
            break;

        case "inputName":
            //Se passar de 80, pega somente os 80 primeiros digitos
            obj.value = obj.value.substring(0, 80);

            //Primeira letra maiuscula
            palavras = obj.value.split(' ');
            for (let i = 0; i < palavras.length; i++) {
                palavras[i] = palavras[i].charAt(0).toUpperCase() + palavras[i].slice(1);
            }
            obj.value = palavras.join(' ').substring(0, 80);
            break;

        case "inputUser":
            //Se passar de 20, pega somente os 20 primeiros digitos
            obj.value = obj.value.substring(0, 20);
            break;

        case "inputEmail":
            //Se passar de 55, pega somente os 55 primeiros digitos
            obj.value = obj.value.substring(0, 55);
            break;

        case "inputPassword":
            //Se passar de 50, pega somente os 50 primeiros digitos
            obj.value = obj.value.substring(0, 50);
            break;

        case "inputPassconf":
            //Se passar de 50, pega somente os 50 primeiros digitos
            obj.value = obj.value.substring(0, 50);
            break;
    }
    return true;
}

function ValidOnChange(obj) {
    console.log("Validando OnChange");

    obj.classList.remove("is-invalid");
    let idvalid = "Valid" + obj.id;
    let TxtValid = document.getElementById(idvalid);

    switch (obj.id) {
        case "inputEmpresa":
            validEmpresa = false;

            //Validar se está preenchido
            if (obj.value.length <= 0) {
                TxtValid.innerHTML = "Preenchimento é obrigatório";
                obj.classList.add("is-invalid");
                return false;
            }

            //Se passar de 80 pega somente os 80 primeiros digitos
            obj.value = obj.value.substring(0, 80);

            //Aplicar Regex
            if (!regexnome.test(obj.value)) {
                TxtValid.innerHTML = "Nome da empresa é inválido";
                obj.classList.add("is-invalid");
                return false;
            }

            //Validado
            validEmpresa = true;
            break;

        case "inputName":
            validName = false;

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
            validName = true;
            break;

        case "inputUser":
            validUser = false;

            //Validar se está preenchido
            if (obj.value.length <= 0) {
                TxtValid.innerHTML = "Preenchimento é obrigatório";
                obj.classList.add("is-invalid");
                return false;
            }

            //Se passar de 20, pega somente os 20 primeiros digitos
            obj.value = obj.value.substring(0, 20);

            //Aplicar Regex
            if (!regexnick.test(obj.value)) {
                TxtValid.innerHTML = "Usuário é inválido";
                obj.classList.add("is-invalid");
                return false;
            }

            //Validado
            validUser = true;
            break;

        case "inputEmail":
            validEmail = false;

            //Validar se está preenchido
            if (obj.value.length <= 0) {
                TxtValid.innerHTML = "Preenchimento é obrigatório";
                obj.classList.add("is-invalid");
                return false;
            }

            //Se passar de 55, pega somente os 55 primeiros digitos
            obj.value = obj.value.substring(0, 55);

            //Aplicar Regex
            if (!regexemail.test(obj.value)) {
                TxtValid.innerHTML = "Email inválido";
                obj.classList.add("is-invalid");
                return false;
            }

            var info = {
                'email': obj.value,
            };

            let ajax = $.ajax({
                url: "form/checkemail.php",
                type: 'POST',
                data: info,
                dataType: 'json',
                async: false,
                beforeSend: function () {
                    console.log("Checando email...");
                },
            })
                    .done(function (data) {
                        if (data.cod == 200) {
                            TxtValid.innerHTML = "Email já cadastrado";
                            obj.classList.add("is-invalid");
                            return false;
                        }
                    })
                    .fail(function (jqXHR, textStatus, errorThrown) {

                    });

            //Validado
            validEmail = true;
            break;

        case "inputPassword":
            validPassword = false;

            //Validar se está preenchido
            if (obj.value.length <= 0) {
                TxtValid.innerHTML = "Preenchimento é obrigatório";
                obj.classList.add("is-invalid");
                return false;
            }

            //Validado
            validPassword = true;
            break;

        case "inputPassconf":
            validPassconf = false;

            //Validar se está preenchido
            if (obj.value.length <= 0) {
                TxtValid.innerHTML = "Preenchimento é obrigatório";
                obj.classList.add("is-invalid");
                return false;
            }
            let senha1 = inputPassword.value;
            if (btoa(obj.value) != btoa(senha1)) {
                TxtValid.innerHTML = "As senhas digitadas não coincidem";
                obj.classList.add("is-invalid");

                return false;
            }

            //Validado
            validPassconf = true;
            break;
    }
    return true;
}

function ValidAllFields() {
    if (!validEmpresa) {
        return false;
    }
    if (!validName) {
        return false;
    }
    if (!validUser) {
        return false;
    }
    if (!validEmail) {
        return false;
    }
    if (!validPassword) {
        return false;
    }
    if (!validPassconf) {
        return false;
    }
    return true;
}

function CriarConta() {

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
        'empresa': inputEmpresa.value,
        'nome': inputName.value,
        'plan': inputPlan.value,
        'usuario': inputUser.value,
        'email': inputEmail.value,
        'senha': inputPassword.value,
        'senha2': inputPassconf.value,
    };

    console.log(info);

    let ajax = $.ajax({
        url: "form/criarusario.php",
        type: 'POST',
        data: info,
        dataType: 'json',
        async: true,
        beforeSend: function () {
            console.log("Criando usuario no sistema...");
            IniciaLoad();
        },
    })
            .done(function (data) {
                console.log(data);
                if (data.cod == 200) {
                    document.location.reload(true);
                } else {
                    FinalizaLoad();
                    ExibirMsg(data.msg, "E", false);
                }
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                FinalizaLoad()
            });

    return true;
}