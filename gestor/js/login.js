const regexemail = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
const regexnome = /^[a-zA-ZÀ-ú0-9 ÃãÕõÑñ]*$/;
const regexnick = /^[a-zA-Z0-9_.-]{3,15}$/;

var validado = false;

var criandoconta = true;

function LimparCampos() {
    document.getElementById("inputEmpresa").classList.remove("is-valid", "is-invalid");
    document.getElementById("inputEmail").classList.remove("is-valid", "is-invalid");
    document.getElementById("inputUser").classList.remove("is-valid", "is-invalid");
    document.getElementById("inputName").classList.remove("is-valid", "is-invalid");
    document.getElementById("inputPassword").classList.remove("is-valid", "is-invalid");
    document.getElementById("inputPassconf").classList.remove("is-valid", "is-invalid");
    document.getElementById("inputEmpresa").value = "";
    document.getElementById("inputEmail").value = "";
    document.getElementById("inputUser").value = "";
    document.getElementById("inputName").value = "";
    document.getElementById("inputPassword").value = "";
    document.getElementById("inputPassconf").value = "";
}

function ValidOnInput(obj) {
    obj.classList.remove("is-valid", "is-invalid");
    let palavras;
    switch (obj.id) {
        case "inputEmpresa":
            if (obj.value.length > 100) {
                ExibirMsg("Limite máximo de 100 caracteres", "I", false);
            }
            obj.value = obj.value.substring(0, 100);
            palavras = obj.value.split(' ');
            for (let i = 0; i < palavras.length; i++) {
                palavras[i] = palavras[i].charAt(0).toUpperCase() + palavras[i].slice(1);
            }
            obj.value = palavras.join(' ').substring(0, 100);
            break;
        case "inputEmail":
            if (obj.value.length > 100) {
                ExibirMsg("Limite máximo de 100 caracteres", "I", false);
            }
            obj.value = obj.value.substring(0, 100);
            break;
        case "inputUser":
            if (obj.value.length > 100) {
                ExibirMsg("Limite máximo de 100 caracteres", "I", false);
            }
            obj.value = obj.value.substring(0, 100);
            break;
        case "inputName":
            if (obj.value.length > 100) {
                ExibirMsg("Limite máximo de 100 caracteres", "I", false);
            }
            obj.value = obj.value.substring(0, 100);
            palavras = obj.value.split(' ');
            for (let i = 0; i < palavras.length; i++) {
                palavras[i] = palavras[i].charAt(0).toUpperCase() + palavras[i].slice(1);
            }
            obj.value = palavras.join(' ').substring(0, 100);
            break;
        case "inputPassword":
            if (obj.value.length > 50) {
                ExibirMsg("Limite máximo de 50 caracteres", "I", false);
            }
            obj.value = obj.value.substring(0, 100);
            break;
        case "inputPassconf":
            if (obj.value.length > 100) {
                ExibirMsg("Limite máximo de 50 caracteres", "I", false);
            }
            obj.value = obj.value.substring(0, 100);
            break;
    }
}

function ValidOnChange(obj) {

    obj.classList.remove("is-valid", "is-invalid");

    switch (obj.id) {

        case "inputEmpresa":
            if (obj.value.length > 100) {
                obj.value = obj.value.substring(0, 100);
                ExibirMsg("Limite máximo de 100 caracteres", "I", false);
            }
            if (!regexnome.test(obj.value)) {
                ExibirMsg("Empresa inválida", "E", false);
                obj.classList.add("is-invalid");
                return false;
            }
            if (obj.value.length > 0) {
                obj.classList.add("is-valid");
            } else {
                obj.classList.add("is-invalid");
                return false;
            }
            break;

        case "inputEmail":
            if (obj.value.length > 100) {
                obj.value = obj.value.substring(0, 100);
                ExibirMsg("Limite máximo de 100 caracteres", "I", false);
            }
            if (!regexemail.test(obj.value)) {
                ExibirMsg("Email inválido", "E", false);
                obj.classList.add("is-invalid");
                return false;
            }
            if (obj.value.length > 0) {
                obj.classList.add("is-valid");
            } else {
                obj.classList.add("is-invalid");
                return false;
            }

            try {
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
                        console.log("Validando Email");
                    },
                })
                        .done(function (data) {
                            if (data.cod == 200) {
                                ExibirMsg("Email já cadastrado", "E", false);
                                obj.classList.add("is-invalid");
                                return false;
                            }
                        })
                        .fail(function (jqXHR, textStatus, errorThrown) {
                        });
            } catch (e) {

            }
            break;

        case "inputUser":
            if (obj.value.length > 100) {
                obj.value = obj.value.substring(0, 100);
                ExibirMsg("Limite máximo de 100 caracteres", "I", false);
            }
            if (!regexnick.test(obj.value)) {
                ExibirMsg("Usuário inválido", "E", false);
                obj.classList.add("is-invalid");
                return false;
            }
            if (obj.value.length > 0) {
                obj.classList.add("is-valid");
            } else {
                obj.classList.add("is-invalid");
                return false;
            }

            try {
                var info = {
                    'email': obj.value,
                };

                let ajax = $.ajax({
                    url: "form/checkusername.php",
                    type: 'POST',
                    data: info,
                    dataType: 'json',
                    async: false,
                    beforeSend: function () {
                        console.log("Validando Username");
                    },
                })
                        .done(function (data) {
                            if (data.cod == 200) {
                                ExibirMsg("Usuário já cadastrado", "E", false);
                                obj.classList.add("is-invalid");
                                return false;
                            }
                        })
                        .fail(function (jqXHR, textStatus, errorThrown) {
                        });
            } catch (e) {

            }
            break;

        case "inputName":
            if (obj.value.length > 100) {
                obj.value = obj.value.substring(0, 100);
                ExibirMsg("Limite máximo de 100 caracteres", "I", false);
            }
            if (!regexnome.test(obj.value)) {
                ExibirMsg("Nome inválido", "E", false);
                obj.classList.add("is-invalid");
                return false;
            }
            if (obj.value.length > 0) {
                obj.classList.add("is-valid");
            } else {
                obj.classList.add("is-invalid");
                return false;
            }
            break;

        case "inputPassword":
            if (obj.value.length > 50) {
                obj.value = obj.value.substring(0, 100);
                ExibirMsg("Limite máximo de 50 caracteres", "I", false);
            }
            if (obj.value.length > 0) {
                obj.classList.add("is-valid");
            } else {
                obj.classList.add("is-invalid");
                return false;
            }
            break;

        case "inputPassconf":
            if (obj.value.length > 100) {
                obj.value = obj.value.substring(0, 100);
                ExibirMsg("Limite máximo de 50 caracteres", "I", false);
            }
            if (obj.value.length > 0) {
                if (obj.value !== document.getElementById("inputPassword").value) {
                    ExibirMsg("Senhas não condizem", "E", false);
                    obj.classList.add("is-invalid");
                    return false;
                } else {
                    obj.classList.add("is-valid");
                }
            } else {
                obj.classList.add("is-invalid");
                return false;
            }
            break;
    }
    return true;
}

function ValidAllFields() {

    var rrt = true;

    if (!ValidOnChange(document.getElementById("inputEmpresa"))) {
        rrt = false;
    }
    if (!ValidOnChange(document.getElementById("inputEmail"))) {
        rrt = false;
    }
    if (!ValidOnChange(document.getElementById("inputUser"))) {
        rrt = false;
    }
    if (!ValidOnChange(document.getElementById("inputName"))) {
        rrt = false;
    }
    if (!ValidOnChange(document.getElementById("inputPassword"))) {
        rrt = false;
    }
    if (!ValidOnChange(document.getElementById("inputPassconf"))) {
        rrt = false;
    }

    if (rrt) {
        validado = true;
    } else {
        validado = false;
    }

    return;
}

function CriarUsuario() {

    ValidAllFields();

    if (!validado) {
        ExibirMsg("Verificar Campos", "E", false);
        return;
    }
    
    $('#ModalLoading').modal('show');

    var info = {
        'empresa': document.getElementById("inputEmpresa").value,
        'email': document.getElementById("inputEmail").value,
        'nome': document.getElementById("inputName").value,
        'usuario': document.getElementById("inputUser").value,
        'senha': document.getElementById("inputPassword").value,
        'senha2': document.getElementById("inputPassconf").value,
    };

    let ajax = $.ajax({
        url: "form/criarusario.php",
        type: 'POST',
        data: info,
        dataType: 'json',
        async: true,
        beforeSend: function () {
            console.log("Criando usuario no sistema...");
        },
    })
            .done(function (data) {
                console.log(data);
                setTimeout(() => {
                    $('#ModalLoading').modal('hide');
                    if (data.cod == 200) {
                        ExibirMsg(data.msg, "S", false);
                        LimparCampos();
                        setTimeout(() => {
                        }, 1000);
                    } else {
                        ExibirMsg(data.msg, "E", false);
                    }
                }, 1000);
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                setTimeout(() => {
                    $('#ModalLoading').modal('hide');
                }, 1000);
            });

}

function FazerLogin(){
    
    if (document.getElementById("inputUser").value < 1) {
        ExibirMsg("Preencher Usuário", "I", false);
        return;
    }
    
    if (document.getElementById("inputPassword").value < 1) {
        ExibirMsg("Preencher Senha", "I", false);
        return;
    }
    
    $('#ModalLoading').modal('show');
    
    var info = {
        'usuario': document.getElementById("inputUser").value,
        'senha': document.getElementById("inputPassword").value,
    };
    
    let ajax = $.ajax({
        url: "form/fazerlogin.php",
        type: 'POST',
        data: info,
        dataType: 'json',
        async: true,
        beforeSend: function () {
            console.log("Fazendo login no sistema...");
        },
    })
            .done(function (data) {
                console.log(data);
                setTimeout(() => {
                    $('#ModalLoading').modal('hide');
                    if (data.cod == 200) {
                        document.location.reload(true);
                    } else {
                        ExibirMsg(data.msg, "E", false);
                    }
                }, 1000);
            })
            .fail(function (jqXHR, textStatus, errorThrown) {
                console.log(jqXHR);
                setTimeout(() => {
                    $('#ModalLoading').modal('hide');
                }, 1000);
            });
}

