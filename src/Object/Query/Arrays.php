<?php
namespace qinq\Object\Query {
    use qinq;
    use restructr;
    
    class Arrays extends qinq\Object\Statement {
        
        /**
         * The short name of the function
         * ie. array_merge becomes 'merge'
         * array_intersect becomes 'intersect'
         * etc.
         * @var string 
         */
        protected $utilFunctionName;
        
        public function getFunctionName() {
            return $this->utilFunctionName;
        }
        
        /**
         * Perform built-in php array function using qtil\ArrayUtil::__callStatic
         * @return array
         */
        public function execute() {
            $collection = $this->getCollection();
            
            $arr = $collection->toArray();
            
            $args = $this->getArguments();
            
            if(!empty($args)) {
                $against = [];
                foreach($args as $arg) {
                    if($arg instanceof restructr\Interfaces\Enumerable) {
                        $arg = $arg->toArray();
                    } elseif($arg instanceof \Iterator) {
                        $arg = iterator_to_array($arg);
                    } elseif($arg instanceof \Traversable) {
                        $arg = (array)$arg;
                    }
                    
                    $against[] = $arg;
                }
                
                return call_user_func_array('qtil\ArrayUtil::'.$this->utilFunctionName, array_merge([$arr],$against));
            }
        }
    }
}
