var Checkin = Backbone.Model.extend({
	url:'/checkins',
	defaults: {
		id:null,
		contentId:null
    },
	initialize: function(){
	}
});