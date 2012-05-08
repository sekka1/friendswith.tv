$(document).ready(function(){
	if(typeof(devices)!='undefined'){
		console.log(devices);
		for (var device_id in devices){
			devices[device_id].id = device_id;
			window['device_'+device_id] = new Device(devices[device_id]);
		}
	}else{
		console.log('no devices');
	}
	//FWTV.start();
});