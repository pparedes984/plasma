/*
 * File: app/view/vwprtLogin.js
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

Ext.define('plasma.view.vwprtLogin', {
    extend: 'Ext.container.Viewport',
    alias: 'widget.vwprtlogin',

    requires: [
        'plasma.view.vwprtLoginViewModel',
        'plasma.view.vwprtLoginViewController',
        'Ext.form.Panel',
        'Ext.form.field.Text',
        'Ext.button.Button',
        'Ext.form.field.Hidden',
        'Ext.form.Label'
    ],

    controller: 'vwprtlogin',
    viewModel: {
        type: 'vwprtlogin'
    },
    height: 250,
    width: 400,
    layout: 'border',

    items: [
        {
            xtype: 'panel',
            region: 'center',
            layout: 'center',
            bodyStyle: 'background-color : #666666',
            header: false,
            title: 'My Panel',
            items: [
                {
                    xtype: 'panel',
                    height: 350,
                    width: 550,
                    layout: 'border',
                    header: false,
                    title: 'My Panel',
                    items: [
                        {
                            xtype: 'panel',
                            region: 'north',
                            height: 150,
                            html: '<center><img src="../servidor/img/logo_labok.jpg" height="150"> </center>',
                            header: false,
                            title: 'My Panel'
                        },
                        {
                            xtype: 'form',
                            region: 'center',
                            id: 'frmLogin',
                            bodyPadding: 10,
                            header: false,
                            title: 'Login',
                            titleAlign: 'center',
                            layout: {
                                type: 'vbox',
                                align: 'center'
                            },
                            items: [
                                {
                                    xtype: 'textfield',
                                    margin: '20 0 10 0',
                                    fieldLabel: 'Usuario',
                                    labelAlign: 'right',
                                    name: 'usuario',
                                    allowBlank: false
                                },
                                {
                                    xtype: 'textfield',
                                    fieldLabel: 'Clave',
                                    labelAlign: 'right',
                                    name: 'clave',
                                    inputType: 'password',
                                    allowBlank: false,
                                    listeners: {
                                        specialkey: 'onTextfieldSpecialkey'
                                    }
                                },
                                {
                                    xtype: 'button',
                                    text: 'Aceptar',
                                    listeners: {
                                        click: 'onButtonClick'
                                    }
                                },
                                {
                                    xtype: 'hiddenfield',
                                    anchor: '100%',
                                    fieldLabel: 'Label',
                                    name: 'aplicacion',
                                    value: 'plasma'
                                }
                            ]
                        },
                        {
                            xtype: 'panel',
                            region: 'south',
                            layout: {
                                type: 'vbox',
                                align: 'center'
                            },
                            items: [
                                {
                                    xtype: 'label',
                                    margin: '0 0 15 0',
                                    style: 'fontFamily : Georgia; font-style: italic; font-size: 15px',
                                    text: 'Desarrollado por la Dirección Informática | PUCE'
                                }
                            ]
                        }
                    ]
                }
            ]
        }
    ]

});