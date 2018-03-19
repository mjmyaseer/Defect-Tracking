<div class="blue-box">
    <div class="inside-pad">

        <?php if (!$issues): ?>
            <p><?php echo __('manageit.no_issues'); ?></p>
        <?php else: ?>

            <table class="form" style="height: 100%;">
                <th style="width: 10%"><?php echo __('No'); ?></th>
                <th style="width: 10%"><?php echo __('manageit.name'); ?></th>
                <th style="width: 10%"><?php echo __('Project Name'); ?></th>
                <th style="width: 10%"><?php echo __('QA Remark Ratio'); ?></th>

                <?php $i = 1;  foreach ($issues['positive_remarks'] as $row): ?>
                    <tr>
                        <td>
                            <p><?php echo $i++ ; ?></p>
                        </td>

                        <td>
                            <p><?php echo $row->firstname.' '. $row->lastname ; ?></p>
                        </td>

                        <td>
                            <p><?php echo $row->name; ?></p>
                        </td>

                        <td>
                            <p><?php echo 100- round($row->count /$row->total_issues * 100).'%' ; ?></p>
                        </td>

                    </tr>

                <?php endforeach; ?>
            </table
        <?php endif; ?>

    </div>
</div>