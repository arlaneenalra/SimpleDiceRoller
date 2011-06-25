<?php
include 'lib/template.class';
include 'lib/nice_exceptions.php';

$model=array();

// simple selection mode selection logic
if(isset($_POST['formula'])) {
    $formula = $_POST['formula'];

    include 'lib/roller.php';

    $result = do_roll($formula);
        
    $model['formula'] = $formula;
    $model['result'] = $result;
}

// Turn off nicer exceptions
//restore_exception_handler();

$template = new Template('tmpl/index.tmpl');
$template->title = 'Simple Roller';

$template->set_all($model);

$template->render();
