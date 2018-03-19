<h3>
    <?php echo __('manageit.test_case'); ?>
    <span><?php echo __('manageit.create_a_new_test_in'); ?> <a href="<?php echo $project->to(); ?>"><?php echo $project->name; ?></a></span>
</h3>

<div class="pad">

    <form method="post" action="">

        <table class="form" style="width: 100%;">
            <tr>
                <th style="width: 10%"><?php echo __('manageit.test_case') ?></th>
                <td>
                    <input type="text" name="testcase" style="width: 98%;" />

                    <?php echo $errors->first('title', '<span class="error">:message</span>'); ?>
                </td>
            </tr>
            <tr>
                <th><?php echo __('manageit.steps_to_recreate'); ?></th>
                <td>
                    <textarea name="steps" style="width: 98%; height: 150px;"></textarea>
                    <?php echo $errors->first('body', '<span class="error">:message</span>'); ?>
                </td>
            </tr>

            <tr>
                <th></th>
                <td><input type="submit" value="<?php echo __('manageit.create_test_case'); ?>" class="button primary" /></td>
            </tr>
        </table>

        <?php echo Form::hidden('session', Crypter::encrypt(Auth::user()->id)); ?>
        <?php echo Form::hidden('project_id', Project::current()->id); ?>
        <?php echo Form::hidden('token', md5(Project::current()->id . time() . \Auth::user()->id . rand(1, 100))); ?>
        <?php echo Form::token(); ?>

    </form>

</div>