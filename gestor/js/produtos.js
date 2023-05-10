function AbrirProduto(cod = 'NEW'){
    $('#ModalProduto').modal('show');
}
function AlterouCampo(obj){
    switch (obj.id) {
        case "selectQntPess":
            var numbPess = document.getElementById("numbpess");
            numbPess.innerHTML = obj.value;
            if (obj.value > 5) {
                numbPess.innerHTML = "mais de 5";
            } else {
                numbPess.innerHTML = "até " + obj.value;
            }
            break;
            
        default:
            
            break;
    }
}