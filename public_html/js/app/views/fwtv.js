FWTView = Backbone.View.extend({
	//template: $("#fwtvTemplate").html(),
	initialize: function(){
		console.log("Alerts suck.");
		this.render();
	},
	render: function(){
		device = new DeviceView();
	},
	events: {
		//"click input[type=button]": "doSearch"
	},
	doSearch: function( event ){
		// Button clicked, you can access the element that was clicked with event.currentTarget
		//alert( "Search for " + $("#search_input").val() );
	}
});