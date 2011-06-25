<?php

// Base clase for rules
abstract class RuleBase {

    // Match function, either returns null
    // or a token instance that the rule 
    // matched
    abstract public function match($stream);

}

// Operator rule
abstract class OpRuleBase extends RuleBase {

    // Mathc a single character operator
    public function match($stream) {
        $token = null;

        if(isset($stream[0])) {
            $value = $stream[0];

            list($character, $class) = $this->character();

            // match list of valid operators
            if($value == $character) {
                
                $token = new $class();
                $token->value = $value;
                $token->length = 1;
            }
        }
        
        return $token;
    }

    abstract protected function character();
}

class DOpRule extends OpRuleBase {
    protected function character() {
        return array('D', 'DToken');
    }
}

class PlusOpRule extends OpRuleBase {
    protected function character() {
        return array('+', 'PlusToken');
    }
}

class MinusOpRule extends OpRuleBase {
    protected function character() {
        return array('-', 'MinusToken');
    }
}

// The empty token
class EOFRule extends RuleBase {

    // Match the empty stream
    public function match($stream) { 
        if(count($stream) == 0 ) {
            return new EOFToken();
        }
        return null;
    }
}

// Used to strip whitespace.
class WhiteSpaceRule extends RuleBase {
    
    // Handles only spaces for the moment
    public function match($stream) {
        $string = '';
        $length = 0;

        $token = null;

        foreach ($stream as $val ) {
            if(strcmp($val, ' ') == 0) {
                $string .= $val;
                $length++;
            } else {
                break;
            }
        }

        if($length > 0) {
            $token = new WhiteSpaceToken();
            $token->length = $length;
            $token->value = $string;
        }

        return $token;
    }
}

// Number token
class NumberRule extends RuleBase {
    

    public function match($stream) {
        $token = null;

        foreach ($stream as $val) {
            // do we have a digit?
            if(is_numeric($val)) {
                // check for an existing token
                if(!isset($token)) {
                    $token = new NumberToken;
                }
                
                $token->value .= $val;
                $token->length++;
            } else {
                // Character does not match
                // exit loop
                break;
            }
        }

        return $token;
    }
}
