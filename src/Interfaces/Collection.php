<?php
namespace qinq\Interfaces {
    use qtil;
    
    /**
     * Expands qtil collection functionality
     */
    interface Collection extends qtil\Interfaces\Collection {
        
        /**
         * @return \qinq\Object\Query
         */
        function getQuery();
    }
}