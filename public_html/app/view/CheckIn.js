Ext.define('FTV.view.CheckIn', {
    extend: 'Ext.Container',
    xtype: 'checkinview',
    config: {
        modal: true,
        centered: true,
        width: 300,
        height: 200,
        data: {
            contentImage: 'resources/images/shows_mock/blackswan_poster.png',
            seriesTitle: 'Black Swan'
        },
        tpl: [
            '<img src="{contentImage}" />',
            '<div class="column">',
                '<p>You checked in with...</p>',
                '<h1>{seriesTitle}</h1>',
            '</div>'
        ]
    }
});