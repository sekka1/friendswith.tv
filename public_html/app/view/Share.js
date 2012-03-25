Ext.define('FTV.view.Share', {
    extend: 'Ext.Panel',
    xtype: 'shareview',
    config: {
        modal: true,
        centered: true,
        width: 300,
        height: 200,
        items: [{
            xtype: 'toolbar',
            items: [{
                text: 'Direct Message'
            },{
                xtype: 'component',
                html: '|'
            },{
                text: 'Social'
            }]
        },{
            xtype: 'playercontrol'
        }]
    }
});