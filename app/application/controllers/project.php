<?php

class Project_Controller extends Base_Controller
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

        return $this->layout->nest('content', 'project.index', array(
            'page' => View::make('project/index/activity', array(
                'project' => Project::current(),
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

    /**
     * Display issues for a project
     * /project/(:num)
     *
     * @return View
     */
    public function get_issues()
    {
        $status = Input::get('status', 1);
//dd($status);

        if ($status == 1) {
            $active = 'open';
        } elseif ($status == 0) {
            $active = 'closed';
        } elseif ($status == 3) {
            $active = 'remark';
        }elseif ($status == 4) {
            $active = 'drr';
        }elseif ($status == 5) {
            $active = 'tcs';
        }

        return $this->layout->nest('content', 'project.index', array(
            'page' => View::make('project/index/issues', array(
                'issues' => Project::current()->issues()
                    ->where('status', '=', $status)
                    ->order_by('updated_at', 'DESC')
                    ->get(),
            )),
            'active' => $active,
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

    //

    /**
     * Display issues assigned to current user for a project
     * /project/(:num)
     * @return mixed
     */
    public function get_remarks()
    {
        $status = Input::get('status', 1);

        $project = Project::current();
        $project_id = $project->attributes['id'];

        $issue = approval::remark_calculate($project_id);
        $rca = approval::rca_calculate($project_id);
//dd($issue);
        return $this->layout->nest('content', 'project.index', array(
            'page' => View::make('project/index/remarks', array(
                'issues' => $issue,
                'rca' => $rca,
            )),
            'active' => 'remark',
            'open_count' => Project::current()->issues()
                ->where('status', '=', 1)
                ->count(),
            'closed_count' => Project::current()->issues()
                ->where('status', '=', 0)
                ->count(),
            'assigned_count' => Project::current()->count_assigned_issues()
        ));
    }

    public function get_defectToRemark()
    {
        $status = Input::get('status', 1);

        $project = Project::current();
        $project_id = $project->attributes['id'];

        $issue = approval::remark_calculate($project_id);
//dd($issue);
        return $this->layout->nest('content', 'project.index', array(
            'page' => View::make('project/index/defectToRemark', array(
                'issues' => $issue
            )),
            'active' => 'drr',
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

    public function get_create_test_case_form()
    {
        return $this->layout->nest('content', 'project.index', array(
            'page' => View::make('project/index/create_test_case', array(
                'project' => Project::current(),
                'testcases' => TestCase::test_cases()
            )),
            'active' => 'tcs',
            'open_count' => Project::current()->issues()
                ->where('status', '=', 1)
                ->count(),
            'closed_count' => Project::current()->issues()
                ->where('status', '=', 0)
                ->count(),
            'assigned_count' => Project::current()->count_assigned_issues()
        ));
    }

    public function get_create_test_case()
    {
        return $this->layout->nest('content', 'project.index', array(
            'page' => View::make('project/index/list_test_cases', array(
                'project' => Project::current(),
            'testcases' => TestCase::test_cases()
            )),
            'active' => 'tcs',
            'open_count' => Project::current()->issues()
                ->where('status', '=', 1)
                ->count(),
            'closed_count' => Project::current()->issues()
                ->where('status', '=', 0)
                ->count(),
            'assigned_count' => Project::current()->count_assigned_issues()
        ));
    }

    public function post_create_test_case_form()
    {
        /* Create Test Case */
        $insert = TestCase::create_test_case(Input::all());

        if ($insert['success']) {
            return $this->layout->nest('content', 'project.index', array(
                'page' => View::make('project/index/list_test_cases', array(
                    'project' => Project::current(),
                    'testcases' => TestCase::test_cases()
                )),
                'active' => 'tcs',
                'open_count' => Project::current()->issues()
                    ->where('status', '=', 1)
                    ->count(),
                'closed_count' => Project::current()->issues()
                    ->where('status', '=', 0)
                    ->count(),
                'assigned_count' => Project::current()->count_assigned_issues()
            ));
        }

        return Redirect::to(Project::current()->to('edit'))
            ->with_errors($insert['errors'])
            ->with('notice-error', __('manageit.we_have_some_errors'));
    }

    public function post_execute()
    {
        $update = TestCase::execute_test_case(Input::all());

        if ($update['success']) {
            return $this->layout->nest('content', 'project.index', array(
                'page' => View::make('project/index/create_test_case', array(
                    'project' => Project::current(),
                    'testcases' => TestCase::test_cases()
                )),
                'active' => 'tcs',
                'open_count' => Project::current()->issues()
                    ->where('status', '=', 1)
                    ->count(),
                'closed_count' => Project::current()->issues()
                    ->where('status', '=', 0)
                    ->count(),
                'assigned_count' => Project::current()->count_assigned_issues()
            ));
        }

        return Redirect::to(Project::current()->to('create_test_case'))
            ->with_errors($update['errors'])
            ->with('notice-error', __('manageit.we_have_some_errors'));
    }
}