<?php

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

// Class for syntax exceptions 
class SyntaxException extends Exception {
    public $token;

    public function __construct($message, $token) {
        $message = "Syntax Error: '$message' Token Was: ";
        $message .= $token->to_string();

        parent::__construct($message);
        $this->token = $token;
    }
}


// There is probably a better way to do this
class Parser {

    // Parse and consume a number
    protected function parse_number($lexer) {
        $token = $lexer->get_token();
        
        // make sure we have number
        if(!$token->is_number()) {
            throw new SyntaxException("Expected a Number", $token);
        }
        return $token;
    }

    // Parse and consume a single number
    // or a roll
    protected function parse_term($lexer) {
        $number = $this->parse_number($lexer);

        // Do we have a NdS term?
        if($lexer->peek()->is_d()) {
            $lexer->get_token(); // consume the D

            $sides = $this->parse_number($lexer);
            
            // We should be building a tree here not
            // doing the actual roll
            $result = $this->roll_dice($number->value, $sides->value);
        } else {
            $result = $number->value;
        }
        
        return $result;
    }

    // top level entry point for the parser
    public function parse_expression($lexer) {
        $term = $this->parse_term($lexer);

        $token = $lexer->peek();

        // Are we at the end of the stream?
        if($token->is_eof()) {
            return $term;
        }

        // Handle a + modifier
        if($token->is_plus()) {
            $lexer->get_token();

            $result = $term + $this->parse_expression($lexer);
            return $result;
        }

        // Handle a - modifier
        if($token->is_minus()) {
            $lexer->get_token();

            $result = $term - $this->parse_expression($lexer);
            return $result;
        }

        throw new SyntaxException("Expected Operator", $token);
       
    }


    // This should probably be moved elseswhere
    protected function roll_dice($number, $sides) {
        $result=0;

        while($number > 0) {
            $result += rand(1, $sides);
            $number--;
        }

        return $result;
    }
}
