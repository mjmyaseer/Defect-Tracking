<h3>
	<a href="<?php echo URL::to('administration/users/add');?>" class="addnewuser"><?php echo __('manageit.add_new_user'); ?></a>
	<?php echo __('manageit.users'); ?>
	<span><?php echo __('manageit.users_description'); ?></span>
</h3>

<div class="pad">

	<div id="users-list">

		<?php foreach($roles as $role):?>

			<h4>
				<?php echo $role->name; ?>
				<span><?php echo $role->description; ?></span>
			</h4>

			<ul>
				<?php foreach(User::where('role_id', '=', $role->id)->where('deleted', '=', 0)->order_by('firstname', 'asc')->get() as $user): ?>
				<li>
					<ul>
						<?php if(!$user->me()): ?>
						<li class="delete">
							<a href="<?php echo URL::to('administration/users/delete/' . $user->id);?>" onClick="return confirm('<?php echo __('manageit.delete_user_confirm'); ?>');" class="button tiny error right"><?php echo __('manageit.delete'); ?></a>
						</li>
						<?php endif; ?>
						<li class="edit">
							<a href="<?php echo URL::to('administration/users/edit/' . $user->id);?>"><?php echo __('manageit.edit'); ?></a>
						</li>
					</ul>

					<a class="name" href="<?php echo URL::to('administration/users/edit/' . $user->id);?>"><?php echo $user->firstname . ' ' . $user->lastname; ?></a>

				</li>
				<?php endforeach; ?>
			</ul>

		<?php endforeach; ?>

	</div>

</div>