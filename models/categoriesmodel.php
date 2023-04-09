
<?php
     
    # This class set the model category on admin site. Whith this the  user can categorized thy expenses
    # ====================================================
    class CategoriesModel extends Model implements IModel{

        # Private variables we will use here
        private $id;
        private $name;
        private $color;

        public function __construct(){
            parent::__construct();
        }

        # Function to save the values
        # ====================================================
        public function save(){
            try{
                $query = $this->prepare('INSERT INTO categories (name, color) VALUES(:name, :color)');
                $query->execute([
                    'name' => $this->name, 
                    'color' => $this->color
                ]);
                if($query->rowCount()) return true;

                return false;
            }catch(PDOException $e){
                return false;
            }
        }
        
        # Function to get all the values
        # ====================================================
        public function getAll(){
            $items = [];

            try{
                $query = $this->query('SELECT * FROM categories');

                while($p = $query->fetch(PDO::FETCH_ASSOC)){
                    $item = new CategoriesModel();
                    $item->from($p); 
                    
                    array_push($items, $item);
                }

                return $items;

            }catch(PDOException $e){
                echo $e;
            }
        }
        
        # Function get a id value
        # ====================================================
        public function get($id){
            try{
                $query = $this->prepare('SELECT * FROM categories WHERE id = :id');
                $query->execute([ 'id' => $id]);
                $category = $query->fetch(PDO::FETCH_ASSOC);

                $this->from($category);

                return $this;
            }catch(PDOException $e){
                return false;
            }
        }
        
        # Function to delete a value
        # ====================================================
        public function delete($id){
            try{
                $query = $this->db->connect()->prepare('DELETE FROM categories WHERE id = :id');
                $query->execute([ 'id' => $id]);
                return true;
            }catch(PDOException $e){
                echo $e;
                return false;
            }
        }
        
        # Function to update  value
        # ====================================================
        public function update(){
            try{
                $query = $this->db->connect()->prepare('UPDATE categories SET name = :name, color = :color WHERE id = :id');
                $query->execute([
                    'name' => $this->name, 
                    'color' => $this->color
                ]);
                return true;
            }catch(PDOException $e){
                echo $e;
                return false;
            }
        }

        # Function validate if exists a category
        # ====================================================
        public function exists($name){
            try{
                $query = $this->prepare('SELECT name FROM categories WHERE name = :name');
                $query->execute( ['name' => $name]);
                
                if($query->rowCount() > 0){
                    error_log('CategoriesModel::exists() => true');
                    return true;
                }else{
                    error_log('CategoriesModel::exists() => false');
                    return false;
                }
            }catch(PDOException $e){
                error_log($e);
                return false;
            }
        }

        # This Function take an array and asign the values
        # ====================================================
        public function from($array){
            $this->id = $array['id'];
            $this->name = $array['name'];
            $this->color = $array['color'];
        }

        
        # Setting theirs getter and setter
        # ====================================================
        public function setId($id){$this->id = $id;}
        public function setName($name){$this->name = $name;}
        public function setColor($color){$this->color = $color;}

        public function getId(){return $this->id;}
        public function getName(){ return $this->name;}
        public function getColor(){ return $this->color;}
    }

?>