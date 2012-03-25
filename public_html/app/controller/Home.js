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
	        'deviceready': me.updateView,
	        'channelchange': me.updateView
	    });
	},

//app listeners
	updateView: function(deviceId, newContext, oldContext) {
	    var me = this;
	    
	    //<debug>
	    if (Ext.Logger.log) {
	        Ext.Logger.log("updateView " + Ext.encode(newContext));
	    }
	    //</debug>
	    
        if (!me.getHomeView()) {
            Ext.Viewport.add({
                xtype:'homeview'
            });
        }

	    me.getHomeView().element.applyStyles({
	        'background-image': 'url(' + newContext.contentImage + ')'
	    });
	    
	    me.getShowHeader().setData({
            showTitle: newContext.seriesTitle,
            season: 1,
            episode: 3
        });
	},
	
//listeners
	onBtnShareTap: function() {
	    Ext.Viewport.add({ 
	        xtype: 'shareview'
	    });
	}
});