<?php

abstract class ResultBase {

    // calculate and return the result for this node
    abstract public function evaluate_node();

    // return a string value for the represented node;
    abstract public function to_string();
}


class TermBase extends ResultBase {
    
}

// Contains a simple number value
class NumberTerm extends TermBase {
    private $number;

    public function __construct($number) {
        $this->number = $number;
    }

    public function evaluate_node() {
        return $number;
    }
    
    public function to_string() {
        return "$number";
    }
}

class RollTerm extends TermBase {
    private $number;
    private $sides;
    private $rolls;

    public function __construct($number, $sides) {
        $this->number = $number;
    }

    public function evaluate_node () {
        $result=0;

        $this->rolls = array();

        while($number > 0) {
            $result += rand(1, $sides);
            $this->rolls[] = $result;
            $number--;
        }

        return $result;   
    }

    public function get_rolls() {
        return $this->rolls;
    }

    public function to_string() {
        return $number . "d" . $sides;
    }
}