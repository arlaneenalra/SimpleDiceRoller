<?php
include "lexer.class";


function build_rules() {
    static $rules=array(
                        'EmptyToken',
                        'NumberToken',
                        'OpToken'
                        );
    return $rules;
}


// Actually accomplish a dice roll
function do_roll($string) {
    // nuke whitespace to make the lexer simpler
    $string = preg_replace("/\s/","", $string);

    // construct a new lexer object 
    $lexer = new Lexer(str_split($string),build_rules());
    
    

    return var_dump($lexer->get_token()) . var_dump($lexer->get_token());
}
