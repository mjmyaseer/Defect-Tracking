<div class="blue-box">
    <div class="inside-pad">

        <?php if (!$rca): ?>
            <p><?php echo __('manageit.no_issues'); ?></p>
        <?php else: ?>

            <table class="form" style="height: 100%;">
                <th style="width: 10%"><?php echo __('No'); ?></th>
                <th style="width: 10%"><?php echo __('Issue ID'); ?></th>
                <th style="width: 10%"><?php echo __('manageit.title'); ?></th>
                <th style="width: 20%"><?php echo __('manageit.root_cause'); ?></th>
                <th style="width: 10%"><?php echo __('manageit.cycles'); ?></th>

                <?php $i = 1;  foreach ($rca as $row): ?>
                    <tr>
                        <td>
                           <p><?php echo $i++ ; ?></p>
                        </td>

                        <td>
                           <p><?php echo $row->issue_id ; ?></p>
                        </td>

                        <td>
                            <p><?php echo $row->title ; ?></p>
                        </td>

                        <td>
                            <p><?php echo $row->root_cause ; ?></p>
                        </td>

                        <td>
                            <p><?php echo $row->cycles ; ?></p>
                        </td>
                    </tr>

                <?php endforeach; ?>
            </table
        <?php endif; ?>

    </div>
</div>