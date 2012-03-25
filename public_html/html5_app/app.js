//<debug>
Ext.Loader.setPath({
    'Ext': 'sdk/src',
    'Ext.PlayerControl': 'lib/PlayerControl.js',
    'Ext.plugin.SliderFill': 'lib/SliderFill.js',
    'SDPWeb': 'lib/SDPWeb.js'
});

Ext.require([
    'Ext.carousel.Carousel',
    'Ext.data.JsonP',
    'Ext.field.Slider',
    'Ext.MessageBox',
    'Ext.PlayerControl',
    'Ext.plugin.SliderFill',
    'SDPWeb'
]);
//</debug>

Ext.application({
    name: 'FTV',
    controllers: [
		'Home'
	],
    views: [
		'Home',
		'Share'
	],
    icon: {
        57: 'resources/icons/Icon.png',
        72: 'resources/icons/Icon~ipad.png',
        114: 'resources/icons/Icon@2x.png',
        144: 'resources/icons/Icon~ipad@2x.png'
    },
    phoneStartupScreen: 'resources/loading/Homescreen.jpg',
    tabletStartupScreen: 'resources/loading/Homescreen~ipad.jpg',

    launch: function() {
        // Destroy the #appLoadingIndicator element
        Ext.fly('appLoadingIndicator').destroy();

        // Initialize the main view
        Ext.Viewport.add(Ext.create('FTV.view.Home'));
        
        //mock
        this.fireEvent('displayshow', 1);
    },

    onUpdated: function() {
        Ext.Msg.confirm(
            "Application Update",
            "This application has just successfully been updated to the latest version. Reload now?",
            function() {
                window.location.reload();
            }
        );
    }
});
