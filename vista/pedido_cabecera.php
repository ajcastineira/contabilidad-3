    <table border="0" width="100%">
        <tr>
            <td width="40%"></td>
            <td width="10%"></td>
            <td width="40%"></td>
        </tr>
        <tr>
            <td>
                <table border="0" width="100%" style="background-color: #eeeeee;">
                    <tr>
                        <td height="15px" width="50%"></td>
                        <td width="45%"></td>
                        <td width="5%"></td>
                    </tr>
                    <tr>
                        <td style="text-align: right;">
                            <label>Fecha Pedido</label>
                        </td>
                        <td>
                            <?php
                            datepicker_español('FechaPedido');
                            ?>
                            <input type="text" class="textbox1" name="FechaPedido" id="FechaPedido" 
                                   onKeyUp="this.value=formateafechaEntrada(this.value);" 
                                   value="<?php if(isset($datosPresupuesto['FechaPedido'])){echo $datosPresupuesto['FechaPedido'];}else{echo date('d/m/Y');}?>" />
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right;">
                            <label>Fecha Vencimiento</label>
                        </td>
                        <td>
                            <?php
                            datepicker_español('FechaVtoPedido');
                            ?>
                            <input type="text" class="textbox1" name="FechaVtoPedido" id="FechaVtoPedido" 
                                   onKeyUp="this.value=formateafechaEntrada(this.value);" 
                                   value="<?php echo $datosPresupuesto['FechaVtoPedido'];?>" />
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right;">
                            <label>Fecha Finalización</label>
                        </td>
                        <td>
                            <?php
                            datepicker_español('FechaFinalizacion');
                            ?>
                            <input type="text" class="textbox1" name="FechaFinalizacion" id="FechaFinalizacion" 
                                   value="<?php echo $datosPresupuesto['FechaFinalizacion'];?>" />
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right;">
                            <label>Forma de Pago</label>
                        </td>
                        <td>
                            <script>
                            function SiEsTransferencia(objeto){
                                if(objeto.value === 'Transferencia'){
                                    $('.cc').show('500');
                                }else{
                                    $('.cc').hide('500');
                                }
                            }
                            </script>
                            <select name="FormaPagoHabitual" id="FormaPagoHabitual" class="textbox1" tabindex="101" style="width: 100%;" onchange="SiEsTransferencia(this);">
                                  <option value="" <?php if($datosPresupuesto['FormaPago']===''){echo 'selected';}?>></option>
                                  <option value="Contado" <?php if($datosPresupuesto['FormaPago']==='Contado'){echo 'selected';}?>>Contado</option>
                                  <option value="Pagare" <?php if($datosPresupuesto['FormaPago']==='Pagare'){echo 'selected';}?>>Pagaré</option>
                                  <option value="Recibo" <?php if($datosPresupuesto['FormaPago']==='Recibo'){echo 'selected';}?>>Recibo</option>
                                  <option value="Talon" <?php if($datosPresupuesto['FormaPago']==='Talon'){echo 'selected';}?>>Talón</option>
                                  <option value="Transferencia" <?php if($datosPresupuesto['FormaPago']==='Transferencia'){echo 'selected';}?>>Transferencia</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: right;">
                            <div class="cc" style="display: none;">
                            <label>CC Transferencia</label>
                            </div>
                        </td>
                        <td>
                            <div class="cc" style="display: none;">
                            <input type="text" class="textbox1" name="CC_Recibos" id="CC_Recibos" 
                                   value="<?php echo $datosPresupuesto['CC_Trans'];?>" />
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td height="15px"></td>
                    </tr>
                </table>
            </td>
            <td></td>
            <td>
                <table border="0" width="100%" style="background-color: #eeeeee;">
                    <tr>
                        <td height="15px" width="5%"></td>
                        <td width="40%"></td>
                        <td width="10%"></td>
                        <td width="40%"></td>
                        <td width="5%"></td>
                    </tr>
                    <tr>
                        <td colspan="5" style="text-align: center;">
                            <label>Tipo Factura</label>
                        </td>
                    </tr>           
                    <tr>
                        <td></td>
                        <td>
                            <script>
                            function tipoChecked(){
                                if(document.form1.TipoFactura[0].checked){
                                    //si encuentro algun valor cheked (seleccionado) presento los campos de dia y Frecuencia
                                    $('#formTipoFactura').show('500');
                                }else{
                                    //si no encuentro algun valor cheked (seleccionado) quito los campos de dia y Frecuencia
                                    $('#formTipoFactura').hide('500');
                                }
                            }
                            </script>
                            <input type="radio" name="TipoFactura" value="Periodica" onchange="tipoChecked();"
                                <?php if($datosPresupuesto['TipoFactura'] === 'Periodica'){echo 'checked';}else if(!isset($datosPresupuesto['TipoFactura'])){echo 'checked';}?> />
                            <label>Periódica</label>
                        </td>
                        <td></td>
                        <td>
                            <input type="radio" name="TipoFactura" value="Puntual" onchange="tipoChecked();" 
                                <?php if($datosPresupuesto['TipoFactura'] === 'Puntual'){echo 'checked';}?> />
                            <label>Puntual</label>
                        </td>
                    </tr>
                    <tr>
                        <td style="height: 15px;"></td>
                    </tr>
                    <tr>
                        <td colspan="5">
                            <div id="formTipoFactura" style="display: block;">
                            <table border="0" style="width: 100%;">
                                <tr>
                                    <td height="15px" width="5%"></td>
                                    <td width="40%"></td>
                                    <td width="10%"></td>
                                    <td width="40%"></td>
                                    <td width="5%"></td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="text-align: right;">
                                        <label>Día</label>
                                    </td>
                                    <td colspan="2">
                                        <input type="text" class="textbox1" name="DiaPeriodica" id="DiaPeriodica" 
                                               onkeypress="return solonumeros(event);"
                                               onfocus="onFocusInputText(this);" onblur="onBlurInputText(this);tipoChecked();"
                                               onMouseOver="onMouseOverInputText(this);" onMouseOut="onMouseOutInputText(this);" 
                                               value="<?php if(isset($datosPresupuesto['DiaPeriodica'])){echo $datosPresupuesto['DiaPeriodica'];}else{echo date('d');} ?>" style="text-align: right;" />
                                    </td>
                                </tr>                    
                                <tr>
                                    <td colspan="2" style="text-align: right;">
                                        <label>Frecuencia</label>
                                    </td>
                                    <td colspan="2">
                                        <select name="FrecuenciaPeriodica" style="width: 100%;" class="textbox1" onchange="tipoChecked();">
                                            <option value="Mensual" <?php if($datosPresupuesto['FrecuenciaPeriodica'] === 'Mensual'){echo 'selected';}?>>Mensual</option>
                                            <option value="Bimensual" <?php if($datosPresupuesto['FrecuenciaPeriodica'] === 'Bimensual'){echo 'selected';}?>>Bimensual</option>
                                            <option value="Trimestral" <?php if($datosPresupuesto['FrecuenciaPeriodica'] === 'Trimestral'){echo 'selected';}?>>Trimestral</option>
                                            <option value="Cuatrimestral" <?php if($datosPresupuesto['FrecuenciaPeriodica'] === 'Cuatrimestral'){echo 'selected';}?>>Cuatrimestral</option>
                                            <option value="Semestral" <?php if($datosPresupuesto['FrecuenciaPeriodica'] === 'Semestral'){echo 'selected';}?>>Semestral</option>
                                            <option value="Anual" <?php if($datosPresupuesto['FrecuenciaPeriodica'] === 'Anual'){echo 'selected';}?>>Anual</option>
                                        </select>
                                    </td>
                                </tr> 
                            </table>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="text-align: right;">
                            <label>Fecha Próxima Factura</label>
                        </td>
                        <td colspan="2">
                            <?php
                            datepicker_español('FechaProximaFacturaPeriodica');
                            ?>
                            <script>
                            function actualizaDia(fSeleccionada){
                                var fechaSeleccionada = fSeleccionada.split('/');
                                document.form1.DiaPeriodica.value = fechaSeleccionada[0];
                            };
                            </script>
                            <input type="text" class="textbox1" name="FechaProximaFacturaPeriodica" id="FechaProximaFacturaPeriodica" onchange="actualizaDia(this.value);"
                                   value="<?php if(isset($datosPresupuesto['FechaProximaFacturaPeriodica'])){echo $datosPresupuesto['FechaProximaFacturaPeriodica'];}else{echo date('d/m/Y');} ?>" style="text-align: right;" />
                        </td>
                    </tr>                    
                    <tr>
                        <td height="15px"></td>
                    </tr>
                </table>                
            </td>
        </tr>
    </table>
