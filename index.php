<?php
include 'lib/template.class';


$template = new Template('tmpl/index.tmpl');

$template->title = 'Hello Nurse!';

$template->render();