<?php
/**
 * Created by PhpStorm.
 * User: yaseer
 * Date: 10/9/2017
 * Time: 7:34 PM
 */

class TestCase extends Eloquent
{
    public static $table = 'test_cases';
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

    public static function test_cases()
    {
//       dd(TestCase::all());
       return TestCase::all();
    }
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

    public static function create_test_case($input)
    {
        $rules = array(
            'testcase' => 'required|max:250',
            'steps' => 'required|max:250'
        );

        $validator = \Validator::make($input, $rules);

        if($validator->fails())
        {
            return array(
                'success' => false,
                'errors' => $validator->errors
            );
        }

        $fill = array(
            'test_case' => $input['testcase'],
            'project_id' => $input['project_id'],
            'recreate_steps' => $input['steps'],
            'created_by' => \Auth::user()->id
        );

        $testCase = new TestCase();
        $testCase->fill($fill);
        $testCase->save();

        return array(
            'success' => true
        );
    }


    public static function execute_test_case($id)
    {
//        dd($id);
        $rules = array(
            'testcase_id' => 'required',
        );

        $validator = \Validator::make($id, $rules);

        if($validator->fails())
        {
            return array(
                'success' => false,
                'errors' => $validator->errors
            );
        }

        $update = array(
            'status' => 1,
        );

        /* Update the password */
        TestCase::find($id['testcase_id'])->fill($update)->save();

        return array(
            'success' => true,
        );
    }
}