<div class="blue-box">
    <?php  if (!$testcases): ?>
        <a style="margin-left: 80%;margin-top:2%;font-size: large; background-color:goldenrod;color: white; border: double"
           href="<?php echo URL::base()."/testcase/".Project::current()->id; ?>" class="newissue">+
            <?php echo __('manageit.create_test_case'); ?></a>
    <?php elseif (Auth::user()->role_id ==3 ): ?>
    <a style="margin-left: 85%;margin-top:2%;font-size: large; background-color:goldenrod;color: white; border: double"
       href="<?php echo URL::base()."/testcase/".Project::current()->id; ?>" class="newissue">+
        <?php echo __('manageit.create_test_case'); ?></a>
    <?php endif; ?>

    <div class="inside-pad">

        <?php  if (!$testcases): ?>
            <p><?php echo __('No Test Cases Written'); ?></p>
        <?php else: ?>

            <table class="form" style="height: 100%;">
                <th style="width: 10%;font-size: 15px"><?php echo __('No'); ?></th>
                <th style="width: 10%;font-size: 15px"><?php echo __('Project ID'); ?></th>
                <th style="width: 10%;font-size: 15px"><?php echo __('manageit.test_case'); ?></th>
                <th style="width: 10%;font-size: 15px"><?php echo __('Test Case Description'); ?></th>
                <th style="width: 10%;font-size: 15px"><?php echo __('Execution Status'); ?></th>

                <?php $i = 1;
                foreach ($testcases as $row): ?>
                    <tr>
                        <td>
                            <p><?php echo $i++; ?></p>
                        </td>

                        <td>
                            <p><?php echo $row->project_id; ?></p>
                        </td>

                        <td>
                            <p><?php echo $row->test_case; ?></p>
                        </td>

                        <td>
                            <p><?php echo $row->recreate_steps; ?></p>
                        </td>
                        <td>
                            <p><?php if($row->status == 1 ) {echo "Executed"; } elseif (Auth::user()->role_id !=3 && $row->status == 0 ){
                                    echo "Execution Pending"; } elseif ($row->status == 0 ){
                                    ?> <a href="javascript:void(0);" onclick="execute_test_case(<?php echo $row->id; ?>, <?php echo Project::current()->id; ?>);" class="delete">Execute</a> <?php
                                }?></p>
                        </td>

                    </tr>

                <?php endforeach; ?>
            </table
        <?php endif; ?>

    </div>
</div>