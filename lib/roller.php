<?php
include "lexer.class";
include "rules.class";


function build_rules() {
    static $rules;
    if(!isset($rules)) {
        $rules[] = new NumberRule();
        $rules[] = new DOpRule();
        $rules[] = new PlusOpRule();
        $rules[] = new MinusOpRule();
        $rules[] = new EOFRule();
    }

    return $rules;
}


// Actually accomplish a dice roll
function do_roll($string) {
    // nuke whitespace to make the lexer simpler
    $string = preg_replace("/\s/","", $string);
    $string = strtoupper($string);

    // construct a new lexer object 
    $lexer = new Lexer(str_split($string),build_rules());
    
    $result_list=array();
    
    while($lexer->has_more_tokens()) {
        $token = $lexer->get_token();
        $result_list[] = $token;
    }

    return var_export($result_list, true);
}
