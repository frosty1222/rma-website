<?php
if (!class_exists('Rma_Elementor')){
    
    class  Rma_Elementor  extends \Elementor\Widget_Base {
        
        public $name ='';
        public $title ='';
        public $icon ='';
        public $categories = ['rma'];
        
        public function get_name() {
            return $this->name;
        }
    
        public function get_title() {
            return 'Rma: '.$this->title;
        }
    
        public function get_icon() {
            return $this->icon;
        }
    
        public function get_categories() {
            return $this->categories;
        }

    }
}