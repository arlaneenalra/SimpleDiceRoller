<?php

// Base class for tokens/rules
abstract class TokenBase {
   public $value;
   public $length;

   // handle the various is_* methods
   // there is probably a better way to do this 
   public function __call($name, $args) {
       static $valid=array('is_eof', 'is_number',
                           'is_d', 'is_plus',
                           'is_minus', 'ignore');
       if(in_array($name, $valid)) {
           return false;
       }
       throw new ErrorException("Attempt to call undefined method: $name");
   }

   public function to_string() {
       $string = get_class($this);
       $string .= ": Value: '" . $this->value;
       $string .= "' Length: " . $this->length;
       return $string;
   }
}

// Token representing white space, should 
// be ignored
class WhiteSpaceToken extends TokenBase {
    public function ignore() {
        return true;
    }
}

class DToken extends TokenBase {
    public function is_d() {
        return true;
    }
}

class PlusToken extends TokenBase {
    public function is_plus() {
        return true;
    }
}

class MinusToken extends TokenBase {
    public function is_minus() {
        return true;
    }
}

class EOFToken extends TokenBase {
    public function is_eof() {
        return true;
    }
}

class NumberToken extends TokenBase {
    public function is_number() {
        return true;
    }
}







