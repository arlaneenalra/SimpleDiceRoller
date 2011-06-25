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
    $string = strtoupper($string);

    // construct a new lexer object 
    $lexer = new Lexer(str_split($string),build_rules());
    
    $token_list=array();
    while(!$lexer->eof()) {
        error_log("hi");
        $token_list[]=$lexer->get_token();
    }

    return var_export($token_list, true);
}
