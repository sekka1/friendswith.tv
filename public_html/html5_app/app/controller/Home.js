Ext.define('FTV.controller.Home', {
	extend: 'Ext.app.Controller',
	config: {
	    refs: {
	        homeView: 'homeview',
	        showHeader: 'homeview #show-header'
	    },
	    control: {
	        'homeview button[action=share]': {
	            tap: 'onBtnShareTap'
	        }
	    }
	},
	
	init: function() {
	    var me = this;
	    
	    me.getApplication().on({
	        scope: me,
	        'displayshow': me.onDisplayShow
	    });
	},

//app listeners
	onDisplayShow: function(showId) {
	    this.getHomeView().element.applyStyles({
	        'background-image': 'url(resources/images/shows_mock/blackswan.png)'
	    });
	    /*
	    this.getShowHeader().setData({
            showTitle: 'Black Swan',
            season: 1,
            episode: 3
        });*/
        
        this.getShowHeader().setData({
            showTitle: 'Black Swan',
            year: 2011,
            star: 'Natalie Portman'
        });
	},
	
//listeners
	onBtnShareTap: function() {
	    Ext.Viewport.add({ 
	        xtype: 'shareview'
	    });
	}
});