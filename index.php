<?php
include 'lib/template.class';

$model=array();

// simple selection mode selection logic
if(isset($_POST['formula'])) {
    //include 'lib/parser.php';
    //$result = do_roll($_POST['formula']);
    $model['formula'] = $_POST['formula'];
}

$template = new Template('tmpl/index.tmpl');
$template->title = 'Simple Roller';

$template->set_all($model);

$template->render();
