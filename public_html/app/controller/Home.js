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
	        },
	        'homeview button[action=checkin]': {
	            tap: 'onBtnCheckinTap'
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

    /**
     * Fire the new device context into the application,
     * and refreshes the view
     */
	updateView: function(deviceId, newContext, oldContext) {
	    var me = this;
	    
	    //<debug>
	    if (Ext.Logger.log) {
	        Ext.Logger.log("updateView " + Ext.encode(newContext));
	    }
	    //</debug>
	    
	    me.getApplication().deviceContext = newContext;
	    
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
	},
	
	onBtnCheckinTap: function(btn) {
	    var view,
	        context = this.getApplication().deviceContext;

	    if (btn.getUi() === 'rounded action') {
	        btn.setUi('rounded');
	        return;
	    }
	    
	    btn.setUi('rounded action');
	    
	    view = Ext.Viewport.add({ 
	        xtype: 'checkinview',
	        data: context
	    });
	    
	    view.element.on('tap', view.destroy, view, {single: true});
	}
});