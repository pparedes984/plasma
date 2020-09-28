/*
 * File: app/view/pnlKitViewController.js
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

Ext.define('plasma.view.pnlKitViewController', {
    extend: 'Ext.app.ViewController',
    alias: 'controller.pnlkit',

    onBtnNuevoKitClick: function(button, e, eOpts) {
        var win = Ext.create('plasma.view.wndKit');
        win.show();
        Ext.getCmp('cbEstadoK').setValue(1);
    },

    onBtnEliminarKitClick: function(button, e, eOpts) {
        //
        var g = Ext.getCmp('grdKit');
        var arrayKeys = g.getSelectionModel().selected.items;
        var indice = g.getSelectionModel().selectionStartIdx;
        if(arrayKeys.length === 0)
        Ext.Msg.alert('Error', 'Debe escoger un usuario');
        else
        {
            var store = g.getStore();
            var rec = g.selection;
            Ext.Ajax.request({
                url: '../servidor/plasma/kit/verificar',
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

    onRowEditingEdit: function(editor, context, eOpts) {
        var me = this;
        var store = Ext.getCmp('grdKit').getStore();
        var g = Ext.getCmp('grdKit');
        var reco = g.selection;
        var id = reco.data.id;
        var arrayKeys = g.getSelectionModel().selected.items;

        if (context.record.modified)
        {
            var reco = context.record;
            store.add(reco);
            store.sync(
            {
                params:{
                    id: id,

                    data: arrayKeys[0]


                },
                success: function(batch, success)
                {
                    store.commitChanges();
                    Ext.Msg.alert('Datos Guardados', 'Los datos se han guardado con éxito');
                    var strUsuario = Ext.getStore('UsuarioSistema');
                    store.removeAll();
                    store.proxy.extraParams={

                    };
                    store.load();
                },

                failure: function(batch, success)
                {
                    Ext.Msg.alert('Error', 'Hubor un error');
                }
            });
        }
    }

});