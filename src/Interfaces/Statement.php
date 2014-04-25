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
    }
}