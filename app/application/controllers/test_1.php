<?php
/**
 * Created by PhpStorm.
 * User: yaseer
 * Date: 9/21/2017
 * Time: 12:17 AM
 */

class Test_1_Controller extends Base_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->filter('before', 'project');
    }

    public function get_approval()
    {
        echo'ssss';exit();
        return $this->layout->nest('content', 'project.issue.approval', array(
            'issue' => Project\Issue::load_approval(),
            'project' => Project::current()
        ));
    }
}