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
<tr>
	<td>GET</td>
	<td>/recs.format</td>
	<td>RecsController::index()</td>
</tr>
<tr>
	<td>GET</td>
	<td>/recs/123.format</td>
	<td>RecsController::view(123)</td>
</tr>
<tr>
	<td>POST</td>
	<td>/recs.format</td>
	<td>RecsController::add()</td>
</tr>
<tr>
	<td>PUT</td>
	<td>/recs/123.format</td>
	<td>RecsController::edit(123)</td>
</tr>
<tr>
	<td>DELETE</td>
	<td>/recs/123.format</td>
	<td>RecsController::delete(123)</td>
</tr>
<tr>
	<td>POST</td>
	<td>/recs/123.format</td>
	<td>RecsController::edit(123)</td>
</tr>
</tbody>
</table>
