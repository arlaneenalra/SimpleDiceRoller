<?php
require "lexer.class.php";
require "rules.class.php";
require "parser.class.php";


// Setup the list of rules used by the lexer class
function build_rules() {
    static $rules;
    if(!isset($rules)) {
        $rules[] = new WhiteSpaceRule();
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
    $string = strtoupper($string);

    // make sure there is actually something to 
    // split
    if(strlen($string) > 0) {
        return str_split($string);
    }

    return array();
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

    return $result_list;
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