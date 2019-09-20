var limiteAlcancado = false;

function validarTamanhoDoNome()
{
	var input = document.getElementById("nome");
	if (!limiteAlcancado && input.value.length>80){
		limiteAlcancado = true;
		window.alert("Tamanho máximo: 80");
		texto = input.value.substr(0,input.value.length-2);
		limiteAlcancado = false;
	}
}