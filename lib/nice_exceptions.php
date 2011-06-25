<?php

// Takes a stack trace array and populates
// template components from it
function build_stack_trace($stack_trace) {
    static $fields = array ('file', 'line', 'function', 
                            'class');
    
    $trace_array=array();

    foreach ($stack_trace as $trace) {
        $template = new Template('tmpl/inc/stack_trace.tmpl');

        // copy elements
        foreach ($fields as $key) {
            $template->$key = $trace[$key];
        }
        
        $trace_array[] = $template;
    }
    
    return $trace_array;
}

function exception_handler($exception) {
    $template = new Template('tmpl/exception.tmpl');
    
    $template->title="Uncaught Exception!";

    $template->message = $exception->getMessage();
    $template->line = $exception->getLine();
    $template->file = $exception->getFile();

    $template->stack_trace = build_stack_trace($exception->getTrace());
    //$template->stack_trace = $exception->getTrace();

    $template->render();

}

set_exception_handler('exception_handler');