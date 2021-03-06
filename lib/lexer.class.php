<?php
require "tokens.class.php";


// Lexical exception 
class LexerException extends Exception {
}

// A very crude lexer.  Some work with regular 
// expressions could abstract this nicely.
class Lexer {
    private $stream;
    private $rules;

    private $token;

    // Construct a new lexer that points
    // at the given stream.  Lexer's are 
    // stateful!
    // Requires:
    // stream - an array of characters to lex
    // rules - an array of lambdas that can match tokens
    public function __construct($stream, $rules) {
        $this->stream = $stream;
        $this->rules = $rules;
    }

    // return the next token in the stream
    public function get_token() {

        // if we don't have a token, load one
        if(!isset($this->token)) {
            $this->peek();
        }
        
        // Clear saved token
        $token = $this->token;
        unset($this->token);

        // remove the matched token from our 
        // stream
        $this->stream = array_slice($this->stream, 
                                    $token->length);
        return $token;
    }

    // Look at the next token without
    // throwing it away
    public function peek() { 
        // don't parse the token again, 
        // if we already have it.
        if(isset($this->token)) {
            return $this->token;
        }

        // evaluate all match rules in order
        // to find a token
        $matched_token = null;
        foreach ($this->rules as $rule) {
            $matched_token = $rule->match($this->stream);
            
            if(isset($matched_token)) {
                $this->token = $matched_token;
                break;
            }
        }

        // did we find a token?
        if(isset($matched_token)) {

            // should this token be ignored
            if($matched_token->ignore()) {
                // drop the token and peek again
                $this->get_token();
                return $this->peek();
            }

            // return the token we found.
            return $matched_token;
        }

        // none of the rules matched,
        // something is wrong
        throw new LexerException("Unable to parse dice expression: " .
                                 var_export($this->stream, 1));
    }

    // does the lexer have another token?
    public function is_eof() {
        $token = $this->peek();
        return $token->is_eof();
    }

    // Are we in an error state?
    // TODO: This may come in handy latter
    public function has_error() {
        $token = $this->peek();
        return is_null($token);
    }

    public function has_more_tokens() {
        return !$this->has_error() and !$this->is_eof();
    }
}