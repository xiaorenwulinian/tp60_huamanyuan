<?php


class Model
{


    /**
     * 模型回调
     * @var array
     */
    private static $event = [];

    /**
     * 模型事件观察,钩子函数，添加前，添加后，修改前，修改后，删除前，删除后
     * @var array
     */
    protected static $observe = [ 'before_insert', 'after_insert', 'before_update', 'after_update', 'before_delete', 'after_delete'];

    /**
     * 绑定模型事件观察者类
     * @var array
     */
    protected $observerClass; // 如 UserEvent

    public function __construct($data = [])
    {
        // .... 数据库连接等配置

        // 判断是否绑定观察者
        if ($this->observerClass) {
            // 注册模型观察者
            // 清除回调方法 ，防止模型污染
            self::$event[static::class] = [];
            // 遍历所有钩子方法
            foreach (static::$observe as $event) {
                // 将 before_insert 转换成 beforeInsert
                $eventFuncName = preg_replace_callback('/_([a-zA-Z])/', function ($match) {
                    return strtoupper($match[1]);
                }, $event);

                if (method_exists($this->observerClass, $eventFuncName)) {
                    $class = static::class;
                    self::$event[$class][$event] = [$this->observerClass, $eventFuncName];
                    // 如 self::event['User']['before_insert'] = ['UserEvent','beforeInsert'];
                }
            }
        }
    }



    public function insert($data)
    {

        $class = static::class;

        if (isset(self::$event[$class]['before_insert'])) {
            $class_method = self::$event[$class]['before_insert'];
            $class_name =  $class_method[0]; // UserEvent
            $method_name =  $class_method[1]; // beforeInsert
            $data = call_user_func_array([new $class_name(), $method_name], [$data]);

        }
        $sql = "insert user values ";
        echo 'update_attribute_age: '. $data['age'] ?? ''  . '<br/>';
        echo '<br/> insert success' . '<br/>';


        if (isset(self::$event[$class]['after_insert'])) {
            $class_method = self::$event[$class]['after_insert'];
            $class_name =  $class_method[0]; // UserEvent
            $method_name =  $class_method[1]; // beforeInsert

            $data = call_user_func_array([new $class_name(), $method_name], [$data]);

        }
    }



}

class User extends Model
{
    protected $observerClass = 'UserEvent'; // 事件观察着类，监听各种行为，如添加，修改，删除
}

class UserEvent
{
    public function beforeInsert($data)
    {
        echo 'init_age: '. $data['age'] ?? ''  ;
        if(isset($data['age'])) {
            $data['age'] = $data['age'] * 2; // 添加前属性修改器
        }
        echo '<br/>==beforeInsert==' . '<br/>';

        return $data;
    }

    public function afterInsert($data)
    {

        echo '==afterInsert==' . '<br/>';
        return $data;
    }

    public function beforeUpdate($data)
    {
        echo '==beforeUpdate==' . '<br/>';

    }

    public function afterUpdate($data)
    {
        echo '==afterUpdate==' . '<br/>';

    }

    public function beforeDelete($data)
    {
        echo '==beforeDelete==' . '<br/>';

    }

    public function afterDelete($data)
    {
        echo '==afterDelete==' . '<br/>';

    }
}



demo();

function demo()
{
    echo '<pre>';
    $user = new User();
    $user->insert(['age'=>18]);

}