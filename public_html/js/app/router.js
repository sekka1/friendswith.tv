 var AppRouter = Backbone.Router.extend({
	routes: {
		"*actions": "defaultRoute" // matches http://example.com/#anything-here
	},
	defaultRoute: function( actions ){
		// The variable passed in matches the variable in the route definition "actions"
		console.log('defaultRoute:: '+ actions ); 
	}
});
// Initiate the router
var app_router = new AppRouter;
// Start Backbone history a neccesary step for bookmarkable URL's
Backbone.history.start();