<?php

class Approval_Controller extends Base_Controller
{

    public $layout = 'layouts.project';

    public function __construct()
    {
        parent::__construct();

        $this->filter('before', 'project');
        $this->filter('before', 'permission:project-modify')->only('edit');
    }

    /**
     * Display activity for a project
     * /project/(:num)
     *
     * @return View
     */
    public function get_index()
    {
//	    dd(Project::approval());
        return $this->layout->nest('content', 'project.index', array(
            'page' => View::make('project/index/approval', array(
                'project' => Project::approval(),
                'activity' => Project::current()->activity(10)
            )),
            'active' => 'activity',
            'open_count' => Project::current()->issues()
                ->where('status', '=', 1)
                ->count(),
            'closed_count' => Project::current()->issues()
                ->where('status', '=', 0)
                ->count(),
            'assigned_count' => Project::current()->count_assigned_issues()
        ));
    }

    public function post_index()
    {
        $data = Input::all();
        $issue = "";

        if (isset($data['approve'])) {
            $issue = approval::approve_issue($data);
        } elseif (isset($data['reject'])) {
            $issue = approval::reject_issue($data);
        }


        if (!$issue['success']) {
            return Redirect::to(Project::current()->to('approval'))
                ->with_input()
                ->with_errors($issue['errors'])
                ->with('notice-error', __('manageit.we_have_some_errors'));
        }

        if($issue['approval'] != 1){
        return Redirect::to('')
            ->with('notice', __('manageit.issue_has_been_approved'));
        }else{
            return Redirect::to('')
            ->with('notice', __('manageit.issue_has_been_rejected'));
        }
    }

    /**
     * Display issues for a project
     * /project/(:num)
     *
     * @return View
     */
    public function get_issues()
    {
        $status = Input::get('status', 1);

        return $this->layout->nest('content', 'project.index', array(
            'page' => View::make('project/index/issues', array(
                'issues' => Project::current()->issues()
                    ->where('status', '=', $status)
                    ->order_by('updated_at', 'DESC')
                    ->get(),
            )),
            'active' => $status == 1 ? 'open' : 'closed',
            'open_count' => Project::current()->issues()
                ->where('status', '=', 1)
                ->count(),
            'closed_count' => Project::current()->issues()
                ->where('status', '=', 0)
                ->count(),
            'assigned_count' => Project::current()->count_assigned_issues()
        ));
    }

    /**
     * Display issues assigned to current user for a project
     * /project/(:num)
     *
     * @return View
     */
    public function get_assigned()
    {
        $status = Input::get('status', 1);

        return $this->layout->nest('content', 'project.index', array(
            'page' => View::make('project/index/issues', array(
                'issues' => Project::current()->issues()
                    ->where('status', '=', $status)
                    ->where('assigned_to', '=', Auth::user()->id)
                    ->order_by('updated_at', 'DESC')
                    ->get(),
            )),
            'active' => 'assigned',
            'open_count' => Project::current()->issues()
                ->where('status', '=', 1)
                ->count(),
            'closed_count' => Project::current()->issues()
                ->where('status', '=', 0)
                ->count(),
            'assigned_count' => Project::current()->count_assigned_issues()
        ));
    }

    /**
     * Edit the project
     * /project/(:num)/edit
     *
     * @return View
     */
    public function get_edit()
    {
        return $this->layout->nest('content', 'project.edit', array(
            'project' => Project::current()
        ));
    }

    public function post_edit()
    {
        /* Delete the project */
        if (Input::get('delete')) {
            Project::delete_project(Project::current());

            return Redirect::to('projects')
                ->with('notice', __('manageit.project_has_been_deleted'));
        }

        /* Update the project */
        $update = Project::update_project(Input::all(), Project::current());

        if ($update['success']) {
            return Redirect::to(Project::current()->to('edit'))
                ->with('notice', __('manageit.project_has_been_updated'));
        }

        return Redirect::to(Project::current()->to('edit'))
            ->with_errors($update['errors'])
            ->with('notice-error', __('manageit.we_have_some_errors'));
    }
}