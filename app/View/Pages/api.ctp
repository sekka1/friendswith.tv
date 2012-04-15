<h2>Check-Ins</h2>
<table border="1" class="docutils">
<colgroup>
<col width="18%" />
<col width="34%" />
<col width="48%" />
</colgroup>
<thead valign="bottom">
<tr><th class="head">HTTP format</th>
	<th class="head">URL.format</th>
	<th class="head">Controller action invoked</th>
</tr>
</thead>
<tbody valign="top">
<tr>
	<td>GET</td>
	<td>/checkins.format</td>
	<td>CheckinsController::index()</td>
</tr>
<tr>
	<td>GET</td>
	<td>/checkins/123.format</td>
	<td>CheckinsController::view(123)</td>
</tr>
<tr>
	<td>POST</td>
	<td>/checkins.format</td>
	<td>CheckinsController::add()</td>
</tr>
<tr>
	<td>PUT</td>
	<td>/checkins/123.format</td>
	<td>CheckinsController::edit(123)</td>
</tr>
<tr>
	<td>DELETE</td>
	<td>/checkins/123.format</td>
	<td>CheckinsController::delete(123)</td>
</tr>
<tr>
	<td>POST</td>
	<td>/checkins/123.format</td>
	<td>CheckinsController::edit(123)</td>
</tr>

</tbody>
</table>

<h2>Shares</h2>
<table border="1" class="docutils">
<colgroup>
<col width="18%" />
<col width="34%" />
<col width="48%" />
</colgroup>
<thead valign="bottom">
<tr><th class="head">HTTP format</th>
	<th class="head">URL.format</th>
	<th class="head">Controller action invoked</th>
</tr>
</thead>
<tbody valign="top">
<tr>
	<td>GET</td>
	<td>/shares.format</td>
	<td>SharesController::index()</td>
</tr>
<tr>
	<td>GET</td>
	<td>/shares/123.format</td>
	<td>SharesController::view(123)</td>
</tr>
<tr>
	<td>POST</td>
	<td>/shares.format</td>
	<td>SharesController::add()</td>
</tr>
<tr>
	<td>PUT</td>
	<td>/shares/123.format</td>
	<td>SharesController::edit(123)</td>
</tr>
<tr>
	<td>DELETE</td>
	<td>/shares/123.format</td>
	<td>SharesController::delete(123)</td>
</tr>
<tr>
	<td>POST</td>
	<td>/shares/123.format</td>
	<td>SharesController::edit(123)</td>
</tr>

</tbody>
</table>


<h2>Friends</h2>
<table border="1" class="docutils">
<colgroup>
<col width="18%" />
<col width="34%" />
<col width="48%" />
</colgroup>
<thead valign="bottom">
<tr><th class="head">HTTP format</th>
	<th class="head">URL.format</th>
	<th class="head">Controller action invoked</th>
</tr>
</thead>
<tbody valign="top">
<tr>
	<td>GET</td>
	<td>/friends.format</td>
	<td>FriendsController::index()</td>
</tr>
</tbody>
</table>
