var Channel = Backbone.Model.extend({
	defaults: {
		id:null,
		number:null
    },
	initialize: function(){
		console.log("Welcome to this channel");
		this.bind("change:channel", function(){
                //var channel = this.get("channel"); 
                //console.log("Changed my channel to " + channel );
        });
	}
});