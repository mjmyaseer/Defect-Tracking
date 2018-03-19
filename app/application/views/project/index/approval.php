<h3>
    <?php echo __('manageit.approve_issue_text'); ?>
    <span><?php echo __('manageit.approve_pending');?></span>
</h3>

<div class="pad">

    <form method="post" action="" id="submit-project">
    <table class="form" style="width: 80%;">
        <tr>
            <th style="width: 10%;"><?php echo __('manageit.name');?></th>
            <td><select name="approval_issue">
                    <?php foreach($project as $row):  ?>
                        <option  value="<?php echo $row->id ; ?>"><?php echo $row->title ; ?></option>
                    <?php endforeach; ?>
                </select></td>
        </tr>

        <tr>
            <th><?php echo __('manageit.root_cause'); ?></th>
            <td>
                <textarea name="body" style="width: 98%; height: 150px;"></textarea>
                <?php echo $errors->first('body', '<span class="error">:message</span>'); ?>
            </td>
        </tr>

        <tr>
            <th></th>
            <td><input type="submit" name="approve" onclick="$('#submit-project').submit();" value="<?php echo __('manageit.approve_issue');?>"  />
                &nbsp;
                <input type="submit" name="reject" onclick="$('#submit-project').submit();" value="<?php echo __('manageit.reject_issue');?>"  />
            </td>
        </tr>
    </table>
    </form>

</div>