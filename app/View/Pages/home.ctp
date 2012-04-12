<?php 
	if(!$this->Session->check('Auth.User')){
		$this->layout = 'splash';
	}
	
	$devices = $sdp->devices(); 
	if($devices){
?>
		<h1>Add a checkin</h1>
		<table id="add-table">
			<tbody>
				<tr>
					<th>ContentId</th>
					<td><input id="add-contentId" size="32"/></td>
				</tr>
				<tr>
					<th>UserId</th>
					<td><input id="add-userId" size="32" value="<?php echo AuthComponent::user('id');?>" /></td>
				</tr>
			</tbody>
		</table>
		<input id="add-checkin" type="button" value="Checkin"/>
		<input id="add-rec" type="button" value="Send To a Friend"/>

<?php 		
		//debug($devices);
	}else{
		$this->element('splash');
	}
?>
<script>
$(function() {
	$("#add-checkin").click(function(e) {
		var checkin = new Checkin({
			user_id : $('#add-userId').val(),
			content_id : $('#add-contentId').val()
		});
		checkin.save();
	});

	$("#add-rec").click(function(e) {
		var rec = new Rec({
			user_id : $('#add-userId').val(),
			content_id : $('#add-contentId').val()
		});
		rec.save();
	});

	
	$('#list-button').click(function(e){
		var customers = new Customers;
		customers.fetch({
			success : function(customers, response) {
				var tr = $('#list-table>tbody>tr');
				if(tr.length > 0) {
					tr.remove();
				}
				var tbody = $('#list-table>tbody');
				var i;
				for(i = 0; i < customers.length; ++i) {
					var customer = customers.at(i);
					tbody.append('<tr><td>' + customer.get('id') + 
							'</td><td>' + customer.get('name') +
							'</td><td>' + customer.get('address') +
							'</td></tr>');
				}
			},
			error : function(customers, response) {
				alert('error: ' + response);
			}
		});
	});
	
	$('#update-read_button').click(function(e){
		var customer = new Customer({
			id : $('#update-read_id').val()
		});
		customer.fetch({
			success : function(customer, response) {
				$('#update-name').val(customer.get('name'));
				$('#update-address').val(customer.get('address'));
			},
			error : function(customers, response) {
				alert('error: ' + response);
			}
		});
	});
	
	$('#update-update_button').click(function(e){
		var customer = new Customer({
			id : $('#update-read_id').val(),
			name : $('#update-name').val(),
			address : $('#update-address').val()
		});
		customer.save();
	});
	
	$('#delete-button').click(function(e){
		var customer = new Customer({
			id : $('#delete-id').val()
		});
		customer.destroy();
	});
});

</script>