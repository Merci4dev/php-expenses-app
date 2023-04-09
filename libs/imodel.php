<?php
    
    # This interface configure methods which must be implement in a specific context. This allows to specify the function name and arguments which the method should be call and waht should be returned.
    # ====================================================
    interface IModel{
        
        public function save();
        public function getAll();
        public function get($id);
        public function delete($id);
        public function update();
        public function from($array);
    }

?>