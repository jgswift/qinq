<?php
namespace qinq\Query {
    use qinq;
    use qtil;
    
    class Mutable extends qinq\Query {
        /**
         * Query execution
         * source collection will be updated with results
         * @return mixed
         */
        function execute() {
            $links = $this->getLinks();
            
            $result = null;
            foreach($links as $link) {
                if($link instanceof qinq\Query\Statement) {
                    $result = $this->statement($link);
                }
            }
            
            if(!is_null($result)) {
                return $result;
            }
            
            return $this->collection;
        }
        
        /**
         * Statement execution
         * @param callable $statement
         * @return \qinq\Query\Statement|\qinq\Collection|null
         */
        protected function statement(qinq\Query\Statement $statement) {
            $result = null;
            
            $l = call_user_func_array($statement,func_get_args());
            if($l instanceof Statement) {
                $result = $l;
            } elseif(qtil\ArrayUtil::isIterable($l)) {
                if($statement->getMutable() === false) {
                    return new qinq\Collection($l);
                } else {
                    $this->collection->from($l);
                }
            } elseif(!is_null($l)) {
                $result = $l;
            }
            
            return $result;
        }
    }
}
