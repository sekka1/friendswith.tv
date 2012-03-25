Ext.define('FTV.view.ContentInfo', {
    extend: 'Ext.Container',
    xtype: 'contentinfo',
    config: {
        cls: 'ftw-contentinfoview',
        tpl: [
            '<img src="{contentImage}" />',
            '<div class="column">',
                '<h1>{[values.seriesTitle||values.contentTitle]}<span>{yearOfRelease}</span></h1>',
                '<tpl if="contentSynopsis">',
                    '<p>',
                        '{contentSynopsis}',
                    '</p>',
                '</tpl>',
            '</div>'
        ]
    }
});