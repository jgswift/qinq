<?php
namespace qinq\Object\Query {
    class Any extends Map {
        /**
         * Checks if any array value matches given arguments
         * @return boolean
         */
        public function execute() {
            $arr = parent::execute();
            
            $args = $this->getArguments();

            foreach($args as $arg) {
                foreach($arr as $value) {
                    if($value == $arg) {
                        return true;
                    }
                }
            }
            
            return false;
        }
    }
}
