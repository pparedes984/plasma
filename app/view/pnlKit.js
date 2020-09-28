/*
 * File: app/view/pnlKit.js
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

Ext.define('plasma.view.pnlKit', {
    extend: 'Ext.panel.Panel',
    alias: 'widget.pnlkit',

    requires: [
        'plasma.view.pnlKitViewModel',
        'plasma.view.pnlKitViewController',
        'Ext.toolbar.Toolbar',
        'Ext.button.Button',
        'Ext.grid.Panel',
        'Ext.view.Table',
        'Ext.form.field.ComboBox',
        'Ext.grid.column.Check',
        'Ext.form.field.Checkbox',
        'Ext.grid.plugin.RowEditing'
    ],

    controller: 'pnlkit',
    viewModel: {
        type: 'pnlkit'
    },
    layout: 'fit',
    title: 'Kit de Reactivo',

    dockedItems: [
        {
            xtype: 'toolbar',
            dock: 'top',
            items: [
                {
                    xtype: 'button',
                    id: 'btnNuevoKit',
                    iconAlign: 'right',
                    iconCls: 'x-fa fa-plus',
                    text: 'Nuevo',
                    listeners: {
                        click: 'onBtnNuevoKitClick'
                    }
                },
                {
                    xtype: 'button',
                    id: 'btnEliminarKit',
                    iconAlign: 'right',
                    iconCls: 'x-fa fa-trash',
                    text: 'Eliminar',
                    listeners: {
                        click: 'onBtnEliminarKitClick'
                    }
                }
            ]
        }
    ],
    items: [
        {
            xtype: 'gridpanel',
            id: 'grdKit',
            minHeight: 300,
            title: '',
            forceFit: true,
            store: 'Kit',
            columns: [
                {
                    xtype: 'gridcolumn',
                    dataIndex: 'nombre',
                    text: 'Nombre',
                    editor: {
                        xtype: 'textfield'
                    }
                },
                {
                    xtype: 'gridcolumn',
                    renderer: function(value, metaData, record, rowIndex, colIndex, store, view) {

                        if(view)
                        {
                            var descripcion = record.data.casa_comercial;
                            var combo = metaData.column.getEditor();
                            var comboStore = combo.getStore();
                            var indice = comboStore.findExact(combo.valueField, value);
                            if (indice >= 0)
                            return comboStore.getAt(indice).get(combo.displayField);
                            else
                            return descripcion;
                        }
                        else
                        return null;
                    },
                    dataIndex: 'casa_comercial',
                    text: 'Casa Comercial',
                    editor: {
                        xtype: 'combobox',
                        id: 'cbCasa',
                        allowBlank: false,
                        editable: false,
                        displayField: 'nombre',
                        queryMode: 'local',
                        store: 'Casa',
                        valueField: 'id'
                    }
                },
                {
                    xtype: 'checkcolumn',
                    disabled: true,
                    dataIndex: 'estado',
                    text: 'Estado',
                    editor: {
                        xtype: 'checkboxfield'
                    }
                }
            ],
            plugins: [
                {
                    ptype: 'rowediting',
                    listeners: {
                        edit: 'onRowEditingEdit'
                    }
                }
            ]
        }
    ]

});