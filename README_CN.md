## [README Of English](https://github.com/yinfuyuan/php-enum)

## 概述

阅读此文档时，假设您已经了解枚举的基础知识。如果你不了解，请先查阅相关文档。
枚举在每个项目中都有可能会被用到，只是定义和使用的方式不同，在PHP中大多数枚举是以常量或静态变量的形式存在的。
PHP官方通过SPL类库为我们提供了枚举类[SplEnum](https://www.php.net/manual/en/class.splenum.php) ，但它通常需要再次封装才能很好的使用，其次是它必须要以扩展的方式进行安装才能使用。
此枚举类通过参考[JAVA枚举](https://docs.oracle.com/javase/8/docs/api/java/lang/Enum.html) ，实现了其部分功能。

使用此枚举类时你应该注意以下问题。

1. 在定义枚举时只有通过public或protected修饰的const关键字定义的常量才会被枚举识别使用
2. 在定义枚举值时，所有枚举值的类型与长度应该一致
3. 一组枚举命名应该使用统一前缀
4. 定义枚举时同时也应该定义枚举对应的注释

## 安装

    composer require phpenum/phpenum
    
## 文档

所有枚举类都是抽象类，不能直接实例化使用，需要继承后定义枚举属性，继承后的子类也不能通过new的方式获取实例。

* ### 基础枚举 [源码](https://github.com/yinfuyuan/php-enum/blob/master/src/Enum.php) [测试用例](https://github.com/yinfuyuan/php-enum/blob/master/tests/EnumTest.php)

基础枚举的枚举值没有类型限制，但是同一枚举类的所有枚举值的类型应该是相同的，当枚举属性值为null或者未定义枚举属性时 都会返回null，
但是如果常量未定义，会产生一个 E_WARNING 级别的错误。在部分版本中会抛出一个ErrorException异常，所以应尽量避免null值的使用

下面以用户枚举为例，介绍基础枚举的用法，如下定义中枚举既包含了用户的性别，又包含了用户的状态，两组枚举使用不同的前缀来区分
在查找或获取一组属性的时候也应该使用前缀参数，否则会因为两个相同的值导致key冲突从而无法获取预期的结果。 获取你还可以通过拆分枚举的方式将用户枚举
分别定义为性别枚举和状态枚举

    /**
     * @method static self SEX_MAN
     * @method static self SEX_WOMAN
     * @method static self STATUS_NORMAL
     * @method static self STATUS_INVALID
     */
    class UserEnum extends \PhpEnum\Enum
    {
        const SEX_MAN = 1; // 1表示性别男
        const SEX_WOMAN = 2; // 2表示性别女
        const STATUS_NORMAL = 1; // 1表示正常状态
        const STATUS_INVALID = 9; // 9表示无效状态
    }
    
通过下面的方式获取性别男的实例

    UserEnum::SEX_MAN();
    
基础枚举提供了以下方法
    
```
getKey              : 获取枚举的名称
getValue            : 获取枚举的值
keyEquals           : 枚举的key与给定的key是否相等（==）
valueEquals         : 枚举的value与给定的value是否相等（==）
getKeys             : 【静态方法】获取枚举所有的key，以数据的形式返回，如果指定了key前缀，只按照指定key前缀进行查找
getValues           : 【静态方法】获取枚举所有的value，以数据的形式返回，数组的键为枚举名称，如果指定了key前缀，只按照指定key前缀进行查找
keyExist            : 【静态方法】判读指定的key是否存在枚举中，如果指定了key前缀，只按照指定key前缀进行查找
valueExist          : 【静态方法】判断指定的值是否存在枚举中，如果指定了key前缀，只按照指定key前缀进行查找
searchKey           : 【静态方法】根据指定的value查找key值，如果指定了key前缀，只按照指定key前缀进行查找
searchValue         : 【静态方法】根据指定的key查找value值，如果指定了key前缀，只按照指定key前缀进行查找
getSize             : 【静态方法】返回枚举属性的数量，如果指定了key前缀，只按照指定key前缀进行查找
```

基础枚举可以结合框架的验证器进行域值判定
    
    ['sex' => 'required|in:' . implode(',', UserEnum::getValues('sex'))];
    
    in_array($sex, UserEnum::getValues('sex'));
    
还可以当作默认属性赋值或属性判断

    $user->status = UserEnum::SEX_MAN()->getValue();

    UserEnum::SEX_MAN()->valueEquals($user->status);

* ### 列表枚举 [源码](https://github.com/yinfuyuan/php-enum/blob/master/src/ListEnum.php) [测试用例](https://github.com/yinfuyuan/php-enum/blob/master/tests/ListEnumTest.php)

列表枚举继承于基础枚举，枚举属性限制为非固定长度的一维数组，继承列表枚举后需要通过重写静态常量 **$ENUM_LENGTH** 来指定枚举属性长度

下面以城市枚举为例，介绍列表枚举的用法，如下定义中枚举长度为3，分别代表省份编码，城市编码，城市名称

    /**
     * @method static self CITY_BEIJING
     * @method static self CITY_LIAONING
     * @method static self CITY_SHENYANG
     * @method static self CITY_DALIAN
     */
    class CityEnum extends \PhpEnum\ListEnum
    {
        protected static $ENUM_LENGTH = 3;
        const CITY_BEIJING = ['110000', '110000', '北京市']; // 北京市
        const CITY_LIAONING = ['22000', '22000', '辽宁省']; // 辽宁省
        const CITY_SHENYANG = ['22000', '210100', '沈阳市']; // 沈阳市
        const CITY_DALIAN = ['22000', '210200', '大连市']; // 大连市
        private $enum_pcode; // 省份编码
        private $enum_code; // 城市编码
        private $enum_name; // 城市名称
        public function getPcode()
        {
            return $this->enum_pcode;
        }
        public function getCode()
        {
            return $this->enum_code;
        }
        public function getName()
        {
            return $this->enum_name;
        }
    }
    
通过下面的方式获取沈阳市枚举实例

    CityEnum::CITY_SHENYANG();
    
列表枚举继承了基础枚举的方法外提供了以下方法
    
```
get                 : 获取指定索引的值
searchRelations     : 获取关系枚举的值
getLength           : 【静态方法】获取枚举属性长度
```

列表枚举因为枚举属性长度不固定，所以提供了两种快捷的访问方式

1. 通过访问枚举的不存在属性名称中包含数字下标的方式，例：
    
    CityEnum::CITY_SHENYANG()->property0 // 代表访问枚举属性数组下标0的元素，以此类推
    
2. 如果枚举属性长度不超过26，列表枚举提供英文大些字母代替数字下标的访问方式，例：

    CityEnum::CITY_SHENYANG()->A // 代表访问枚举属性数组下标0的元素，以此类推
    
除了上面两种快捷的方式，更推荐你像CityEnum定义那样，为每个元素提供属性，属性名以小写enum_开头，定义为private或protected，并提供getter，
不要提供setter，因为这样可能会破坏枚举结构。获取列表枚举实例时，会按照定义的顺序自动初始化每个元素的属性。注意属性数量和枚举属性长度应保持一致。

列表枚举可以通过下面方法查找父城市枚举值

    CityEnum::CITY_SHENYANG()->searchRelations(0, 1)
    
列表枚举可以通过下面方法查找所有子城市枚举值

    CityEnum::CITY_LIAONING()->searchRelations(1, 0)
    
* ### 数组枚举 [源码](https://github.com/yinfuyuan/php-enum/blob/master/src/ArrayEnum.php) [测试用例](https://github.com/yinfuyuan/php-enum/blob/master/tests/ArrayEnumTest.php)

数组枚举继承于列表枚举，枚举属性长度固定为2，始终以第一个元素作为key，第二个元素作为value

下面以错误代码为例，介绍数组枚举的用法，如下定义中key为错误代码，value为错误描述

        /**
         * @method static self OK
         * @method static self UNKNOWN_ERROR
         * @method static self ERROR_DATA_VALIDATION
         * @method static self ERROR_USER_INVALID
         * @method static self ERROR_CONFIG_ERROR
         */
        class ErrorCodeEnum extends \PhpEnum\ArrayEnum
        {
            const OK = ['0', 'ok'];
            const UNKNOWN_ERROR = ['99999', 'Unknown error'];
            const ERROR_DATA_VALIDATION = ['10047', 'The given data was invalid'];
            const ERROR_USER_INVALID = ['10010', 'User credentials was invalid'];
            const ERROR_CONFIG_ERROR = ['10031', 'Config info is error'];
        }
        
通过下面的方式获取无错误枚举实例

    ErrorCodeEnum::OK();
    
数组枚举继承了基础枚举和列表枚举的方法外提供了以下方法
    
```
getEnumKey          : 获取枚举名称
getEnumValue        : 获取枚举值
getKey              : 【重写】获取枚举值第一个元素
getValue            : 【重写】获取枚举值第二个元素
getValues           : 【重写】key为枚举值第一个元素，value为枚举值第二个元素，如果指定了key前缀，只按照指定key前缀进行查找
```

要实现返回统一格式错误码，还需要借助异常类来处理

    class ApiException extends Exception
    {
        private $data;
        public function __construct(ErrorCodeEnum $enum, $data = '')
        {
            parent::__construct($enum->getValue(), $enum->getKey());
            $this->data = $data;
        }
        public function report()
        {
            // todo log
        }
        public function render($request)
        {
            return response([
                'code' => $this->getCode(),
                'msg' => $this->getMessage(),
                'data' => $this->data
            ]);
        }
    }
    
借助框架定义成功的返回格式

    Response::macro('caps', function ($data) {
        return [
            'code' => ErrorCodeEnum::OK()->getKey(),
            'msg' => ErrorCodeEnum::OK()->getValue(),
            'data' => $data,
        ];
    });
    
返回成功的结果

    return response()->caps('');
    // {"code":"0","msg":"ok","data":""}
    
返回失败的结果

    throw new ApiException(ErrorCodeEnum::ERROR_DATA_VALIDATION());
    // {"code":10047,"msg":"The given data was invalid","data":""}
    
    throw new ApiException(ErrorCodeEnum::ERROR_USER_INVALID(),'This is data');
    // {"code":10010,"msg":"User credentials was invalid","data":"This is data"}