<?php
namespace qinq {
    use qinq;
    use qtil;
    use kfiltr;
    
    abstract class Query implements Interfaces\Query {
        use qtil\Chain, kfiltr\Hook, kfiltr\Filter {
            qtil\Chain::link as _link;
        }
        
        /**
         * Source collection
         * @var \qinq\Interfaces\Collection 
         */
        protected $collection;
        
        /**
         * Default constructor for query
         * @param qinq\Interfaces\Collection $collection
         */
        public function __construct(qinq\Interfaces\Collection $collection = null) {
            if(is_null($collection)) {
                $collection = new Collection;
            }
            
            $this->collection = $collection;
        }
        
        /**
         * Retrieves query collection
         * @return \qinq\Interfaces\Collection
         */
        public function getCollection() {
            return $this->collection;
        }
        
        /**
         * Updates query collection
         * @param qinq\Interfaces\Collection $collection
         * @return \qinq\Interfaces\Collection
         */
        public function setCollection(qinq\Interfaces\Collection $collection) {
            return $this->collection = $collection;
        }
        
        /**
         * Ensures query statement references query
         * @param string $name
         * @param array $arguments
         * @return \qinq\Interfaces\Statement
         */
        public function link($name, array $arguments) {
            $link = $this->_link($name,$arguments);
            
            if($link instanceof Interfaces\Statement) {
                $link->setQuery($this);
            }
            
            return $link;
        }
        
        /**
         * Helper method to get collection iterator
         * @return \Iterator
         */
        public function getIterator() {
            return $this->collection->getIterator();
        }
    }
}
