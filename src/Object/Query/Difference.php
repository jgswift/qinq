<?php
namespace qinq\Object\Query {
    use qinq;
    
    class Difference extends qinq\Object\Statement {
        /**
         * Compute difference between collection and given array
         * @return array
         */
        public function execute() {
            $collection = $this->getCollection();
            
            $arr = $collection->toArray();
            
            $args = $this->getArguments();
            
            if(!empty($args)) {
                $against = [];
                foreach($args as $arg) {
                    if($arg instanceof \qtil\Collection) {
                        $arg = $arg->toArray();
                    }
                    $against[] = $arg;
                }
                
                return call_user_func_array('array_diff', array_merge([$arr],$against));
            }
        }
    }
}