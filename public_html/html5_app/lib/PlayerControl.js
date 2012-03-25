Ext.define('Ext.PlayerControl', {
    extend: 'Ext.Toolbar',
    xtype: 'playercontrol',
    config: {
        cls: Ext.baseCSSPrefix + 'playercontrol',
        items: [{
            xtype: 'button',
            itemId: 'player-btn',
            ui: 'player',
            iconCls: 'pause',
            iconMask: true
        },{
            xtype: 'sliderfield',
            flex: 1,
            plugins: [{
                xclass : 'Ext.plugin.SliderFill'
            }]
        },{
            xtype: 'component',
            itemId: 'end-time',
            html: '00:00:00'
        }]
    }
});