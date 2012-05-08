ServiceChooserView = Backbone.View.extend({
	el: $("#service_chooser").html(),
	initialize: function(){
		console.log("ServiceChooserView.");
		this.render();
	},
	events: {
		"click #search_button": "doZipSearch"
	},
	render: function(){
		//device = new DeviceView();
	},
	doZipSearch: function( event ){
		console.log('doZipSearch');
		console.log(event);
		// Button clicked, you can access the element that was clicked with event.currentTarget
		//alert( "Search for " + $("#search_input").val() );
	}
});