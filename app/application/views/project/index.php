<h3>
   <a href="<?php echo Project::current()->to('issue/new'); ?>" class="newissue"><?php echo __('manageit.new_issue');?></a>
   <a href="<?php echo Project::current()->to(); ?>"><?php echo Project::current()->name; ?></a>
	<span><?php echo __('manageit.project_overview');?></span>
</h3>

<div class="pad">

	<ul class="tabs">
		<li <?php echo $active == 'activity' ? 'class="active"' : ''; ?>>
			<a href="<?php echo Project::current()->to(); ?>"><?php echo __('manageit.activity');?></a>
		</li>
		<li <?php echo $active == 'open' ? 'class="active"' : ''; ?>>
			<a href="<?php echo Project::current()->to('issues'); ?>">
			<?php echo $open_count == 1 ? '1 '.__('manageit.open_issue') : $open_count . ' '.__('manageit.open_issues'); ?>
			</a>
		</li>
		<li <?php echo $active == 'closed' ? 'class="active"' : ''; ?>>
			<a href="<?php echo Project::current()->to('issues'); ?>?status=0">
			<?php echo $closed_count == 1 ? '1 '.__('manageit.closed_issue') : $closed_count . ' '.__('manageit.closed_issues'); ?>
			</a>
		</li>
		<li <?php echo $active == 'assigned' ? 'class="active"' : ''; ?>>
			<a href="<?php echo Project::current()->to('assigned'); ?>?status=1">
			<?php echo $assigned_count == 1 ? '1 '.__('manageit.issue_assigned_to_you') : $assigned_count . ' '.__('manageit.issues_assigned_to_you'); ?>
			</a>
		</li>
        <?php if (Auth::user()->id == 1){  ?>
        <li <?php echo $active == 'remark' ? 'class="active"' : ''; ?>>
            <a href="<?php echo Project::current()->to('remarks'); ?>?status=3">
                <?php echo __('manageit.defect_density'); ?>
            </a>
        </li>
            <li <?php echo $active == 'drr' ? 'class="active"' : ''; ?>>
            <a href="<?php echo Project::current()->to('defectToRemark'); ?>?status=4">
                <?php echo __('manageit.defect_remark'); ?>
            </a>
        </li>
        <?php  }  ?>
            <li <?php echo $active == 'tcs' ? 'class="active"' : ''; ?>>
            <a href="<?php echo Project::current()->to('create_test_case'); ?>?status=5">
                <?php echo __('manageit.test_case'); ?>
            </a>
        </li>

	</ul>

	<div class="inside-tabs">
		<?php echo $page; ?>
	</div>


</div>