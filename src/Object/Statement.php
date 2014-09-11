<?php
namespace qinq\Object {
    use qinq;
    
    abstract class Statement extends qinq\Query\Statement {
        
        /**
         * Stores first callable passed into constructor
         * All other callables are added to arguments
         * @var callable 
         */
        private $callback;
        
        /**
         * Default constructor for object statements
         */
        function __construct() {
            $args = func_get_args();
            
            foreach($args as $k => $arg) {
                if(is_callable($arg) && empty($this->callback)) {
                    if($arg instanceof \Closure && trait_exists('delegatr\Delegate')) {
                        $this->callback = new qinq\Query\Statement\Delegate($arg);
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