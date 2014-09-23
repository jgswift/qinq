<?php
namespace qinq\Query {
    use qtil;
    use qinq;
    
    abstract class Statement implements \qinq\Interfaces\Statement {
        use qtil\Executable;
        
        /**
         * Statement query
         * @var \qinq\Interfaces\Query 
         */
        protected $query;
        
        /**
         * Arguments passed to statement during linking
         * @var array
         */
        protected $arguments = [];
        
        /**
         * Whether or not specific statement mutates collection
         * @var boolean 
         */
        protected $mutable = true;
        
        /**
         * Default constructor for query statements
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
        public function setQuery(qinq\Interfaces\Query $query) {
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
         * @param \qinq\Interfaces\Collection $collection
         * @return \qinq\Interfaces\Collection
         */
        function setCollection(qinq\Interfaces\Collection $collection) {
            return $this->query->setCollection($collection);
        }
        
        /**
         * Check if statement does mutate collection
         * @return boolean
         */
        function getMutable() {
            return $this->mutable;
        }
        
        /**
         * Update whether statement mutates collection
         * @param bool $bool
         * @return bool
         */
        function setMutable($bool) {
            return $this->mutable = (bool)$bool;
        }
    }
}
