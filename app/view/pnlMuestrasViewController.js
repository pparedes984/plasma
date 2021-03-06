/*
 * File: app/view/pnlMuestrasViewController.js
 *
 * This file was generated by Sencha Architect version 4.2.4.
 * http://www.sencha.com/products/architect/
 *
 * This file requires use of the Ext JS 6.6.x Classic library, under independent license.
 * License of Sencha Architect does not include license for Ext JS 6.6.x Classic. For more
 * details see http://www.sencha.com/license or contact license@sencha.com.
 *
 * This file will be auto-generated each and everytime you save your project.
 *
 * Do NOT hand edit this file.
 */

Ext.define('plasma.view.pnlMuestrasViewController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.pnlmuestras',

    onBtnNuevoMuestraClick: function(button, e, eOpts) {
        if(!Ext.getCmp('pnlNuevoMuestra'))
        {
            Ext.getCmp('pnlCentral').removeAll();
            var win = Ext.create('plasma.view.pnlNuevoMuestra');
            ME.getView().down('#pnlCentral').add(win);
            win.show();
            Ext.getCmp('txtAnalista').setValue(USUARIO);
            Ext.getCmp('txtAnalista1').setValue(USUARIO);
            var strInstitucion = Ext.getStore('Institucion');

            strInstitucion.proxy.extraParams={
                bandera :1
            };
            strInstitucion.load();

            var strMarcador = Ext.getStore('Marcador');
            strMarcador.proxy.extraParams={
                bandera :1
            };
            strMarcador.load();

            var strKit = Ext.getStore('Kit');

            strKit.proxy.extraParams={
                bandera :1
            };
            strKit.load();

            I = 0;
            ID = 'null';
            VOLUMEN = null;

            Ext.getCmp('txtFechaTransformacion').setVisible(false);
            Ext.getCmp('txtObservacionT').setVisible(false);
            Ext.getCmp('txtLocalizacion').setVisible(false);
            Ext.getCmp('txtUbicacionSeroteca').setVisible(false);
            Ext.getCmp('txtVolumen').setVisible(false);
            Ext.getCmp('txtConcentracion').setVisible(false);

            Ext.getCmp('tabPanel').down('#tab1').setDisabled(true);
            Ext.getCmp('tabPanel').down('#tab2').setDisabled(true);
            Ext.getCmp('tabPanel').down('#tab3').setDisabled(true);
            Ext.getCmp('tabPanel').down('#tab4').setDisabled(true);

        }
    },

    onBtnEliminarMuestraClick: function(button, e, eOpts) {
        var g = Ext.getCmp('grdMuestras');
        var arrayKeys = g.getSelectionModel().selected.items;
        var indice = g.getSelectionModel().selectionStartIdx;
        if(arrayKeys.length === 0)
        Ext.Msg.alert('Error', 'Debe escoger un usuario');
        else
        {

            var store = g.getStore();
            var rec = g.selection;
            Ext.Ajax.request({
                url: '../servidor/plasma/muestra/verificarMuestra',
                method:"post",
                params: {
                    id: rec.data.id
                },
                success: function( result, request ) {
                    var responseData = Ext.JSON.decode(result.responseText);
                    if(responseData.success)
                    {
                        store.remove(rec);
                        store.sync(
                        {
                            params:{
                                id: rec.data.id
                            },
                            success: function(batch, success)
                            {
                                store.commitChanges();
                                store.load();
                                Ext.Msg.alert('Alerta', 'Se ha eliminado el registro exitosamente');
                            },

                            failure: function(batch, success)
                            {
                                Ext.Msg.alert('Error', 'Hubor un error');
                            }
                        });
                    }
                    else
                    {
                        Ext.Msg.alert('Alerta','Este registro tiene datos asociados.');
                    }
                },

                failure: function(response, opts) {
                    console.log('server-side failure with status code ' + response.status);
                }
            });

        }
    },

    onBtnImprimirClick: function(button, e, eOpts) {
        var me = this;
        var grid = me.getView().down('#grdMuestras');
        var arrayKeys = grid.getSelectionModel().selected.items;

        if(arrayKeys.length === 0)
        Ext.Msg.alert('Error', 'Debe escoger un registro');
        else if(arrayKeys.length >1 )
        Ext.Msg.alert('Error', 'Solo debe escoger un registro');
        else
        {
            var indice = grid.getSelectionModel().selectionStartIdx;
            ID = arrayKeys[0].data.id;
            var win = Ext.create('plasma.view.wndPdf');
            win.show();

        }

    },

    onTableItemDblClick: function(dataview, record, item, index, e, eOpts) {
        if(!Ext.getCmp('pnlNuevoMuestra'))
        {

            var grid = Ext.getCmp('grdMuestras');
            var arrayKeys = grid.getSelectionModel().selected.items;
            var indice = grid.getSelectionModel().selectionStartIdx;
            ID = arrayKeys[0].data.id;
            VOLUMEN = arrayKeys[0].data.volumen;
            Ext.getCmp('pnlCentral').removeAll();
            var win = Ext.create('plasma.view.pnlNuevoMuestra');
            ME.getView().down('#pnlCentral').add(win);
            win.show();
            var strInstitucion = Ext.getStore('Institucion');

            strInstitucion.proxy.extraParams={
                bandera :1
            };
            strInstitucion.load();
            var strKit = Ext.getStore('Kit');

            strKit.proxy.extraParams={
                bandera :1
            };
            strKit.load();
            var strCodigo = Ext.getStore('Codigo');
            strCodigo.load();
            I = 0;
            J = 0;
            AUXILIAR = 0;
            AUX =0;

            Ext.getCmp('tabPanel').down('#tab2').setDisabled(true);
            Ext.getCmp('tabPanel').down('#tab3').setDisabled(true);
            Ext.getCmp('tabPanel').down('#tab4').setDisabled(true);

            Ext.Ajax.request({
                url: '../servidor/plasma/muestra/comprobarsuero',
                method:"post",
                params: {
                    data: ID
                },
                success: function( result, request ) {
                    var responseData = Ext.JSON.decode(result.responseText);

                    if(responseData.estado_suero === 'Completo')
                    {
                        Ext.getCmp('tabPanel').down('#tab4').setDisabled(false);


                    }
                },

                failure: function(response, opts) {
                    console.log('server-side failure with status code ' + response.status);
                }
            });

            Ext.Ajax.request({
                url: '../servidor/plasma/muestra/comprobarplasma',
                method:"post",
                params: {
                    data: ID
                },
                success: function( result, request ) {
                    var responseData = Ext.JSON.decode(result.responseText);
                    if(responseData.estado_plasma === 'Completo')
                    {
                        Ext.getCmp('tabPanel').down('#tab2').setDisabled(false);
                        Ext.getCmp('tabPanel').down('#tab3').setDisabled(false);



                    }
                    else{
                        Ext.getCmp('tabPanel').down('#tab4').setDisabled(true);
                    }
                },

                failure: function(response, opts) {
                    console.log('server-side failure with status code ' + response.status);
                }
            });


            Ext.Ajax.request({
                url: '../servidor/plasma/muestramarcador/obtener',
                method:"post",
                params: {
                    muestra: ID
                },
                success: function( result, request ) {
                    var responseData = Ext.JSON.decode(result.responseText);
                    if(responseData.success)
                    {
                        AUXILIAR = responseData.data[0].contador;
                        for (var i=1; i<responseData.data[0].contador; i++){
                            var panel = Ext.create('Ext.panel.Panel', {
                                margin: '10 10 10 10',
                                layout : {
                                    type  : 'vbox',
                                    pack  : 'center',
                                    align : 'middle'
                                },

                                items:[

                                {
                                    xtype: 'combobox',
                                    id: 'cbMarcador'+I,
                                    fieldLabel: 'Marcador Serológico',
                                    name: 'marcador',
                                    allowBlank: false,
                                    editable: false,
                                    displayField: 'nombre',
                                    queryMode: 'local',
                                    store: 'Marcador',
                                    valueField: 'id',
                                    labelStyle: 'font-weight:bold'
                                },


                                ],
                                renderTo: Ext.getBody()
                            });

                            I=I+1;
                            Ext.getCmp('frmRecepcion2').add(panel);
                        }

                        Ext.Ajax.request({
                            url: '../servidor/plasma/muestrakit/obtener',
                            method:"post",
                            params: {
                                muestra: ID
                            },
                            success: function( result, request ) {
                                var responseData = Ext.JSON.decode(result.responseText);

                                if(responseData.success)
                                {
                                    AUX = responseData.data[0].contador;
                                    for (var i=1; i<responseData.data[0].contador; i++){
                                        var panel = Ext.create('Ext.panel.Panel', {
                                            margin: '10 10 10 10',
                                            layout : {
                                                type  : 'vbox',
                                                pack  : 'center',
                                                align : 'middle'
                                            },

                                            items:[

                                            {
                                                xtype: 'combobox',
                                                id: 'cbKitM'+J,
                                                fieldLabel: 'Kit',
                                                name: 'kit',
                                                allowBlank: false,
                                                editable: false,
                                                displayField: 'nombre',
                                                queryMode: 'local',
                                                store: 'Kit',
                                                valueField: 'id',
                                                labelStyle: 'font-weight:bold'
                                            },
                                            {
                                                xtype: 'textfield',
                                                id: 'txtAbsCoi'+J,
                                                fieldLabel: 'Abs/COI',
                                                name: 'abs_coi',
                                                allowBlank: false,
                                                labelStyle: 'font-weight:bold'
                                            }

                                            ],
                                            renderTo: Ext.getBody()
                                        });

                                        J=J+1;
                                        Ext.getCmp('frmRecepcion1').add(panel);
                                    }
                                }
                            },

                            failure: function(response, opts) {
                                console.log('server-side failure with status code ' + response.status);
                            }
                        });

                        Ext.Ajax.request({
                            url: '../servidor/plasma/muestra/obtener',
                            method:"post",
                            params: {
                                muestra: ID
                            },
                            success: function( result, request ) {
                                var responseData = Ext.JSON.decode(result.responseText);
                                if(responseData.success)
                                {


                                    var rcptDate1=new Date(responseData.data['marcador'][0].fecha_ingreso);
                                    var fecha1 = Ext.Date.format(rcptDate1, 'Y-m-d');

                                    if(responseData.data['marcador'][0].fecha_transformacion !== null){
                                        var rcptDate2=new Date(responseData.data['marcador'][0].fecha_transformacion);
                                        var fecha2 = Ext.Date.format(rcptDate2, 'Y-m-d');
                                    }

                                    Ext.getCmp('txtAnalista').setValue(responseData.data['marcador'][0].usuario_recepcion);
                                    Ext.getCmp('txtFechaRecepcion').setValue(fecha1);
                                    Ext.getCmp('cbInstitucion').setValue(responseData.data['marcador'][0].institucion);
                                    Ext.getCmp('txtCodInstitucional').setValue(responseData.data['marcador'][0].id);

                                    Ext.getCmp('txtUbicacion').setValue(responseData.data['marcador'][0].ubicacion);
                                    Ext.getCmp('txtUbicacionPlasmoteca').setValue(responseData.data['marcador'][0].ubicacion_plasmoteca);

                                    if(responseData.data['marcador'][0].usuario_transformacion===null)
                                    Ext.getCmp('txtAnalista1').setValue(USUARIO);
                                    else{
                                        Ext.getCmp('txtAnalista1').setValue(responseData.data['marcador'][0].usuario_transformacion);
                                    }
                                    console.log(responseData.data['marcador'][0].estatus);

                                    if(responseData.data['marcador'][0].estatus === 1){
                                        Ext.getCmp('cbStatus').setValue(responseData.data['marcador'][0].estatus);
                                        Ext.getCmp('txtFechaTransformacion').setValue(fecha2);
                                        Ext.getCmp('txtLocalizacion').setValue(responseData.data['marcador'][0].localizacion_transformacion);
                                        Ext.getCmp('txtUbicacionSeroteca').setValue(responseData.data['marcador'][0].ubicacion_seroteca);
                                        Ext.getCmp('txtVolumen').setValue(responseData.data['marcador'][0].volumen);
                                        Ext.getCmp('txtConcentracion').setValue(responseData.data['marcador'][0].concentracion_calcio);
                                        Ext.getCmp('txtObservacionT').setVisible(false);
                                    }
                                    else {
                                        Ext.getCmp('cbStatus').setValue(responseData.data['marcador'][0].estatus);
                                        Ext.getCmp('txtFechaTransformacion').setValue(fecha2);
                                        Ext.getCmp('txtObservacionT').setValue(responseData.data['marcador'][0].observacion);
                                        Ext.getCmp('txtLocalizacion').setVisible(false);
                                        Ext.getCmp('txtUbicacionSeroteca').setVisible(false);
                                        Ext.getCmp('txtVolumen').setVisible(false);
                                        Ext.getCmp('txtConcentracion').setVisible(false);

                                    }

                                    Ext.getCmp('cbMarcadorM').setValue(responseData.data['marcador'][0].c);
                                    Ext.getCmp('txtAbsCoi').setValue(responseData.data['kit'][0].d);
                                    Ext.getCmp('cbKitM').setValue(responseData.data['kit'][0].b);


                                    for(var i = 0; i< AUXILIAR-1; i ++){
                                        Ext.getCmp('cbMarcador'+i).setValue(responseData.data['marcador'][i+1].c);

                                    }
                                    for(var j = 0; j< AUX-1; j ++){


                                        Ext.getCmp('txtAbsCoi'+j).setValue(responseData.data['kit'][j+1].d);
                                        Ext.getCmp('cbKitM'+j).setValue(responseData.data['kit'][j+1].b);

                                    }

                                }
                                else
                                {
                                    Ext.Msg.alert('Alerta','No hay información sobre la muestra');
                                }
                            },

                            failure: function(response, opts) {
                                console.log('server-side failure with status code ' + response.status);
                            }
                        });

                    }
                    else
                    {
                        Ext.Msg.alert('Alerta','No hay información sobre la muestra');
                    }
                },

                failure: function(response, opts) {
                    console.log('server-side failure with status code ' + response.status);
                }
            });
        }
    },

    onCbCodigoBChange: function(field, newValue, oldValue, eOpts) {
        valor = Ext.getCmp('cbCodigoB').getValue();

        var storeMuestra = Ext.getCmp('grdMuestras').getStore();
        storeMuestra.removeAll();
        storeMuestra.proxy.extraParams = {
            codigo:valor,
            busqueda: 2
        };
        storeMuestra.load();
    },

    onCbEstadoBSelect: function(combo, record, eOpts) {
        estado = Ext.getCmp('cbEstadoB').getValue();

        var storeMuestra = Ext.getCmp('grdMuestras').getStore();
        storeMuestra.removeAll();
        storeMuestra.proxy.extraParams = {
            estado:estado,
            busqueda: 1
        };
        storeMuestra.load();


    }

});
