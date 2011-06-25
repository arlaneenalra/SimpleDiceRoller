<?php
include "lexer.class";
include "rules.class";
include "parser.class";


// Setup the list of rules used by the lexer class
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

// Convert our request string into something
// more managable
function normalize_string($string) {
    // nuke whitespace to make the lexer simpler
    $string = preg_replace("/\s/","", $string);
    $string = strtoupper($string);

    return str_split($string);
}


// Actually accomplish a dice roll
function do_roll($string) {
    
    $character_list = normalize_string($string);

    // construct a new lexer object 
    $lexer = new Lexer($character_list, build_rules());
    $parser = new Parser();
    
    $result_list=array();
    
    while($lexer->has_more_tokens()) {
        // $token = $lexer->get_token();
        
        $result_list[] = $parser->parse_expression($lexer);
    }

    return var_export($result_list, true);
}



/* Dice Language, crudely

term:
   NUMBER
   | NUMBER
     D
     NUMBER

operator:
   PLUS
   | MINUS

expression:
   term
   | expression
     operator
     term

 */