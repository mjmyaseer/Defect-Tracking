<h3>
	<?php echo __('manageit.projects');?>
	<span><?php echo __('manageit.projects_description');?></span>
</h3>

<div class="pad">

	<ul class="tabs">
		<li <?php echo $active == 'active' ? 'class="active"' : ''; ?>>
			<a href="<?php echo URL::to('projects'); ?>">
				<?php echo $active_count == 1 ? '1 '.__('manageit.active').' '.__('manageit.project') : $active_count . ' '.__('manageit.active').' '.__('manageit.projects'); ?>
			</a>
		</li>
		<li <?php echo $active == 'archived' ? 'class="active"' : ''; ?>>
			<a href="<?php echo URL::to('projects'); ?>?status=0">
				<?php echo $archived_count == 1 ? '1 '.__('manageit.archived').' '.__('manageit.project') : $archived_count . ' '.__('manageit.archived').' '.__('manageit.projects'); ?>
				</a>
		</li>
	</ul>

	<div class="inside-tabs">

		<div class="blue-box">

			<div class="inside-pad">
				<ul class="projects">
					<?php foreach($projects as $row):
						$issues = $row->issues()->where('status', '=', 1)->count();
					?>
					<li>
						<a href="<?php echo $row->to(); ?>"><?php echo $row->name; ?></a><br />
						<?php echo $issues == 1 ? '1 '. __('manageit.open_issue') : $issues . ' '. __('manageit.open_issues'); ?>
					</li>
					<?php endforeach; ?>

					<?php if(count($projects) == 0): ?>
					<li>
						<?php echo __('manageit.you_do_not_have_any_projects'); ?> <a href="<?php echo URL::to('projects/new'); ?>"><?php echo __('manageit.create_project'); ?></a>
					</li>
					<?php endif; ?>
				</ul>
				


			</div>

		</div>

	</div>

</div>
