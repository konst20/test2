<?php
class Auth {

    /**
     * Секретный токен. Передается после данных в GET запросе
     * @var string
     */
    private static $token = 'I_am_super_secret_token';

    /**
     * Это просто заглушка. В реальности, конечно, требуется и нормальная генерация токенов сессий,
     * и нормальная их проверка
     * @return bool
     */
    public static function check_token(){
        if(isset($_GET['token']) && $_GET['token'] == self::$token){
            return;
        }

        Debig::view('Fake Fake Token', 1);
    }

}
