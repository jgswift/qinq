<?php
namespace qinq\Object\Query {
    use qinq;
    use qtil;
    
    class From extends qinq\Object\Statement {
        /**
         * Populate collection with array given
         * @return array
         */
        public function execute() {
            $arr = $this->getCollection()->toArray();
            
            $fn = $this->getCallback();
            
            $args = $this->getArguments();
            
            $numArgs = count($args);
            if($numArgs === 1) {
                if(is_array($args[0])) {
                    return $args[0];
                } elseif($args[0] instanceof \Iterator) {
                    return iterator_to_array($args[0]);
                } elseif($args[0] instanceof qtil\Interfaces\Traversable) {
                    return $args[0]->toArray();
                }
            } else {
                return $args;
            }
            
            return $arr;
        }
    }
}