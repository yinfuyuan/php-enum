## [README Of English](https://github.com/yinfuyuan/php-enum)

## 概述

阅读此文档时，假设您已经了解枚举的基本概念。否则你可能会对文档中的部分内容感到困惑。
枚举在每个项目中都有可能会被用到，在PHP中通常使用一组常量或一组静态变量来代替枚举。但在属性之间存在着组合或关联关系的复杂情景中，使用枚举会大大降低开发和维护成本。
PHP官方通过SPL类库已经为我们提供了枚举类[SplEnum](https://www.php.net/manual/en/class.splenum.php) ，但首先你需要以扩展的方式安装它，其次它通常需要再次封装才能很好的使用。
此枚举类通过参考[JAVA枚举](https://docs.oracle.com/javase/8/docs/api/java/lang/Enum.html) ，实现了一个简单易用但功能强大的枚举类库。

## 安装

    composer require phpenum/phpenum
    
## 文档

在定义枚举时只有通过public或protected修饰的const关键字定义的常量才会被枚举类识别，其中public可以省略。
所有枚举类都是抽象类，枚举类构造方式是受保护的，无法进行实例化，只能通过枚举类提供的方法获取枚举单例。
受PHP的浮点类型精度影响，当枚举的属性包含浮点类型值时,不应该信任任何基于该浮点类型比对或查寻的结果。详见 [浮点精度描述](https://www.php.net/manual/en/language.types.float.php)
在同一个枚举对象中包含相同的枚举常量值时，应该在定义和使用的过程中都使用前缀进行分组使用，否则你不应该信任使用具有相同枚举常量值对比或查找的结果。

* ### 基础枚举 [源码](https://github.com/yinfuyuan/php-enum/blob/master/src/Enum.php) [测试用例](https://github.com/yinfuyuan/php-enum/blob/master/tests/EnumTest.php)

基础枚举为单值类型枚举，枚举类没有对枚举常量值进行强制类型约束，但你应该使每组枚举常量值的类型始终相同。
基础枚举中所有的getter方法都省略了get，这其实是为了其子类实现getter做了预留。

基础枚举提供了以下方法
    
```
name                : 获取枚举的名称
value               : 获取枚举的值
equals              : 判断当前枚举与给定的枚举是否相等
nameEquals          : 判断枚举的名称与给定的名称是否相等
valueEquals         : 判断枚举的值与给定的值是否相等
names               : 【静态方法】获取枚举所有的名称，以数据的形式返回，如果指定了名称前缀，只返回指定名称前缀的部分
values              : 【静态方法】获取枚举所有的值，以数据的形式返回，数组的键为枚举名称，如果指定了名称前缀，只返回指定名称前缀的部分
enums               : 【静态方法】获取枚举所有的实例，以数据的形式返回，数组的键为枚举名称，如果指定了名称前缀，只返回指定名称前缀的部分
hasName             : 【静态方法】判断枚举名称是否存在，如果指定了名称前缀，只判断指定名称前缀的部分
hasValue            : 【静态方法】判断枚举常量值是否存在，如果指定了名称前缀，只判断指定名称前缀的部分
byName              : 【静态方法】根据枚举名称获取枚举实例，如果指定了名称前缀，只判断指定名称前缀的部分
byValue             : 【静态方法】根据枚举常量值获取枚举实例，如果指定了名称前缀，只判断指定名称前缀的部分
count               : 【静态方法】返回枚举属性的数量，如果指定了名称前缀，只判断指定名称前缀的部分
```

下面以定义用户枚举为例，介绍基础枚举的用法，如下用户枚举中包含了用户的性别和状态两组枚举常量值，分别使用SEX和STATUS前缀。

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
    
通过下面的方法可以获取到枚举对象，枚举对象首次创建后会被缓存，再次通过任意方法获取到枚举对象始终为同一个，第一种方式效率最高，推荐使用。

    UserEnum::SEX_MAN(); // 如果实例未创建，只会创建并返回当前枚举常量值的实例，推荐使用
    UserEnum::byName('SEX_MAN'); // 如果有未创建的实例，会创建所有未创建的枚举常量值的实例，然后返回当前实例
    UserEnum::byValue(1,'SEX'); // 如果当前组有未创建的实例，会创建当前组所有未创建的枚举常量值的实例，然后返回当前实例
    UserEnum::enums('SEX')['SEX_MAN']; // 如果当前组有未创建的实例，会创建当前组所有未创建的枚举常量值的实例，然后返回当前实例

* ### 列表枚举 [源码](https://github.com/yinfuyuan/php-enum/blob/master/src/ListEnum.php) [测试用例](https://github.com/yinfuyuan/php-enum/blob/master/tests/ListEnumTest.php)

列表枚举继承于基础枚举，为多值类型枚举，其中的多值是通过数组元素来实现的，所以枚举常量值的类型必须定义为数组，且数组的长度也要通过列表枚举类的 **length** 方法指定。
列表枚举需要为枚举常量中每一个数组元素定义一个私有属性作为载体，然后通过重写列表枚举类的 **ListEnum** 方法将接受到的数据元素分配到固定属性，通常使用 [list](https://www.php.net/manual/en/function.list.php) 来进行分配。
列表枚举需要为每个载体属性提供getter方法，但不应该提供setter方法防止枚举结构被破坏。
列表枚举继承了基础枚举的所有方法，但由于列表枚举常量值的类型为数组，**valueEquals** **values** **hasValue** **byValue** 这些使用枚举常量值的方法通常没有太大意义。

列表枚举提供了以下方法
    
```
ListEnum            : 列表枚举类同名方法，接受当前枚举常量值，需要进行重写
length              :【静态方法】返回列表枚举常量值元素的个数，需要进行重写
```

下面以城市枚举为例，介绍列表枚举的用法，如下城市枚举中的枚举常量长度为3，包含了省份编码，城市编码，城市名称

    /**
     * @method static self PROVINCE_LIAONING
     * @method static self CITY_BEIJING
     * @method static self CITY_SHENYANG
     * @method static self CITY_DALIAN
     */
    class CityEnum extends \PhpEnum\ListEnum
    {
        const PROVINCE_LIAONING = ['0', '22000', 'Liaoning'];
        const CITY_BEIJING = ['110000', '110000', 'Beijing'];
        const CITY_SHENYANG = ['22000', '210100', 'Shengyang'];
        const CITY_DALIAN = ['22000', '210200', 'Dalian'];
        private $province;
        private $city;
        private $name;
        protected final function ListEnum($list)
        {
            list($this->province, $this->city, $this->name) = $list;
        }
        public final static function length()
        {
            return 3;
        }
        public function getProvince()
        {
            return $this->province;
        }
        public function getCity()
        {
            return $this->city;
        }
        public function getName()
        {
            return $this->name;
        }
    }
    
获取城市枚举属性值

    CityEnum::PROVINCE_LIAONING()->getProvince(); // string(1) "0"
    CityEnum::PROVINCE_LIAONING()->getCity(); // string(5) "22000"
    CityEnum::PROVINCE_LIAONING()->getName(); // string(8) "Liaoning"

分别获取城市枚举所有省份和城市
    
    CityEnum::enums('PROVINCE'); // 获取所有省份枚举
    CityEnum::enums('province', false); // 获取所有省份枚举
    
    CityEnum::enums('CITY'); // 获取所有城市枚举
    CityEnum::enums('city', false); // 获取所有城市枚举
    
* ### 数组枚举 [源码](https://github.com/yinfuyuan/php-enum/blob/master/src/ArrayEnum.php) [测试用例](https://github.com/yinfuyuan/php-enum/blob/master/tests/ArrayEnumTest.php)

数组枚举继承于列表枚举，为双值类型枚举，数组枚举常量值始终有两个元素，第一个元素作为key，第二个元素作为value。
数组枚举中value含义将不再是枚举常量值，而是常量值中的第二个元素， **valueEquals** **hasValue** **byValue** 这些继承与基础枚举的方法都已被重写并使用常量值中的第二个元素作为value。

数组枚举提供了以下方法
    
```
getKey              : 获取数据枚举常量值的第一个元素
getValue            : 获取数据枚举常量值的第二个元素
keyEquals           : 判断数据枚举常量值的第一个元素与给定的值是否相等
valueEquals         : 判断数据枚举常量值的第二个元素与给定的值是否相等
getKeys             : 【静态方法】获取数据枚举常量值第一个元素的集合，以数据的形式返回，如果指定了名称前缀，只返回指定名称前缀的部分
getValues           : 【静态方法】获取数据枚举常量值第一个元素的集合，以数据的形式返回，如果指定了名称前缀，只返回指定名称前缀的部分
getEnums            : 【静态方法】获取数组枚举所有的实例，以数据的形式返回，如果指定了名称前缀，只返回指定名称前缀的部分
hasKey              : 【静态方法】判断数据枚举常量值第一个元素是否存在，如果指定了名称前缀，只判断指定名称前缀的部分
hasValue            : 【静态方法】判断数据枚举常量值第二个元素是否存在，如果指定了名称前缀，只判断指定名称前缀的部分
byKey               : 【静态方法】根据数据枚举常量值第一个元素获取枚举实例，如果指定了名称前缀，只判断指定名称前缀的部分
byValue             : 【静态方法】根据数据枚举常量值第二个元素获取枚举实例，如果指定了名称前缀，只判断指定名称前缀的部分
```

下面以统一格式错误码为例，介绍数组枚举的用法，如下错误码枚举中key为错误码，value为错误描述

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
        const ERROR_DATA_VALIDATION = ['10000', 'The given data was invalid'];
        const ERROR_USER_INVALID = ['20000', 'User credentials was invalid'];
        const ERROR_CONFIG_ERROR = ['30000', 'Config info is error'];
    }
        
通过下面的方式可以获取错误码和错误描述信息

    ErrorCodeEnum::OK()->getKey(); // string(1) "0"
    ErrorCodeEnum::OK()->getValue(); // string(2) "ok"

要实现返回统一格式错误码，还需要自定义异常类

    class ApiException extends Exception
    {
        private $data;
        public function __construct(ErrorCodeEnum $enum, $data = '')
        {
            parent::__construct($enum->getValue(), $enum->getKey());
            $this->data = $data;
        }
        public function toArray()
        {
            return [
                'code' => $this->getCode(),
                'msg' => $this->getMessage(),
                'data' => $this->data
            ];
        }
    }
    
返回失败结果时，抛出自定义异常并指定错误码枚举

    throw new ApiException(ErrorCodeEnum::ERROR_DATA_VALIDATION());
    // {"code":10000,"msg":"The given data was invalid","data":""}
    
    throw new ApiException(ErrorCodeEnum::ERROR_USER_INVALID(),'This is data');
    // {"code":20000,"msg":"User credentials was invalid","data":"This is data"}
    
返回成功的结果应该单独定义

    return [
        'code' => ErrorCodeEnum::OK()->getKey(),
        'msg' => ErrorCodeEnum::OK()->getValue(),
        'data' => ''，
    ];
    // {"code":"0","msg":"ok","data":""}