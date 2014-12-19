<?php
namespace qinq\Object\Query {

    /**
     * Alias for Map
     */
    class Selector extends Filter {
        const ROOT = '/';
        
        /**
         * Locally stores selector
         * @var string
         */
        protected $selector;
        
        /**
         * Locally stores search depth
         * @var integer 
         */
        protected $depth = 0;
        
        /**
         * Selector constructor
         * @param string $selector
         */
        public function __construct($selector = self::ROOT) {
            $this->selector = trim($selector);
            
            parent::__construct(
                [$this,'recursiveMapSearch'], 
                true, 
                $this->selector
            );
        }
        
        /**
         * Performs selector search
         * @param mixed $value
         * @param mixed $key
         * @return mixed
         */
        protected function recursiveMapSearch($value,$key) {
            $selector = $this->arguments[2];
            
            if(empty($selector) || $selector == self::ROOT) {
                return $value;
            }
            
            $selectors = $this->splitSelectorOperations($selector);
            foreach($selectors as $s) {
                if (strpos($s, '[') === 0) {
                    $s = preg_replace('/]/', '', ltrim($s, '['), 1);
                }
        
                list($container,$subpath) = $this->splitSelectorIndex($s);

                if($subpath === null && $key === $container) {
                    return $value;
                } elseif($key === $container) {
                    $this->arguments[2] = substr($s,strlen($container));
                }

                if(is_array($value)) {
                    return $this->filter($value,[$this,'recursiveMapSearch']);
                }
            }
        }
        
        /**
         * Performs filtering with callback function
         * This function allows value mutation
         * @param array $arr
         * @param callable $fn
         * @param array $args
         * @return array
         */
        public function filter($arr, $fn, array $args = []) {
            $this->depth++;
            foreach($arr as $k=>$v) {
                $keep = call_user_func_array($fn, array_merge([$v,$k],$args));

                if(!$keep) {
                    unset($arr[$k]);
                } else {
                    $arr[$k] = $keep;
                }
            }
            
            if($this->arguments[2] !== $this->selector) {
                $this->arguments[2] = $this->selector;
            }
            
            $this->depth--;

            return $arr;
        }
        
        /**
         * Split selector by | operator
         * @param string $selector
         * @return array
         */
        protected function splitSelectorOperations($selector) {
            return explode('|',$selector);
        }
        
        /**
         * Split selector index into pieces
         * @param string $selector
         * @return array
         */
        protected function splitSelectorIndex($selector) {
            $open = strpos($selector,'[');
            if($open === false) {
                return [$selector, null];
            }
            
            $close = strpos($selector, ']');
            $container = substr($selector,0,$open);
            
            $subselector = 
                    substr($selector, $open + 1, $close - $open - 1) .
                    substr($selector, $close + 1);
            
            return [$container, $subselector];
        }
    }
}
