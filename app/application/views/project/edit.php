<h3>
	<a href="<?php echo Project::current()->to('issue/new'); ?>" class="newissue"><?php echo __('manageit.new_issue'); ?></a>

	<?php echo __('manageit.update'); ?> <?php echo Project::current()->name; ?>
	<span><?php echo __('manageit.update_project_description'); ?></span>
</h3>


<div class="pad">

	<form method="post" action="">

		<table class="form" style="width: 80%;">
			<tr>
				<th style="width: 10%;"><?php echo __('manageit.name'); ?></th>
				<td><input type="text" style="width: 98%;" name="name" value="<?php echo Input::old('name', Project::current()->name); ?>" /></td>
			</tr>
			<tr>
				<th><?php echo __('manageit.status') ?></th>
				<td><?php echo Form::select('status', array(1 => 'Open', 0 => 'Archived'), Project::current()->status); ?></td>
			</tr>
			<tr>
				<th></th>
				<td>
					<input type="submit" value="<?php echo __('manageit.update'); ?>" />
					<input type="submit" name="delete" value="<?php echo __('manageit.delete'); ?> <?php echo Project::current()->name; ?>" onclick="return confirm('<?php echo __('manageit.delete_project_confirm'); ?>');" />
				</td>
			</tr>
		</table>

	</form>

</div>
