var Content = Backbone.Model.extend({
	defaults: {
		channel:null,
		channel_id:null
    },
	initialize: function(){
		console.log("Welcome to this content");
		this.bind("change:channel", function(){
                //var channel = this.get("channel"); 
                //console.log("Changed my channel to " + channel );
        });
	}
});