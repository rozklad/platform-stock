<script type="text/template" data-grid="alias" data-template="results">

	<% _.each(results, function(r) { %>

		<tr data-grid-row>
			<td><input content="id" input data-grid-checkbox="" name="entries[]" type="checkbox" value="<%= r.id %>"></td>
			<td><a href="<%= r.edit_uri %>" href="<%= r.edit_uri %>"><%= r.id %></a></td>
			<td><%= r.usage_name %></td>
			<td><%= r.min %></td>
			<td><%= r.max %></td>
			<td><%= r.alias %></td>
			<td><%= r.product_id %></td>
			<td><%= r.created_at %></td>
		</tr>

	<% }); %>

</script>
