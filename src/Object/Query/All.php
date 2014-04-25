<?php
namespace qinq\Object\Query {
    class All extends Map {
        /**
         * Checks if all array values match given arguments
         * @return boolean
         */
        public function execute() {
            $arr = parent::execute();
            
            $args = $this->getArguments();
            
            foreach($args as $arg) {
                foreach($arr as $value) {
                    if($value !== $arg) {
                        return false;
                    }
                }
            }
            
            return true;
        }
    }
}