Ext.define('FTV.view.CheckIn', {
    extend: 'Ext.Container',
    xtype: 'checkinview',
    config: {
        cls: 'ftw-checkinview',
        modal: true,
        centered: true,
        hideOnMaskTap: true,
        tpl: [
            '<img src="{contentImage}" />',
            '<div class="column">',
                '<p class="caption">You checked in with...</p>',
                '<h1>{seriesTitle}</h1>',
                '<tpl if="yearOfRelease">',
                    '<p>',
                        '{yearOfRelease}, Starring {star}<br />',
                        'Director: {director}',
                    '</p>',
                '</tpl>',
            '</div>'
        ]
    }
});