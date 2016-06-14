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
</script>

<table width="640" border="0" class="zonaactiva">
    <tr>
        <td class="subtitulo">&nbsp;Documento anexo </td>
    </tr>
    <tr>
        <td height="15px"></td>
    </tr>
    <tr>
        <td align="center">
            <span class="nombreCampo">Descripción Fichero:</span>
            <input class="textbox1" style="width: 140px;" type="text" name="strDescFichero" onchange="onMouseOverInputText(this);" size="30"
                   onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);" />
                   <br/><br/>
            <input type="file" class="file" id="doc" name="doc" onchange="check_fileAnexo();" /><br/>
            <span class="nombreCampo" id="txt_file">El documento debe ser PDF</span><br/>
            <input type="hidden" name="docCorrecto" id="docCorrecto" value="NO" />
        </td>
    </tr>
    <tr>
        <td height="15px"></td>
    </tr>
</table>
