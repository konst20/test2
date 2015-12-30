<?php
class category extends Controller {

    /**
     * Проверяем, нормальное ли русское название, или URL-кодированное
     * вида %D1%82%D0%B5%D1%81%D1%82
     * и, если нужно, приводим его к нормальному, некодированному виду
     * @param $string
     * @return bool
     */
    public static function normalize_urlencode($string){
        if(preg_match('~%[A-Z0-9]{2}~', $string)){
            return urldecode($string);
        }
        return $string;
    }

    /**
     * Создание категории
     * формат URL /category/<category name>
     * @param $req
     */
    public function create($req){
        Auth::check_token();
        $name = self::normalize_urlencode($req[0]);
        $db = new T2_Db();
        $check_category_name = $db->select_category_by_name($name); //проверим, не существует ли категория
        if($check_category_name){
            $out = [
            'result' => 'error',
            'msg' => 'category exists',
            ];
            echo json_encode($out);
            die();
        }
        $db->insert_category($name);// можно получить ID вставленной категории через PDO
        $created_category = $db->select_category_by_name($name); //но пойдем в лоб
        $out = [
            'result' => 'ok',
            'name' => $created_category['name'],
            'id' => $created_category['id'],
        ];
        echo json_encode($out);
    }

    /**
     * Редактирование названия категории
     * формат URL /category/<old category name>/<new category name>
     * @param $req
     */
    public function edit($req){
        $old_name = self::normalize_urlencode($req[0]);
        $new_name = self::normalize_urlencode($req[1]);
        $db = new T2_Db();
        $check_old_category = $db->select_category_by_name($old_name);//а существует ли категория, которую редактируем
        if(!$check_old_category){
            $out = [
                'result' => 'error',
                'msg' => 'edited category does not exists',
            ];
            echo json_encode($out);
            die();
        }
        $check_new_category = $db->select_category_by_name($new_name);//нету ли уже такого имени, на которое меняем
        if($check_new_category){
            $out = [
                'result' => 'error',
                'msg' => 'new category name already exists',
            ];
            echo json_encode($out);
            die();
        }
        $db->edit_category($old_name, $new_name);
        $out = [
            'result' => 'ok',
        ];
        echo json_encode($out);
        die();
    }

    /**
     * Просмотр категорий
     * формат URL /category/<тип - json или html>/<порядок - asc или desc>
     * @param $req
     */
    public function view($req){
        $type = (isset($req[0]) && in_array($req[0], ['json', 'html']))?$req[0]:'json';//указан ли вид и правильно ли
        $order = (isset($req[1]) && in_array($req[1], ['asc', 'desc']))?$req[1]:'asc';//указан ли порядок и правильно ли
        $db = new T2_Db();
        $categories = $db->category_view($order);
        if($type == 'json'){
            echo json_encode($categories);
            die();
        }
        //далее - если явно указан вид html
        $tpl = new Tpl_Obj();
        $tpl->display('common/page_header.tpl');
        $tpl->assign('categories', $categories);
        $tpl->display('category_view/cats_table.tpl');
        $tpl->display('common/page_footer.tpl');
    }


    /**
     * Удаление категории
     * формат URL /category/<имя категории>
     * @param $req
     */
    public function delete($req){
        $name = self::normalize_urlencode($req[0]);
        $db = new T2_Db();
        $check_category_name = $db->select_category_by_name($name); //проверим, существует ли категория
        if(!$check_category_name){
            $out = [
                'result' => 'error',
                'msg' => 'category does not exists',
            ];
            echo json_encode($out);
            die();
        }
        $db->category_delete($name);
        $out = [
            'result' => 'ok',
        ];
        echo json_encode($out);
    }




}
