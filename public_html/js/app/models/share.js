var Share = Backbone.Model.extend({
	url:'/shares',
	defaults: {
		id:null,
		contentId:null,
		scheduleId:null
    },
	initialize: function(){
	}
});