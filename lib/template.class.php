<?php

// A simple template engine

class Template {

    private $model;

    // layout to be used with this template
    private $layout_file;
    private $template_file;

    // 
    public function __construct($template_file, $layout_file='tmpl/default.layout') {
        $this->template_file = $template_file;
        $this->layout_file = $layout_file;
    }


    // Render the given template,
    // This is meant to be overloaded latter
    public function render() {
        require $this->layout_file;
    }

    // Render the actual body of this template
    private function render_template() {
        if(isset($this->template_file)) {
            require $this->template_file;
        } else {
            error_log('No template file give');
            die();
        }
    }


    // set all parameters in the internal model 
    // to those defined here
    public function set_all($model) {
        $this->model = array_merge($this->model, $model);
    }

    // return an encoded version of an entity
    public function __get($name) { 
        if(!isset($this->model[$name])) {
            return '';
        }

        $model = $this->model[$name];

        // This is a hack that should be replaced
        if(is_string($model)) {
            return htmlentities($model);
        }


        return $model;
    }

    // Check to see if the given value is set
    public function __isset($name) {
        return isset($this->model[$name]);
    }

    // set a value on the model
    public function __set($name, $value) {
        $this->model[$name] = $value;
    }
}
