<?php
/**
 * Created by PhpStorm.
 * User: yaseer
 * Date: 9/23/2017
 * Time: 12:08 PM
 */

class approval extends Eloquent
{
    public static $table = 'issue_approvals';
    public static $timestamps = false;

    public function user()
    {
        return $this->belongs_to('\User', 'created_by');
    }

    /**
     * @return User
     */
    public function assigned()
    {
        return $this->belongs_to('\User', 'assigned_to');
    }

    /**
     * @return User
     */
    public function updated()
    {
        return $this->belongs_to('\User', 'updated_by');
    }

    /**
     * @return User
     */
    public function closer()
    {
        return $this->belongs_to('\User', 'closed_by');
    }

    /**
     * Current loaded Issue
     *
     * @var Issue
     */
    private static $current = null;

    /**
     * Return the current loaded Issue
     *
     * @return Issue
     */
    public static function current()
    {
        return static::$current;
    }

    /**
     * Load a new Issue into $current, based on the $id
     *
     * @param   int $id
     * @return  Issue
     */
    public static function load_issue($id)
    {
        static::$current = static::find($id);

        return static::$current;
    }

    public static function approve_issue($status)
    {
//        echo 'sssss';exit();
//dd($status);
        $project_id = \DB::table('issue_approvals')
            ->Join('projects_issues', 'projects_issues.project_id', '=', 'issue_approvals.project_id')
            ->where('projects_issues.id', '=', $status['approval_issue'])
            ->get();

//dd($project_id);
        $approval = new approval;
        $approval->approved_by = \Auth::user()->id;
        $approval->project_id = Project::current()->id;
        $approval->issue_id = $status['approval_issue'];
        $approval->root_cause = $status['body'];
        $approval->approved_at = date('Y-m-d H:i:s');
        $approval->status = 0;
        $approval->save();
//
        /* Add to activity log */
        \User\Activity::add(3, Project::current()->id, Project::current()->id);

        /* Settings are valid */
        $update = array(
            'status' => 3,
        );

        /* Update the password */
        \Project\Issue::find($status['approval_issue'])->fill($update)->save();

        return array(
            'success' => true,
            'approval' => 2
        );
    }

    public static function reject_issue($status)
    {
        $project_id = \DB::table('issue_approvals')
            ->Join('projects_issues', 'projects_issues.project_id', '=', 'issue_approvals.project_id')
            ->where('projects_issues.id', '=', $status['approval_issue'])
            ->get();

        $approval = new approval;
        $approval->approved_by = \Auth::user()->id;
        $approval->project_id = Project::current()->id;
        $approval->approved_at = date('Y-m-d H:i:s');
        $approval->issue_id = $status['approval_issue'];
        $approval->status = 1;
        $approval->assigned_to = 1;
        $approval->save();

        /* Add to activity log */
        \User\Activity::add(4, Project::current()->id, Project::current()->id);


        /* Settings are valid */
        $update = array(
            'status' => 4,
            'closed_by' => \Auth::user()->id,
        );

        /* Update the password */

        \Project\Issue::find($status['approval_issue'])->fill($update)->save();

        return array(
            'success' => true,
            'approval' => 1
        );
    }

    public static function remark_calculate($project_id)
    {
// give out the count of the qa and the rejected issues
        $negative_remarks = DB::query('select projects_issues.id,count(projects_issues.created_by) as count,
                                        (select count(id) as td from projects_issues where project_id = '.$project_id.') as total_issues,
                                        projects_issues.title,users.firstname,users.lastname,projects_issues.created_by,
                                        projects_issues.closed_by,projects_issues.updated_by,
                                        projects_issues.assigned_to,projects_issues.project_id,projects_issues.status,
                                        projects_issues.title,projects_issues.body,projects_issues.cycles,projects.name
                                        from projects_issues
                                        left join users
                                        on projects_issues.created_by = users.id 
                                        left join projects
                                        on projects_issues.project_id = projects.id
                                        where projects_issues.status = 4
                                        and users.role_id = 3
                                        and project_id = '.$project_id.'
                                        group by projects_issues.created_by');

        $positive_remarks = DB::query('select projects_issues.id,count(projects_issues.created_by) as count,
                                        (select count(id) as td from projects_issues where project_id = '.$project_id.') as total_issues,
                                        projects_issues.title,users.firstname,users.lastname,projects_issues.created_by,
                                        projects_issues.closed_by,projects_issues.updated_by,
                                        projects_issues.assigned_to,projects_issues.project_id,projects_issues.status,
                                        projects_issues.title,projects_issues.body,projects_issues.cycles,projects.name
                                        from projects_issues
                                        left join users
                                        on projects_issues.created_by = users.id
                                        left join projects
                                        on projects_issues.project_id = projects.id
                                        where projects_issues.status = 3
                                        and users.role_id = 3
                                        and project_id = '.$project_id.'
                                        group by projects_issues.created_by');

        $result = array(
            'negative_remarks' => $negative_remarks,
            'positive_remarks' => $positive_remarks);
        return $result;
    }

    public static function rca_calculate($project_id)
    {
        $rca_calculation = DB::query('select issue_approvals . project_id,issue_approvals . issue_id,
                                        issue_approvals . root_cause,issue_approvals . assigned_to,
                                        projects_issues . title,projects_issues . body,cycles
                                        from issue_approvals 
                                        Join projects_issues 
                                        on projects_issues . id = issue_approvals . issue_id 
                                        JOIN projects                                       
                                        on issue_approvals . project_id = projects . id
                                        where issue_approvals . project_id = ' . $project_id . '');

//        dd($rca_calculation);
        return $rca_calculation;
    }
}

