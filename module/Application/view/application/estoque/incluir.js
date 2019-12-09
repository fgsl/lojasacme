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

function handleFileSelect(evt) {
    var files = evt.target.files;

    var output = [];
    var i = 0;
    while(f = files[i]){	
      output.push('<li><strong>', escape(f.name), '</strong> (', f.type || 'n/a', ')','</li>');

      var reader = new FileReader();

      reader.onload = (function(theFile) {
          return function(e) {
            // Render thumbnail.
            var span = document.createElement('span');
            span.innerHTML = ['<img class="thumb" src="', e.target.result,
                              '" title="', escape(theFile.name), '"/>'].join('');
            document.getElementById('imgb64').setAttribute('value',e.target.result);      
            document.getElementById('list').insertBefore(span, null);
          };
        })(f);

        // Read in the image file as a data URL.
      reader.readAsDataURL(f);
	  i++;
	}64
	document.getElementById('list').innerHTML = '<ul>' + output.join('') + '</ul>';
}


$(document).ready(function(){
	document.getElementById('files').addEventListener('change', handleFileSelect, false);	
});
