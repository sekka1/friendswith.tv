DeviceView = Backbone.View.extend({
	template: $("#deviceTemplate").html(),
	initialize: function(){
		console.log("initialize DeviceView");
		this.render();
	},
	render: function(){
		console.log("render DeviceView");
		var tmpl = _.template(this.template);
        this.$el.html(tmpl(this.model.toJSON()));
        return this;
		// Compile the template using underscore
		//var template = _.template( $("#search_template").html(), {} );
		// Load the compiled HTML into the Backbone "el"
		//this.el.html( template );
	},
	events: {
		//"click input[type=button]": "doSearch"
	},
	doSearch: function( event ){
		// Button clicked, you can access the element that was clicked with event.currentTarget
		//alert( "Search for " + $("#search_input").val() );
	}
});

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