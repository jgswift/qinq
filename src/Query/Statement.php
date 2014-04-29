<?php
namespace qinq\Query {
    use qtil;
    
    abstract class Statement implements \qinq\Interfaces\Statement {
        use qtil\Executable;
        
        /**
         * Statement query
         * @var \qinq\Interfaces\Query 
         */
        private $query;
        
        /**
         * Arguments passed to statement during linking
         * @var array
         */
        private $arguments = [];
        
        /**
         * Default constructor for query statements
         * TODO: Update to variadic 5.6
         * @param array $args
         */
        function __construct($args = []) {
            $this->arguments = $args;
        }
        
        /**
         * Retrieve statement arguments
         * @return array
         */
        function getArguments() {
            return $this->arguments;
        }
        
        /**
         * Retrieve statement query
         * @return \qinq\Interfaces\Query
         */
        public function getQuery() {
            return $this->query;
        }

        /**
         * Update statement query
         * @param \qinq\Interfaces\Query $query
         * @return \qinq\Interfaces\Query
         */
        public function setQuery(\qinq\Interfaces\Query $query) {
            return $this->query = $query;
        }
        
        /**
         * Retrieve statement collection
         * @return \qinq\Interfaces\Collection
         */
        function getCollection() {
            return $this->query->getCollection();
        }
        
        /**
         * Update statement collection
         * @param \qinq\Query\qinq\Interfaces\Collection $collection
         * @return \qinq\Query\qinq\Interfaces\Collection
         */
        function setCollection(qinq\Interfaces\Collection $collection) {
            return $this->query->setCollection($collection);
        }
    }
}