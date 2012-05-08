var FWTV = {
	service_id:null,
	mso_is:null,
	user_id:null,
	fbu_id:null,
	start:function(){
		if($.cookie('service_id')){
			window.location = '/ap/';
		}else{
			FWTV.showStartScreen();
		}
	},
	showStartScreen:function(){
		console.log('showStartScreen');
		//var scview = new ServiceChooserView();
		//scview.render();

		//var $modalEl = $("#modal");
		//console.log(scview.el);
		//$modalEl.html(scview.el);
		//$modalEl.modal();
		$('#service_chooser').modal({})
	}
}