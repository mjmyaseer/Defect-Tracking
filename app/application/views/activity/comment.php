<li onclick="window.location='<?php echo $issue->to(); ?>#comment<?php echo $comment->id; ?>';">

	<div class="tag">
		<label class="label notice"><?php echo __('manageit.label_comment'); ?></label>
	</div>

	<div class="data">
		<span class="comment">
			<?php echo str_replace(array("<p>","</p>"), "", \Sparkdown\Markdown('"' . Str::limit($comment->comment, 60) . '"')); ?>
		</span>
		<?php echo __('manageit.by'); ?>
		<strong><?php echo $user->firstname . ' ' . $user->lastname; ?></strong> <?php echo __('manageit.on_issue'); ?> <a href="<?php echo $issue->to(); ?>"><?php echo $issue->title; ?></a>
		<span class="time">
			<?php echo date('F jS \a\t g:i A', strtotime($activity->created_at)); ?>
		</span>
	</div>

	<div class="clr"></div>
</li>
