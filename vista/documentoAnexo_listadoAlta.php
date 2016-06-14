<script>
//AJAX jQuery chequea que el fichero sea PDF
function check_fileAnexo(){
    var inputFileImage = document.getElementById("doc");
    
    if(navigator.appVersion.indexOf("MSIE 6.")!=-1 || navigator.appVersion.indexOf("MSIE 7.")!=-1
       || navigator.appVersion.indexOf("MSIE 8.")!=-1 || navigator.appVersion.indexOf("MSIE 9.")!=-1){
        var url=inputFileImage.value;
        var ficheroI=url.split("\\");
        var fichero=ficheroI[ficheroI.length-1];
        var ficheroDiv=fichero.split(".");
        var ext=ficheroDiv[ficheroDiv.length-1];
        ext=ext.toUpperCase();

        if(ext != 'PDF'){
            $('#txt_file').html("<b class='fileError'>&nbsp;&nbsp;&nbsp;El documento no es PDF o supera el tamaño maximo (1MB)</b>");
            document.getElementById('docCorrecto').value='NO';
        }else{
            $('#txt_file').html("<b>&nbsp;&nbsp;&nbsp;El documento es correcto</b>");
            $.ajax({
              data:{"name":fichero,"size":"10","type":"application/pdf"}, 
              url: '../vista/ajax/buscar_fileCorrecto.php',
              type:"POST",
              success: function(data) {
                if(data==='SI'){
                    $('#txt_file').html("<b>&nbsp;&nbsp;&nbsp;El documento es correcto</b>");
                }else{
                    $('#txt_file').html("<b class='fileError'>&nbsp;&nbsp;&nbsp;El documento no es PDF o supera el tamaño maximo (1MB)</b>");
                }
                document.getElementById('docCorrecto').value=data;
              }
            });
        }
    }else{
        //para el resto de navegadores
        var file = inputFileImage.files[0];
        $.ajax({
          data:{"name":file.name,"size":file.size,"type":file.type}, 
          url: '../vista/ajax/buscar_fileCorrecto.php',
          type:"POST",
          success: function(data) {
            if(data==='SI'){
                $('#txt_file').html("<b>&nbsp;&nbsp;&nbsp;El documento es correcto</b>");
            }else{
                $('#txt_file').html("<b class='fileError'>&nbsp;&nbsp;&nbsp;El documento no es PDF o supera el tamaño maximo (1MB)</b>");
            }
            document.getElementById('docCorrecto').value=data;
          }
        });
    }
}

//presentar una tabla con los ficheros de la tabla tbrecl_nc_pm_fichero
function presentarTablaFicheros(id){
    $.ajax({
      data:{"id":id}, 
      url: '../vista/ajax/listadoFicheros_incidencias_adjuntos.php',
      type:"get",
      success: function(data) {
          document.getElementById('tablaFicheros').innerHTML=data;
      }
    });
    
    //ahora limpio los campos de descripcion, el fichero y el de las indicaciones (txt_file)
    document.form1.strDescFichero.value='';
    document.form1.doc.value='';
    document.getElementById('txt_file').innerHTML='El documento debe ser PDF';
    document.form1.docCorrecto.value='NO';
}

//valida y sube el fichero a la carpteta ../qualidad/doc-Cliente/recl_nc_pm/ y da de alta en la tabla tbrecl_nc_pm_fichero
function validarFichero(descripcion,numReclamacion,tipo){
    esValido=true;
    textoError='';
    
    
    //comprobacion del campo 'strDescFichero'
    if (document.form1.strDescFichero.value == ''){ 
      textoError=textoError+"Es necesario introducir la descripción del fichero.\n";
      document.form1.strDescFichero.style.borderColor='#FF0000';
      document.form1.strDescFichero.title ='Se debe introducir la descripción del fichero';
      esValido=false;
    }
    
    if (document.form1.docCorrecto.value === 'NO'){
        textoError=textoError+"O debe seleccionar un documento o este no es PDF e inferior a 1MB.\n";
        esValido=false;
    }

    //indicar el mensaje de error si es 'esValido' false
    if(esValido==false){
        alert(textoError);
        return false;
    }

    document.form1.btnConsulta.disabled=true;
    document.form1.btnConsulta.value='Subiendo Documento ...';
    //ahora subimos el fichero y damos de alta en la tabla tbrecl_nc_pm_fichero esta reclamacion
    var inputFileImage = document.getElementById("doc");
    
    if((navigator.appVersion.indexOf("MSIE 8.")!=-1) || (navigator.appVersion.indexOf("MSIE 7.")!=-1) || 
        (navigator.appVersion.indexOf("MSIE 6.")!=-1) || (navigator.appVersion.indexOf("MSIE 9.")!=-1)){
        //submito el form y doy de alta el documento
        document.form1.btnConsulta.value='Subiendo Documento ...';
        document.form1.AltaDoc.value='SI';
        document.form1.submit();
    }else{
        //doy de lata el doc por AJAX
        var file = inputFileImage.files[0];
        var data = new FormData();
        data.append('archivo',file);
        data.append('descripcion',descripcion);
        data.append('numReclamacion',numReclamacion);
        data.append('tipo',tipo);

        //AJAX actualizas datos en la tabla
        $.ajax({
            url: '../vista/ajax/insertar_Recl_NC_PM.php',
            type:"POST",
            contentType:false,
            data:data,
            processData:false,
            cache:false,
            success: function(data) {
                if(data==='OK'){
                    alert('Se ha registrado correctamente el documento anexo. Sino aparece en el listado pulse en "Actualizar Listado"');
                    document.form1.btnConsulta.disabled=false;
                    document.form1.btnConsulta.value='Anexar Documento';
                }else{
                    alert('NO se ha registrado correctamente el documento anexo.');
                    document.form1.btnConsulta.disabled=false;
                    document.form1.btnConsulta.value='Anexar Documento';
                }
            }
        });
    }
        
    //por último actualizo el listado de ficheros
    setTimeout("presentarTablaFicheros(<?php echo $_GET['IdIncidencia'];?>,'"+tipo+"')",0);
}

//borra fichero de la tabla tbrecl_nc_pm_fichero
function borrarFichero(Id){
    if(confirm("¿Desea borrar el documento anexado? Pinche en el botón 'Actualizar Listado' para ver el listado actualizado")){
        //AJAX actualizas datos en la tabla
        $.ajax({
            data:{"Id":Id},
            url: '../vista/ajax/borrarFicheros_incidencias_adjuntos.php',
            type:"POST"
        });


        //por último actualizo el listado de ficheros
        setTimeout("presentarTablaFicheros(<?php echo $_GET['IdIncidencia'];?>)",0);
    }
}


</script>
<table width="640" border="0" class="zonaactiva">
      <tr>
          <td height="15px"></td>
      </tr>
      <tr>
          <td width="320" class="subtitulo">&nbsp;Documento(s) anexo(s) </td>
      </tr>
      <tr>
          <td align="center">
              <span id="tablaFicheros"><img src="../images/cargar.gif" height="20" widt="20" /></span><br/>
          </td>
      </tr>
      <tr>
          <td height="15px"></td>
      </tr>
      <tr>
          <td align="center">
              <span class="nombreCampo">Descripción Fichero:</span>
              <input class="textbox1" style="width: 140px;" type="text" name="strDescFichero" onchange="onMouseOverInputText(this);" maxlength="30"
                     onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
                     <br/><br/>
              <input type="file" class="file" id="doc" name="doc" onchange="check_fileAnexo();" /><br/>
              <span class="nombreCampo" id="txt_file">El documento debe ser PDF</span><br/>
              <input type="hidden" name="docCorrecto" id="docCorrecto" value="NO" />
              <input type="hidden" name="AltaDoc" value="NO" />
              <input type="button" name="btnConsulta" class="button" value = "Anexar Documento" 
                     onclick="validarFichero(document.form1.strDescFichero.value,'<?php echo $numero; ?>','<?php echo $tipo; ?>');"/>
              <input type="button" name="btnListar" class="button" value = "Actualizar Listado" 
                     onclick="presentarTablaFicheros('<?php echo $_GET['IdIncidencia']; ?>');"/>
          </td>
      </tr>
      <tr>
          <td height="15px"></td>
      </tr>
</table>
