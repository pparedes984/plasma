/*
 * File: app/view/pnlCasa.js
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

Ext.define('plasma.view.pnlCasa', {
    extend: 'Ext.panel.Panel',
    alias: 'widget.pnlcasa',

    requires: [
        'plasma.view.pnlCasaViewModel',
        'plasma.view.pnlCasaViewController',
        'Ext.toolbar.Toolbar',
        'Ext.button.Button',
        'Ext.grid.Panel',
        'Ext.view.Table',
        'Ext.form.field.Text',
        'Ext.grid.column.Check',
        'Ext.form.field.Checkbox',
        'Ext.grid.plugin.RowEditing'
    ],

    controller: 'pnlcasa',
    viewModel: {
        type: 'pnlcasa'
    },
    layout: 'fit',
    title: 'Casa Comercial',

    dockedItems: [
        {
            xtype: 'toolbar',
            dock: 'top',
            items: [
                {
                    xtype: 'button',
                    id: 'btnNuevoCasa',
                    iconAlign: 'right',
                    iconCls: 'x-fa fa-plus',
                    text: 'Nuevo',
                    listeners: {
                        click: 'onBtnNuevoCasaClick'
                    }
                },
                {
                    xtype: 'button',
                    id: 'btnEliminarCasa',
                    iconAlign: 'right',
                    iconCls: 'x-fa fa-trash',
                    text: 'Eliminar',
                    listeners: {
                        click: 'onBtnEliminarCasaClick'
                    }
                }
            ]
        }
    ],
    items: [
        {
            xtype: 'gridpanel',
            id: 'grdCasa',
            title: '',
            forceFit: true,
            store: 'Casa',
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