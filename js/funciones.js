$(document).ready(function (){


var url = 'prueva.php';
var tabla = 'cuerpo';
var editar = 'editar';

pintarTabla(url,tabla,editar);

    function enviarFormulario(nombreIdFormulario,url){
        $.ajax({
            url: url,
            type:"POST",
            data:$('#'+nombreIdFormulario).serialize(),

            success: function (response){
                if(response == "error"){
                    console.log('Exito');
                }
            }
        });
    }

    function pintarTabla(url,nombreIdTablaBody,campoEdicion){
        $.ajax({
            url:url,
            type:'GET',
            success: function (response){
                console.log("Esto es: "+response);
                let datos = JSON.parse(response);
                let template = '';
                for(i=0, i < datos.length; i++;){
                    console.log('Entro');
                    template += `
                    <tr>
                    <td  class="text-nowrap text-center">${datos[i]}</td>`;
                    
                    if(campoEdicion == "editar"){
                        template = `
                    <th  class="text-nowrap text-center" style="width:100px;">
                        <div class="row">
                            <a data-toggle="modal" data-target="#modalForm" style="margin: 0 auto;" class="beditar btn btn-secondary" href="#">
                                <img src="img/edit.png">
                            </a>
                        </div>
                    </th>
                        `;
                    }
                    template += `</tr>`;
                }
                $('#'+nombreIdTablaBody).html(template);
            }
        });
    }
});