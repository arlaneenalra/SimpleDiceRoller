<?php
include "lexer.class";


function build_rules() {
    static $rules=array(
                        
                        );
    return $rules;
}


// Actually accomplish a dice roll
function do_roll($string) {
    // nuke whitespace to make the lexer simpler
    $string = preg_replace("/\s/","", $string);

    // construct a new lexer object 
    $lexer = new Lexer(str_split($string),array());

    return '';;
}
