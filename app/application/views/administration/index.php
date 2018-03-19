<h3>
	<?php echo __('manageit.administration'); ?>
	<span><?php echo __('manageit.administration_description'); ?></span>
</h3>

<div class="pad">

	<table class="table">
		<tr>
			<th><?php echo __('manageit.total_users'); ?></th>
			<td><?php echo $users; ?></td>
		</tr>
		<tr>
			<th><?php echo __('manageit.active_projects'); ?></th>
			<td><?php echo $active_projects; ?></td>
		</tr>
		<tr>
			<th><?php echo __('manageit.archived_projects'); ?></th>
			<td><?php echo $archived_projects; ?></td>
		</tr>
		<tr>
			<th><?php echo __('manageit.open_issues'); ?></th>
			<td><?php echo $issues['open']; ?></td>
		</tr>
		<tr>
			<th><?php echo __('manageit.closed_issues'); ?></th>
			<td><?php echo $issues['closed']; ?></td>
		</tr>
		<tr>
			<th>Manage IT <?php echo __('manageit.version'); ?></th>
			<td>v<?php echo Config::get('manageit.version'); ?></td>
		</tr>
		<tr>
			<th><?php echo __('manageit.version_release_date'); ?></th>
			<td><?php echo $release_date = Config::get('manageit.release_date'); ?></td>
		</tr>
	</table>

</div>
