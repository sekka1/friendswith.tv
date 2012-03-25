Ext.define('FTV.view.Home', {
    extend: 'Ext.Container',
    xtype: 'homeview',
    config: {
        cls: 'ftv-homeview',
        layout: {
            type: 'vbox',
            align: 'stretch'
        },
        items: [{
            xtype: 'container',
            cls: 'header',
            items: [{
                xtype: 'container',
                layout: {
                    type: 'hbox',
                    align: 'stretch'
                },
                items: [{
                    xtype: 'component',
                    itemId: 'show-header',
                    cls: 'show-header',
                    flex: 1,
                    tpl: [
                        '<h1>{showTitle}</h1>',
                        '<tpl if="season">',
                            '<h2>Season {season}, Episode {episode}',
                        '</tpl>',
                        '<tpl if="year && star">',
                            '<h2>{year}, {star}',
                        '</tpl>'
                    ]
                },{
                    xtype: 'button',
                    iconCls: 'ico-check',
                    ui: 'rounded',
                    action: 'checkin'
                },{
                    xtype: 'button',
                    iconCls: 'ico-arrow',
                    ui: 'rounded',
                    action: 'share'
                }]
            },{
                xtype: 'playercontrol'
            }]
        },{
            xtype: 'carousel',
            ui: 'light',
            flex: 1,
            items: [{
                html: 'IMDB Data'
            },{
                html: 'View 2'
            },{
                html: 'View 3'
            }]
        }]
    }
});