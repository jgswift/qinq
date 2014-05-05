<?php
namespace qinq\Object\Query {
    use qinq;
    
    class Intersect extends qinq\Object\Statement {
        /**
         * Compute intersection between collection and given arguments
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
                
                return call_user_func_array('array_intersect', array_merge([$arr],$against));
            }
        }
    }
}