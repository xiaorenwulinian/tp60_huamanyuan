<?php

namespace app\lclsdk\validate\v1;

class ValidateTool {

    /**
     * 验证类型别名
     * @var array
     */
    protected $alias = [
        '>' => 'gt', '>=' => 'egt', '<' => 'lt', '<=' => 'elt', '=' => 'eq', 'same' => 'eq',
    ];
    /**
     * 当前验证规则
     * @var array
     */
    protected $rule = [];

    /**
     * 验证提示信息
     * @var array
     */
    protected $message = [];


    /**
     * 验证字段描述，给验证对字段起别名
     * @var array
     */
    protected $field = [];

    /**
     * 默认规则提示
     * @var array
     */
    protected $typeMsg = [
        'require'     => ':attribute require',
        'must'        => ':attribute must',
        'number'      => ':attribute must be numeric',
        'integer'     => ':attribute must be integer',
        'float'       => ':attribute must be float',
        'boolean'     => ':attribute must be bool',
        'email'       => ':attribute not a valid email address',
        'mobile'      => ':attribute not a valid mobile',
        'array'       => ':attribute must be a array',
        'accepted'    => ':attribute must be yes,on or 1',
        'date'        => ':attribute not a valid datetime',
        'file'        => ':attribute not a valid file',
        'image'       => ':attribute not a valid image',
        'alpha'       => ':attribute must be alpha',
        'alphaNum'    => ':attribute must be alpha-numeric',
        'alphaDash'   => ':attribute must be alpha-numeric, dash, underscore',
        'activeUrl'   => ':attribute not a valid domain or ip',
        'chs'         => ':attribute must be chinese',
        'chsAlpha'    => ':attribute must be chinese or alpha',
        'chsAlphaNum' => ':attribute must be chinese,alpha-numeric',
        'chsDash'     => ':attribute must be chinese,alpha-numeric,underscore, dash',
        'url'         => ':attribute not a valid url',
        'ip'          => ':attribute not a valid ip',
        'dateFormat'  => ':attribute must be dateFormat of :rule',
        'in'          => ':attribute must be in :rule',
        'notIn'       => ':attribute be notin :rule',
        'between'     => ':attribute must between :1 - :2',
        'notBetween'  => ':attribute not between :1 - :2',
        'length'      => 'size of :attribute must be :rule',
        'max'         => 'max size of :attribute must be :rule',
        'min'         => 'min size of :attribute must be :rule',
        'after'       => ':attribute cannot be less than :rule',
        'before'      => ':attribute cannot exceed :rule',
        'expire'      => ':attribute not within :rule',
        'allowIp'     => 'access IP is not allowed',
        'denyIp'      => 'access IP denied',
        'confirm'     => ':attribute out of accord with :2',
        'different'   => ':attribute cannot be same with :2',
        'egt'         => ':attribute must greater than or equal :rule',
        'gt'          => ':attribute must greater than :rule',
        'elt'         => ':attribute must less than or equal :rule',
        'lt'          => ':attribute must less than :rule',
        'eq'          => ':attribute must equal :rule',
        'unique'      => ':attribute has exists',
        'regex'       => ':attribute not conform to the rules',
        'method'      => 'invalid Request method',
        'token'       => 'invalid token',
        'fileSize'    => 'filesize not match',
        'fileExt'     => 'extensions to upload is not allowed',
        'fileMime'    => 'mimetype to upload is not allowed',    ];

    /**
     * 当前验证场景
     * @var string
     */
    protected $currentScene;

    /**
     * 验证场景定义
     * @var array
     */
    protected $scene = [];

    /**
     * 验证失败错误信息
     * @var array
     */
    protected $error = [];

    /**
     * 验证失败是否抛出异常
     * @var bool
     */
    protected $failException = false;

    /**
     * 场景需要验证的规则,某个场景，有哪些字段需要验证  $only = $onlyValidateAttributeArr
     * @var array
     */
    protected $only = [];


    public function __construct()
    {
    }

    /**
     * 添加字段验证规则
     * @param string|array $name 字段名称或者规则数组
     * @param mixed        $rule 验证规则或者字段描述信息
     * @return $this
     */
    public function rule($name, $rule = '')
    {
        if (is_array($name)) {
            $this->rule = $name + $this->rule;
            if (is_array($rule)) {
                $this->field = array_merge($this->field, $rule);
            }
        } else {
            $this->rule[$name] = $rule;
        }
        return $this;
    }

    /**
     * 设置提示信息
     * @access public
     * @param array $message 错误信息
     * @return Validate
     */
    public function message(array $message) : self
    {
        $this->message = array_merge($this->message, $message);
        return $this;
    }

    /**
     * 设置验证失败后是否抛出异常
     * @access protected
     * @param bool $fail 是否抛出异常
     * @return $this
     */
    public function failException(bool $fail = true)
    {
        $this->failException = $fail;
        return $this;
    }

    /**
     * 设置验证场景
     * @param string $sceneName 场景名
     * @return ValidateTool
     */
    public function scene(string $sceneName) : self
    {
        // 设置当前验证的场景
        $this->currentScene = $sceneName;
        return $this;
    }

    /**
     * 数据自动验证
     * @param array $data 要验证的数据，请求参数
     * @return bool
     */
    public function check(array $data) : bool
    {
        // 验证失败错误信息置空，防止之前验证器污染
        $this->error = [];

        // 获取验证规则,自定义验证器类重写的规则
        $rules = $this->rule;

//        如果传入了场景，并且传入的场景 在自定义的场景组中，那么对该场景需要验证的字段数组 赋值到全局变量中
        if ($this->currentScene) {
            // 重置当前验证场景需要验证的字段,通过 $this->>only 读取需要验证的字段
//            $this->getScene($this->currentScene);
            if (isset($this->scene[$this->currentScene])) {
                $this->only = $this->scene[$this->currentScene];
            }
        }

        foreach ($rules as $key => $rule) {
            // 'username' => 'require|max:60|...'

            // 替换默认的错误提示
           // 如  'require'     => ':attribute require', 变成 username require
            // 场景检测
            if (!in_array($key, $this->only)) {
                // 验证字段，不在该场景的验证组中，过滤掉
                continue;
            }
            // 根据键获取请求参数的值
//            $value = $this->getDataValue($data, $key);
            $value = $data[$key] ?? null;
            // 验证值是否符合验证规则
            $result = $this->checkItem($key, $value, $rule, $data);
            if (true !== $result) {
                // 根据传参来决定是抛出异常，还是返回验证结果
                if ($this->failException) {
                    throw new ValidateException($result);
                } else {
                    $this->error = $result;
                    return false;
                }
            }
        }
        return true;
    }
    /**
     * 获取数据验证的场景
     * @access protected
     * @param string $scene 验证场景
     * @return void
     */
    public function getScene(string $sceneName) :void
    {
        if (isset($this->scene[$sceneName])) {
            // 重置当前验证场景需要验证的字段
            $this->only = $this->scene[$sceneName];
        }

    }

    public function getError()
    {
        return $this->error;
    }
    /**
     * 获取数据值
     * @access protected
     * @param array  $data 验证数据，request接收的数据
     * @param string $key  当前键
     * @return mixed 短浅验证参数的值，可以是数组，字符串，对象
     */
    public function getDataValue($data, $key)
    {

        /*
         * 传入的参数
         $data = [
            'username' => 'lcl',
            'age' => '18',
            '44' => 'aa', // 正常传参键不应该是纯数字，应该是字符串
        ];
        */

        if (is_numeric($key)) {
            $value = $key; // 其他情况数值比较
        } else {
            $value = $data[$key] ?? null;
        }
        return $value;
    }

    /**
     * 验证单个字段规则
     * @access protected
     * @param string $attribute 字段名
     * @param mixed  $value 字段值
     * @param mixed  $rules 验证规则
     * @param array  $data  数据
     * @return mixed
     */
    protected function checkItem(string $attribute, $value, $rules, $data)
    {
        // 支持多规则验证 'username' => 'require|max:60|...'
        if (is_string($rules)) {
            $rules = explode('|', $rules);
        }
        foreach ($rules as $key => $rule) {
            // 判断验证类型
            list($methodName, $rule, $info) = $this->getValidateType($key, $rule);
            if ($info == 'must' || strpos($info, 'require') === 0 || (!is_null($info) && $info !== '') ) {
                // 'age' => 'between:1,100',call_user_func_array([$this, 'between'],[$value, '1,100', $data])
                $result = call_user_func_array([$this, $methodName], [$value, $rule, $data]) ;
            } else {
                // 验证规则为空，如 'username' => '' , 或者 'user' =>  '' | null
                $result = true;
            }

            if ($result === true) {
                // 此规则验证通过，继续验证下一个规则,全部验证成功，$result = true
                continue;
            }
            if (false === $result) {
                // 获取验证失败提示信息，有自定义则用自定义的，未自定义则用基类预定义的
                $message = $this->getRuleMsg($attribute, $info, $rule);
                return $message;
            } else {
                // 格式化返回的提示信息
                if (is_string($result) && strpos($result, ':')) {
                    $result = str_replace(':attribute', $attribute, $result);
                    // is_scalar() 检测是否是标量（整型，浮点型，布尔型，非对象，非数组，非资源，非闭包等）
                    if (strpos($result, ':rule') && is_scalar($rule)) {
                        $result = str_replace(':rule', (string) $rule, $result);
                    }
                }
                return $result;
            }
        }

        return $result;

    }




    /**
     * 获取当前验证类型及规则
     * @access public
     * @param mixed $key
     * @param mixed $rule
     * @return array
     */
    protected function getValidateType($key, $rule): array
    {
        // 规则验证 'username' => 'require'
        // 规则验证 'username' => 'max:60'
        // 规则验证 'age'      => 'require'
        // 规则验证 'age'      => '<:100' 等价于  'age' => 'lt:100' ， lt 别名 <
        /*
         一个字段多个验证规则
        $rules = [
            0 => 'require',
            1 => '<:100',
        ];
        $key = 0; $rule = require
        $key = 1; $rule = <:100
        */

        // 1
        if (strpos( $rule, ':')) {
            list($methodName, $rule) = explode(':', $rule, 2);
            if (isset($this->alias[$methodName])) {
                // 判断别名，有则将 "<" 替换成 lt
                $methodName = $this->alias[$methodName];
            }
            $info = $methodName; // $methodName : max, eq ,lq, between, min 等
        } elseif (method_exists($this, $rule)) {
        // 2
            // 自定义方法，去验证
            $methodName = $rule;
            $info = $rule;
            $rule = ''; // 将自定义规则为空,与基类内置的方法作区分
        } else {
        // 3
            // 由于require属于PHP保留字，所以在使用方法验证的时候必须使用isRequire或者must方法调用。
            $methodName = 'is'; // 如 require, boolean,number 等不要方法传参，仅仅验证字段格式，直接在is() 方法体内统一判断
            $info = $rule; // 单个字符串，如require
        }

         /*
          *  $method 验证规则类型
          [
            1. " max | lt | min | between " , // 基类定义好的方法
            2. " myIsMobile | myMethod",     // 自定义的方法
            3. "is"                          // 特殊的方法，is() 集中处理几种情况

         ]

         $info 验证规则名称
         [
            1. " max | < | min | between " ,
            2. " myIsMobile | myMethod",
            3. "require | must "
         ]

         $rule 验证规则数据
         [
            1. "255( &lt;:255) | 10,25(between:10,25)"
            2. " '' "
            3. "require | must "
         ]

         */


        return [$methodName, $rule, $info];

    }

    /**
     * 获取验证规则的错误提示信息
     * @param string $attribute 字段名称
     * @param string $type      字段的验证规则名称
     * @param mixed  $rule      验证规则数据
     * @return string
     */
    public function getRuleMsg(string $attribute, string $type, $rule)
    {
        // username.require => 'username属性必填'
        if (isset($this->message[$attribute . '.' . $type])) {
            $msg = $this->message[$attribute . '.' . $type];
        } else {
            // 使用基类预定义的提示信息
           if (isset($this->typeMsg[$type])) {
               $msg = $this->typeMsg[$type];
           } else {
               // 基类也未定义
               $msg = $attribute . " not conform to he rules !";
           }
        }
        return $this->parseErrorMsg($msg, $rule, $attribute);
    }
    /**
     * 获取验证规则的错误提示信息
     * @access protected
     * @param string $msg   错误信息
     * @param mixed  $rule  验证规则数据
     * @param string $attribute 字段描述名
     * @return string
     */
    public function parseErrorMsg(string $msg, $rule, string $attribute)
    {
        //  'require'     => ':attribute require',
        //  'between'     => ':attribute must between :1 - :2',
        //  'in'          => ':attribute must be in :rule',
        // 针对基类的提示信息格式替换，如将 :attribute 替换成 username
        if (false !== strpos($msg, ':')) {
            if (strpos($rule, ',')) {
                // 如 age => between:1,3, rule 是 1,3  使用基类的提示需要将数字格式替换
                // 预定义三个符号格式替换，不足用 '' 填充
                $array = array_pad(explode(',', $rule), 3, '');
            } else {
                $array = array_pad([], 3,'');
            }
            $msg  = str_replace(
                [':attribute', ':1', ':2', ':3'],
                [$attribute, $array[0], $array[1], $array[2]],
                $msg);
            if (strpos($msg, ':rule')) {
                $msg = str_replace(':rule', (string) $rule, $msg ) ;
            }
        }
        return $msg;
    }


    public function __call($methodName, $arguments)
    {
        // TODO: Implement __call() method.
        if ('is' == strtotime(substr($methodName, 0,2))) {
            $methodName = substr($methodName,2);
        }
        array_push($arguments, lcfirst($methodName));
        return call_user_func_array([$this, 'is'], $arguments);
    }




    /**
     * 验证一个字段是否在某个范围内 ，如 age => between:1,100 ,年龄在1--100
     * @param $value
     * @param $rule
     * @param array $data
     * @return bool
     */
    public function between($value, $rule, array $data = []) :bool
    {
        if (is_string($rule)) {
            $rule = explode(',', $rule);
        }
        list($min, $max) = $rule;
        return $value >= $min && $value <= $max;
    }

    /**
     * 验证一个字段不在某个范围内
     * @param $value
     * @param $rule
     * @param array $data
     * @return bool
     */
    public function notBetween($value, $rule, array $data = []) :bool
    {
        if (is_string($rule)) {
            $rule = explode(',', $rule);
        }
        list($min, $max) = $rule;
        return $value < $min && $value > $max;
    }

    /**
     * 验证数据最大长度
     * @param $value
     * @param $rule
     * @param array $data
     * @return bool
     */
    public function max($value, $rule, array $data = []) :bool
    {
        if (is_array($value)) {
            $length = count($value);
        } elseif ($value instanceof \think\File) {
            $length = $value->getSize();
        } else {
            $length = strlen($value);
        }
        return $length <= $rule;
    }
    /**
     * 验证数据最大长度
     * @param $value
     * @param $rule
     * @param array $data
     * @return bool
     */
    public function min($value, $rule, array $data = []) :bool
    {
        if (is_array($value)) {
            $length = count($value);
        } elseif ($value instanceof \think\File) {
            $length = $value->getSize();
        } else {
            $length = strlen($value);
        }
        return $length <= $rule;
    }

    /**
     * 验证字段值是否为有效格式
     * @param $value
     * @param $rule
     * @param array $data
     * @return bool
     */
    public function is($value, $rule, array $data = []) :bool
    {
        $filter = [
            'email'   => FILTER_VALIDATE_EMAIL,
            'ip'      => [FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 | FILTER_FLAG_IPV6],
            'integer' => FILTER_VALIDATE_INT,
            'url'     => FILTER_VALIDATE_URL,
            'macAddr' => FILTER_VALIDATE_MAC,
            'float'   => FILTER_VALIDATE_FLOAT,
        ];
        $defaultRegex = [
            'alpha'       => '/^[A-Za-z]+$/',
            'alphaNum'    => '/^[A-Za-z0-9]+$/',
            'alphaDash'   => '/^[A-Za-z0-9\-\_]+$/',
            'chs'         => '/^[\x{4e00}-\x{9fa5}]+$/u',
            'chsAlpha'    => '/^[\x{4e00}-\x{9fa5}a-zA-Z]+$/u',
            'chsAlphaNum' => '/^[\x{4e00}-\x{9fa5}a-zA-Z0-9]+$/u',
            'chsDash'     => '/^[\x{4e00}-\x{9fa5}a-zA-Z0-9\_\-]+$/u',
            'mobile'      => '/^1[3-9]\d{9}$/',
            'idCard'      => '/(^[1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$)|(^[1-9]\d{5}\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{2}$)/',
            'zip'         => '/\d{6}/',
        ];

        // 下划线转驼峰，如is_card => isCard
        $rule = lcfirst(str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $rule))));
        switch ($rule) {
            case 'require':
                // 必须
            $result = !empty($value) || $value == '0';
                break;
            case 'date':
                // 是否是一个有效日期
                $result = false !== strtotime($value);
                break;
            case 'activeUrl':
                // 是否为有效的网址
                $result = checkdnsrr($value);
                break;
            case 'boolean':
            case 'bool':
                // 是否为布尔值
                $result = in_array($value, [true, false, 0, 1, '0', '1'], true);
                break;
            case 'number':
                $result = ctype_digit((string) $value);
                break;
            case 'alphaNum':
                $result = ctype_alnum($value);
                break;
            case 'array':
                // c是否为数组
                $result = is_array($value);
                break;
            default:
                // Filter_var验证规则
                if (isset($filter[$rule])) {
                    if (is_string($rule) && strpos($rule, ',')) {
                        list($rule, $param) = explode(',', $rule);
                    } elseif (is_array($rule)) {
                        $param = $rule[1] ?? null;
                        $rule  = $rule[0];
                    } else {
                        $param = null;
                    }
                    $result = false !== filter_var($value, is_int($rule) ? $rule : filter_id($rule), $param);
                } else {
                    // 正则验证
                    if (isset($defaultRegex[$rule])) {
                        $rule = $defaultRegex[$rule];
                    }
                    if (is_string($rule) && 0 !== strpos($rule, '/') && !preg_match('/\/[imsU]{0,4}$/', $rule)) {
                        // 不是正则表达式则两端补上/
                        $rule = '/^' . $rule . '$/';
                    }
                    $result = is_scalar($value) && 1 === preg_match($rule, (string) $value);
                }
        }
        return $result;
    }

    /**
     * 使用filter_var方式验证
     * @access public
     * @param mixed $value 字段值
     * @param mixed $rule  验证规则
     * @return bool
     */
    public function filter($value, $rule): bool
    {
        if (is_string($rule) && strpos($rule, ',')) {
            list($rule, $param) = explode(',', $rule);
        } elseif (is_array($rule)) {
            $param = $rule[1] ?? null;
            $rule  = $rule[0];
        } else {
            $param = null;
        }

        return false !== filter_var($value, is_int($rule) ? $rule : filter_id($rule), $param);
    }


    /**
     * 使用正则验证数据
     * @access public
     * @param mixed $value 字段值
     * @param mixed $rule  验证规则 正则规则或者预定义正则名
     * @return bool
     */
    public function regex($value, $rule): bool
    {
        $defaultRegex = [
            'alpha'       => '/^[A-Za-z]+$/',
            'alphaNum'    => '/^[A-Za-z0-9]+$/',
            'alphaDash'   => '/^[A-Za-z0-9\-\_]+$/',
            'chs'         => '/^[\x{4e00}-\x{9fa5}]+$/u',
            'chsAlpha'    => '/^[\x{4e00}-\x{9fa5}a-zA-Z]+$/u',
            'chsAlphaNum' => '/^[\x{4e00}-\x{9fa5}a-zA-Z0-9]+$/u',
            'chsDash'     => '/^[\x{4e00}-\x{9fa5}a-zA-Z0-9\_\-]+$/u',
            'mobile'      => '/^1[3-9]\d{9}$/',
            'idCard'      => '/(^[1-9]\d{5}(18|19|([23]\d))\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{3}[0-9Xx]$)|(^[1-9]\d{5}\d{2}((0[1-9])|(10|11|12))(([0-2][1-9])|10|20|30|31)\d{2}$)/',
            'zip'         => '/\d{6}/',
        ];
        if (isset($defaultRegex[$rule])) {
            $rule = $defaultRegex[$rule];
        }
        if (is_string($rule) && 0 !== strpos($rule, '/') && !preg_match('/\/[imsU]{0,4}$/', $rule)) {
            // 不是正则表达式则两端补上/
            $rule = '/^' . $rule . '$/';
        }
        return is_scalar($value) && 1 === preg_match($rule, (string) $value);
    }
}