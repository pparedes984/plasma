/*
 * File: app/store/Pruebas.js
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

Ext.define('plasma.store.Pruebas', {
    extend: 'Ext.data.Store',

    requires: [
        'plasma.model.Pruebas_Model',
        'Ext.data.proxy.Ajax',
        'Ext.data.writer.Json',
        'Ext.data.reader.Json'
    ],

    constructor: function(cfg) {
        var me = this;
        cfg = cfg || {};
        me.callParent([Ext.apply({
            storeId: 'Pruebas',
            model: 'plasma.model.Pruebas_Model',
            proxy: {
                type: 'ajax',
                api: {
                    create: '../servidor/plasma/pruebas/create',
                    read: '../servidor/plasma/pruebas/get',
                    update: '../servidor/plasma/pruebas/update',
                    destroy: '../servidor/plasma/pruebas/delete'
                },
                actionMethods: {
                    create: 'POST',
                    read: 'POST',
                    update: 'POST',
                    destroy: 'POST'
                },
                writer: {
                    type: 'json',
                    encode: true,
                    rootProperty: 'data'
                },
                reader: {
                    type: 'json',
                    rootProperty: 'data'
                }
            }
        }, cfg)]);
    }
});