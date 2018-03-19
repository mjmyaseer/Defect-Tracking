<h3>
	<?php echo __('manageit.update_user'); ?>
	<span><?php echo __('manageit.update_user_description'); ?></span>
</h3>

<div class="pad">

	<form method="post" action="">

		<table class="form">
			<tr>
				<th><?php echo __('manageit.first_name'); ?></th>
				<td>
					<input type="text" name="firstname" value="<?php echo Input::old('firstname', $user->firstname); ?>" autocomplete="off" />

					<?php echo $errors->first('firstname', '<span class="error">:message</span>'); ?>
				</td>
			</tr>
			<tr>
				<th><?php echo __('manageit.last_name'); ?></th>
				<td>
					<input type="text" name="lastname" value="<?php echo Input::old('lastname',$user->lastname);?>" autocomplete="off" />

					<?php echo $errors->first('lastname', '<span class="error">:message</span>'); ?>
				</td>
			</tr>
			<tr>
				<th><?php echo __('manageit.email'); ?></th>
				<td>
					<input type="text" name="email" value="<?php echo Input::old('email',$user->email)?>"  autocomplete="off" />

					<?php echo $errors->first('email', '<span class="error">:message</span>'); ?>
				</td>
			</tr>
			<tr>
				<th><?php echo __('manageit.role'); ?></th>
				<td>
					<?php echo Form::select('role_id',Role::dropdown(),$user->role_id); ?>
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<?php echo __('manageit.only_complete_if_changing_password'); ?>
				</th>
			</tr>
			<tr>
				<th><?php echo __('manageit.new_password'); ?></th>
				<td>
					<input type="password" name="password" value="" autocomplete="off" />

					<?php echo $errors->first('password', '<span class="error">:message</span>'); ?>
				</td>
			</tr>
			<tr>
				<th><?php echo __('manageit.confirm'); ?></th>
				<td>
					<input type="password" name="password_confirmation" value="" autocomplete="off" />
				</td>
			</tr>
			<tr>
				<th></th>
				<td>
					<input type="submit" value="<?php echo __('manageit.update'); ?>" class="button	primary"/>
				</td>
			</tr>
		</table>

		<?php echo Form::token(); ?>
	</form>

</div>