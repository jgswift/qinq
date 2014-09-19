<?php
namespace qinq\Interfaces {
    interface Statement {
        
        /**
         * @return \qinq\Interfaces\Query
         */
        function getQuery();
        
        /**
         * @param \qinq\Interfaces\Query
         * @return \qinq\Interfaces\Query
         */
        function setQuery(Query $query);
        
        /**
         * Check if statement mutates collection 
         */
        function getMutable();
        
        /**
         * Tell statement to mutate collection
         */
        function setMutable($bool);
    }
}