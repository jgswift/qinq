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
                if(!in_array($arg,$arr)) {
                    return false;
                }
            }
            
            return true;
        }
    }
}
