<?php
class product extends Controller {

    /**
     * Создание продукта
     * формат URL /product/create/<название>/<имя категории>/<детали>
     * @param $req
     */
    public function create($req){
        $name = category::normalize_urlencode($req[0]);
        $details = category::normalize_urlencode($req[1]);
        $category_name = category::normalize_urlencode($req[2]);
        //проверим, существует ли такая категория
        $db = new T2_Db();
        $category = $db->select_category_by_name($category_name);
        if(!$category){
            echo json_encode([
                'result' => 'error',
                'msg' => 'category does not exist'
            ]);
            die();
        }
        //проверим, нет ли такого продукта
        $product = $db->select_product_by_name($name);
        if($product){
            echo json_encode([
                'result' => 'error',
                'msg' => 'this product already exist'
            ]);
            die();
        }
        //все ок
        $db->create_product($name, $details, $category['id']);
        echo json_encode([
            'result' => 'ok',
        ]);
        die();
    }

    /**
     * Редактирование деталей продукта
     * формат URL /product/edit_details/<название>/<новые детали>
     * @param $req
     */
    public function edit_details($req){
        $name = category::normalize_urlencode($req[0]);
        $details = category::normalize_urlencode($req[1]);
        $db = new T2_Db();
        $product = $db->select_product_by_name($name);
        if(!$product){
            echo json_encode([
                'result' => 'error',
                'msg' => 'product does not exist'
            ]);
            die();
        }
        $db->update_product_details($name, $details);
        echo json_encode([
            'result' => 'ok',
        ]);
        die();
    }

    /**
     * Редактирование названия продукта
     * формат URL /product/edit_name/<старое название>/<новое название>
     * @param $req
     */
    public function edit_name($req){
        $old_name = category::normalize_urlencode($req[0]);
        $new_name = category::normalize_urlencode($req[1]);
        $db = new T2_Db();
        $product = $db->select_product_by_name($old_name);
        if(!$product){
            echo json_encode([
                'result' => 'error',
                'msg' => 'product does not exist'
            ]);
            die();
        }
        $db->update_product_name($old_name, $new_name);
        echo json_encode([
            'result' => 'ok',
        ]);
        die();
    }

    /**
     * Редактирование названия продукта
     * формат URL /product/edit_category/<имя продукта>/<имя категории>
     * @param $req
     */
    public function edit_category($req){
        $name = category::normalize_urlencode($req[0]);
        $category_name = category::normalize_urlencode($req[1]);
        $db = new T2_Db();
        $product = $db->select_product_by_name($name);
        if(!$product){
            echo json_encode([
                'result' => 'error',
                'msg' => 'product does not exist'
            ]);
            die();
        }
        $category = $db->select_category_by_name($category_name);
        if(!$category){
            echo json_encode([
                'result' => 'error',
                'msg' => 'category does not exist'
            ]);
            die();
        }
        $db->update_product_category($name, $category['id']);
        echo json_encode([
            'result' => 'ok',
        ]);
        die();
    }

    /**
     * Просмотр данных продукта
     * формат URL /product/view/<имя продукта>/<тип - html или json>
     * @param $req
     */
    public function view($req){
        $name = category::normalize_urlencode($req[0]);
        $type = (isset($req[0]) && in_array($req[1], ['json', 'html']))?$req[1]:'json';//указан ли вид и правильно ли
        $db = new T2_Db();
        $product_data = $db->view_product($name);
        if(!$product_data){
            echo json_encode([
                'result' => 'error',
                'msg' => 'product does not exist'
            ]);
            die();
        }
        if($type == 'json'){
            echo json_encode([
                'result' => 'ok',
                'product' => $product_data
            ]);
            die();
        }
        $tpl = new Tpl_Obj();
        $tpl->display('common/page_header.tpl');
        $tpl->assign('product_data', $product_data);
        $tpl->display('product_view/prod_table.tpl');
        $tpl->display('common/page_footer.tpl');
    }

    /**
     * Просмотр продуктов заданной категории
     * формат URL /product/view_products_by_category/<имя категории>/<тип - html или json>
     * @param $req
     */
    public function view_products_by_category($req){
        Auth::check_token();
        $category_name = category::normalize_urlencode($req[0]);
        $type = (isset($req[0]) && in_array($req[1], ['json', 'html']))?$req[1]:'json';//указан ли вид и правильно ли
        $db = new T2_Db();
        $category = $db->select_category_by_name($category_name);
        if(!$category){
            echo json_encode([
                'result' => 'error',
                'msg' => 'category does not exist'
            ]);
            die();
        }
        $products = $db->select_products_by_category_id($category['id']);
        if(!$products){
            echo json_encode([
                'result' => 'error',
                'msg' => 'no products in this category'
            ]);
            die();
        }
        if($type == 'json'){
            echo json_encode([
                'result' => 'ok',
                'product' => $products,
            ]);
            die();
        }
        $tpl = new Tpl_Obj();
        $tpl->display('common/page_header.tpl');
        $tpl->assign('products', $products);
        $tpl->display('product_view/prod_by_cat.tpl');
        $tpl->display('common/page_footer.tpl');
    }







}
