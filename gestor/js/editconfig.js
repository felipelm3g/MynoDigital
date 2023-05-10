let timeouyNotif;

var lastinputNameEmpresa = "";
var lastconfigviewcliente = "";

function Inicializacao() {
    lastconfigviewcliente = document.getElementById("configviewcliente").value;
    lastinputNameEmpresa = document.getElementById("inputNameEmpresa").value;
}

function NotifSalvando() {
    let html = "";
    html += "<div class='alert alert-secondary' role='alert'>";
    html += "<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>&nbsp;&nbsp;&nbsp;Salvando...";
    html += "</div>";
    document.getElementById("notfic").innerHTML = html;
}
function NotifSuccess() {
    let html = "";
    html += "<div class='alert alert-success' role='alert'>";
    html += "<i class='fa-solid fa-check'></i>&nbsp;&nbsp;&nbsp;Salvo";
    html += "</div>";
    document.getElementById("notfic").innerHTML = html;
    clearTimeout(timeouyNotif);
    timeouyNotif = setTimeout(() => {
        document.getElementById("notfic").innerHTML = "";
    }, 1000);
}
function NotifError() {
    let html = "";
    html += "<div class='alert alert-danger' role='alert'>";
    html += "<i class='fa-solid fa-triangle-exclamation'></i>&nbsp;&nbsp;&nbsp;Erro ao tentar salvar";
    html += "</div>";
    document.getElementById("notfic").innerHTML = html;
    clearTimeout(timeouyNotif);
    timeouyNotif = setTimeout(() => {
        document.getElementById("notfic").innerHTML = "";
    }, 1000);
}

function onChange(obj) {

    NotifSalvando();

    switch (obj.id) {

        case "inputNameEmpresa":
            if (obj.value.length > 0) {
                obj.disabled = true;

                var info = {
                    'index': "viewnameempresa",
                    'value': obj.value,
                };

                console.log(info);

                let ajax = $.ajax({
                    url: "form/editconfig.php",
                    type: 'POST',
                    data: info,
                    dataType: 'json',
                    async: true,
                    beforeSend: function () {
                        console.log("Editando configuração...");
                    },
                })
                        .done(function (data) {
                            console.log(data);
                            if (data.status) {
                                obj.disabled = false;
                                NotifSuccess();
                                lastinputNameEmpresa = obj.value;
                            } else {
                                obj.disabled = false;
                                obj.value = lastinputNameEmpresa;
                                NotifError();
                            }
                        })
                        .fail(function (jqXHR, textStatus, errorThrown) {
                            console.log(jqXHR);
                            obj.disabled = false;
                            obj.value = lastinputNameEmpresa;
                            NotifError();
                        });
            } else {

            }
            break;

        case "CheckMesa":
            if (obj.checked) {
                AbrirLink('form/editextension.php?ext=mesa&stt=1');
            } else {
                AbrirLink('form/editextension.php?ext=mesa&stt=0');
            }
            break;

        case "CheckCozinha":
            if (obj.checked) {
                AbrirLink('form/editextension.php?ext=cozinha&stt=1');
            } else {
                AbrirLink('form/editextension.php?ext=cozinha&stt=0');
            }
            break;

        case "CheckEntreg":
            if (obj.checked) {
                AbrirLink('form/editextension.php?ext=entrega&stt=1');
            } else {
                AbrirLink('form/editextension.php?ext=entrega&stt=0');
            }
            break;

        case "CheckIntreg":
            if (obj.checked) {
                AbrirLink('form/editextension.php?ext=integracao&stt=1');
            } else {
                AbrirLink('form/editextension.php?ext=integracao&stt=0');
            }
            break;

        case "configviewcliente":

            obj.disabled = true;

            var info = {
                'index': "viewcliente",
                'value': obj.value,
            };

            console.log(info);

            let ajax = $.ajax({
                url: "form/editconfig.php",
                type: 'POST',
                data: info,
                dataType: 'json',
                async: true,
                beforeSend: function () {
                    console.log("Editando configuração...");
                },
            })
                    .done(function (data) {
                        console.log(data);
                        if (data.status) {
                            obj.disabled = false;
                            NotifSuccess();
                            lastconfigviewcliente = obj.value;
                        } else {
                            obj.disabled = false;
                            obj.value = lastconfigviewcliente;
                            NotifError();
                        }
                    })
                    .fail(function (jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR);
                        obj.disabled = false;
                        obj.value = lastconfigviewcliente;
                        NotifError();
                    });
            break;
    }
}