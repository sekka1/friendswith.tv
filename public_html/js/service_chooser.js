var ServiceChooser = {
		service_id:null,
		mso_id:null,
		submitZip:function(){
			zip=$('#search_zip').val();
			///console.log(zip);
			url = '/platform/services/'+zip+'.json';
			$.getJSON(url,function(data){
				console.log(data);
				var items = [];

				  $.each(data, function(key, val) {
				    items.push('<a onclick=\'ServiceChooser.select("' + val.ServiceId + '");\'><li data-msoid="' + val.MSOID + '" data-serviceid="' + val.ServiceId + '" id="' + val.ServiceId + '">' + val.Name + '</li></a>');
				  });

				  $('<ul/>', {
				    'class': 'my-new-list',
				    html: items.join('')
				  }).appendTo('#zip_results');
			});
		},
		select:function(id){
			FWTV.service_id = id;
			$.cookie('service_id',id);
			t=setTimeout(window.location="/ap/",300);
			//window.location="/ap/";
		}
};