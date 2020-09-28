/*
 * File: app/store/Tipo_situacion.js
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

Ext.define('plasma.store.Tipo_situacion', {
    extend: 'Ext.data.Store',

    requires: [
        'plasma.model.Estados_Model',
        'Ext.data.proxy.Ajax',
        'Ext.data.reader.Json',
        'Ext.data.writer.Json'
    ],

    constructor: function(cfg) {
        var me = this;
        cfg = cfg || {};
        me.callParent([Ext.apply({
            storeId: 'Tipo_situacion',
            autoLoad: true,
            model: 'plasma.model.Estados_Model',
            proxy: {
                type: 'ajax',
                api: {
                    create: '../servidor/plasma/tiposituacion/create',
                    read: '../servidor/plasma/tiposituacion/get',
                    update: '../servidor/plasma/tiposituacion/update',
                    destroy: '../servidor/plasma/tiposituacion/delete'
                },
                actionMethods: {
                    create: 'POST',
                    read: 'POST',
                    update: 'POST',
                    destroy: 'POST'
                },
                reader: {
                    type: 'json',
                    rootProperty: 'data'
                },
                writer: {
                    type: 'json',
                    encode: true,
                    rootProperty: 'data'
                }
            }
        }, cfg)]);
    }
});