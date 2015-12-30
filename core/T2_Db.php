<?php
class T2_Db extends Db {

    /**
     * @param $name
     * @return bool
     */
    public function select_category_by_name($name){
        $sql = <<<sql
SELECT * FROM categories WHERE name = :name
sql;
        $data = [
            'name' => $name,
        ];
        try{
            return $this->select_one_rec($sql, $data);
        }
        catch(Exception $e){
            Debig::msg($e->getMessage());
        }
    }

    /**
     * @param $name
     * @throws Exception
     */
    public function insert_category($name){
        $sql = <<<sql
INSERT INTO categories SET name = :name
sql;
        $data = [
            'name' => $name,
        ];

        try{
            $this->sql_prepare_and_execute($sql, $data);
        }
        catch(Exception $e){
            Debig::msg($e->getMessage());
        }
    }

    /**
     * @param $old_name
     * @param $new_name
     * @throws Exception
     */
    public function edit_category($old_name, $new_name){
        $sql = <<<sql
UPDATE categories SET name = :new_name WHERE name = :old_name
sql;
        $data = [
            'new_name' => $new_name,
            'old_name' => $old_name
        ];
        try{
            $this->sql_prepare_and_execute($sql, $data);
        }
        catch(Exception $e){
            Debig::msg($e->getMessage());
        }
    }

    /**
     * @param $order
     * @return array|bool
     */
    public function category_view($order){
        $sql = <<<sql
SELECT * FROM categories ORDER BY name $order
sql;

        try{
            return $this->select_all($sql);
        }
        catch(Exception $e){
            Debig::msg($e->getMessage());
        }
    }

    /**
     * @param $name
     */
    public function category_delete($name){
        $sql = <<<sql
DELETE FROM categories WHERE name = :name
sql;
        $data = [
            'name' => $name,
        ];

        try{
            $this->sql_prepare_and_execute($sql, $data);
        }
        catch(Exception $e){
            Debig::msg($e->getMessage());
        }
    }

    /**
     * @param $name
     * @return bool
     */
    public function select_product_by_name($name){
        $sql = <<<sql
SELECT * FROM products WHERE name = :name
sql;
        $data = [
            'name' => $name,
        ];
        try{
            return $this->select_one_rec($sql, $data);
        }
        catch(Exception $e){
            Debig::msg($e->getMessage());
        }
    }

    public function create_product($name, $details, $category_id){
        $sql = <<<sql
INSERT INTO
products
SET
name = :name,
details = :details,
category_id = :category_id
sql;
        $data = [
            'name' => $name,
            'details' => $details,
            'category_id' => $category_id
        ];

        try{
            return $this->sql_prepare_and_execute($sql, $data);
        }
        catch(Exception $e){
            Debig::msg($e->getMessage());
        }

    }

    public function update_product_details($name, $details){
        $sql = <<<sql
UPDATE products
SET
details = :details
WHERE
name = :name
sql;
        $data = [
            'details' => $details,
            'name' => $name
        ];

        try{
            $this->sql_prepare_and_execute($sql, $data);
        }
        catch(Exception $e){
            Debig::msg($e->getMessage());
        }

    }

    public function update_product_name($old_name, $new_name){
        $sql = <<<sql
UPDATE products
SET
name = :new_name
WHERE
name = :old_name
sql;
        $data = [
            'new_name' => $new_name,
            'old_name' => $old_name
        ];

        try{
            $this->sql_prepare_and_execute($sql, $data);
        }
        catch(Exception $e){
            Debig::msg($e->getMessage());
        }

    }

    public function update_product_category($name, $category_id){
        $sql = <<<sql
UPDATE products
SET
category_id = :category_id
WHERE
name = :name
sql;
        $data = [
            'category_id' => $category_id,
            'name' => $name
        ];

        try{
            $this->sql_prepare_and_execute($sql, $data);
        }
        catch(Exception $e){
            Debig::msg($e->getMessage());
        }
    }

    public function view_product($name){
        $sql = <<<sql
SELECT
p.name name,
c.name category,
p.details details
FROM products p
JOIN
categories c
ON
p.category_id = c.id
WHERE p.name = :name
LIMIT 1
sql;
        $data = [
            'name' => $name
        ];
        try{
            return $this->select_one_rec($sql, $data);
        }
        catch(Exception $e){
            Debig::msg($e->getMessage());
        }

    }

    public function select_products_by_category_id($category_id){
        $sql = <<<sql
SELECT * FROM products WHERE category_id = :category_id
sql;
        $data = [
            'category_id' => $category_id
        ];

        return $this->select_all($sql, $data);
    }




}
