<?php
namespace qinq\Object {
    use qinq;
    
    abstract class Statement extends qinq\Query\Statement {
        
        /**
         * Stores first callable passed into constructor
         * All other callables are added to arguments
         * @var callable 
         */
        protected $callback;
        
        /**
         * Default constructor for object statements
         */
        function __construct() {
            $args = func_get_args();
            
            foreach($args as $k => $arg) {
                /* if an argument is provided that is a callback
                 * and the statement lacks a primary callback
                 * make the callback primary to the statement
                 * and remove it from the arguments
                 * this is for convenience as most statements
                 * will require a single callback
                 */
                if(is_callable($arg) && empty($this->callback)) {
                    if($arg instanceof \Closure && class_exists('delegatr\Lambda')) {
                        $this->callback = new \delegatr\Lambda($arg);
                    } else {
                        $this->callback = $arg;
                    }
                    
                    unset($args[$k]);
                }
            }
            
            parent::__construct($args);
        }
        
        /**
         * Retrieves statement callback
         * @return callable
         */
        function getCallback() {
            return $this->callback;
        }
    }
}
