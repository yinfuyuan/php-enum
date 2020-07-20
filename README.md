## [中文文档](https://github.com/yinfuyuan/php-enum/blob/master/README_CN.md)

# Overview

As you read this document, assume that you already understand the basic concepts of enumerations. Otherwise you might be confused by parts of the document.

Enumerations maybe used in every project, and in PHP they are usually replaced by a set of constants or static variables. But in complex situations where there are combinations or associations between attributes, using enumerations can significantly reduce development and maintenance costs.

PHP official by SPL class library has provided us enumeration class [SplEnum](https://www.php.net/manual/en/class.splenum.php) , but first you need to install it in the form of extension, secondly it usually need to encapsulation to good use.

This enum class by reference [JAVA Enum](https://docs.oracle.com/javase/8/docs/api/java/lang/Enum.html) , which implements a simple and easy to use but powerful enum class library.

## Install

    $ composer require phpenum/phpenum
    
## Document

When defining an enumeration, only constants defined by the const keyword decorated with public or protected will be recognized by the enumeration class, where public can be omitted.
All enumeration classes are abstract classes. Enumeration classes are constructed in a protected way that cannot be instantiated and can only be obtained through the methods provided by enumeration classes.
Because of PHP's floating-point type precision, when an enumerated property contains a floating-point type value, you should not trust any alignment or lookup based on that floating-point type. See [floating point precision](https://www.php.net/manual/en/language.types.float.php) .
If you have the same enumeration constant value in the same enumeration object, you should use prefixes in both the definition and the use of the group, otherwise you should not trust the results of a comparison or lookup with the same enumeration constant value.

* ### Enum [src](https://github.com/yinfuyuan/php-enum/blob/master/src/Enum.php) [tests](https://github.com/yinfuyuan/php-enum/blob/master/tests/EnumTest.php)

The base enumeration is single-value type enumeration. The enumeration class does not enforce type constraints on the enumeration constant values, but you should always make each set of enumeration constant values of the same type.
All getters in the base enumeration omit get, which is reserved for subclasses that implement getters.

The basic enumeration provides the following methods

```
name                : Gets the name of the enumeration
value               : Gets the value of the enumeration
equals              : Determines whether the current enumeration is equal to the given enumeration
nameEquals          : Determines whether the name of the enumeration is equal to the given name
valueEquals         : Determines whether the enumerated value is equal to the given value
names               : [static method]Gets all the names enumerated, returns as data, if a name prefix is specified, returns only the portion of the specified name prefix
values              : [static method]Gets all the values of the enumeration, returned as data, the key of the array as the enumeration name, and returns only the portion of the specified name prefix if the name prefix is specified
enums               : [static method]Gets all instances of the enumeration, returns as data, the key of the array as the enumeration name, and returns only the portion of the specified name prefix if the name prefix is specified
hasName             : [static method]Determines whether an enumeration name exists and, if a name prefix is specified, determines only the portion of the specified name prefix
hasValue            : [static method]Determines whether an enumerated constant value exists and, if a name prefix is specified, only the portion of the specified name prefix
byName              : [static method]Gets an enumeration instance based on the enumeration name and, if a name prefix is specified, judges only the portion of the specified name prefix
byValue             : [static method]Gets the enumeration instance based on the enumeration constant value and, if a name prefix is specified, judges only the portion of the specified name prefix
count               : [static method]Returns the number of enumerated properties, and if a name prefix is specified, determines only the portion of the specified name prefix
```

The following is an example of defining a user enumeration to introduce the use of the basic enumeration. The following user enumeration contains two sets of enumeration constant values for the user's gender and state, using the SEX and STATUS prefixes, respectively.

    /**
     * @method static self SEX_MAN
     * @method static self SEX_WOMAN
     * @method static self STATUS_NORMAL
     * @method static self STATUS_INVALID
     */
    class UserEnum extends \PhpEnum\Enum
    {
        const SEX_MAN = 1;
        const SEX_WOMAN = 2;
        const STATUS_NORMAL = 1;
        const STATUS_INVALID = 9;
    }
    
The enumeration object can be obtained through the following method. The enumeration object will be cached after it is created for the first time. The enumeration object obtained through any method is always the same.

    UserEnum::SEX_MAN(); // If an instance is not created, only an instance of the current enumerated constant value is created and returned, which is recommended
    UserEnum::byName('SEX_MAN'); // If there are uncreated instances, all instances of uncreated enumerated constant values are created and the current instance is returned
    UserEnum::byValue(1,'SEX'); // If the current group has uncreated instances, an instance of all uncreated enumeration constant values for the current group is created, and then the current instance is returned
    UserEnum::enums('SEX')['SEX_MAN']; // If the current group has uncreated instances, an instance of all uncreated enumeration constant values for the current group is created, and then the current instance is returned
    
* ### ListEnum [src](https://github.com/yinfuyuan/php-enum/blob/master/src/ListEnum.php) [tests](https://github.com/yinfuyuan/php-enum/blob/master/tests/ListEnumTest.php)

List enumeration inherits from the base enumeration and is many-valued, where many-values are implemented by array elements, so the type of the enumeration constant value must be defined as an array, and the length of the array must be specified by the **length** method of the list enumeration class.
List enumeration for enum constants in each array element defines a private property as the carrier, and then rewrite the list enumeration class ListEnum * * * * method will receive the data elements assigned to fixed property, often use [list](https://www.php.net/manual/en/function.list.php) for distribution.
List enumerations need to provide getters for each carrier property, but setters should not be provided to prevent the enumeration structure from being corrupted.
List enumerations inherit all the methods of the underlying enumeration, but since list enumerations are of array type, **valueEquals** values** *hasValue** *byValue** These methods using enumeration constant values usually don't make much sense.

List enumerations provide the following methods

```
ListEnum            : List enumeration class with the same name method, accepts the current enumeration constant value and needs to be overridden
length              :[static method]Returns the number of enumeration constant value elements in the list, which needs to be overridden
```

The following takes the city enumeration as an example to introduce the use of list enumeration. The enumeration constant length in the following city enumeration is 3, including the province code, city code and city name.

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
    
Gets the city enumeration property value

    CityEnum::PROVINCE_LIAONING()->getProvince(); // string(1) "0"
    CityEnum::PROVINCE_LIAONING()->getCity(); // string(5) "22000"
    CityEnum::PROVINCE_LIAONING()->getName(); // string(8) "Liaoning"
    
Gets cities to enumerate all provinces and cities, respectively
    
    CityEnum::enums('PROVINCE'); // Gets all province enumerations
    CityEnum::enums('province', false); // Gets all province enumerations
    
    CityEnum::enums('CITY'); // Gets all city enumerations
    CityEnum::enums('city', false); // Gets all city enumerations
    
* ### ArrayEnum [src](https://github.com/yinfuyuan/php-enum/blob/master/src/ArrayEnum.php) [tests](https://github.com/yinfuyuan/php-enum/blob/master/tests/ArrayEnumTest.php)

Array enumeration inherits from list enumeration, for double-value type enumeration, array enumeration constant value always has two elements, the first element is the key, the second element is the value.
**valueEquals** *hasValue** *byValue** These inherited and underlying enumeration methods have been overridden to use the second element of the constant value as value.

Array enumerations provide the following methods

```
getKey              : Gets the first element of the data enumeration constant value
getValue            : Gets the second element of the data enumeration constant value
keyEquals           : Determines whether the first element of the data enumeration constant value is equal to the given value
valueEquals         : Determines whether the second element of the data enumeration constant value is equal to the given value
getKeys             : [static method]Gets a collection of data that enumerates the first element of a constant value, returns as data, and returns only the portion of the specified name prefix if one is specified
getValues           : [static method]Gets a collection of data that enumerates the first element of a constant value, returns as data, and returns only the portion of the specified name prefix if one is specified
getEnums            : [static method]Gets an array to enumerate all instances, returning as data, and returns only the portion of the specified name prefix if specified
hasKey              : [static method]Determines whether the first element of a data enumeration constant value exists and, if a name prefix is specified, determines only the portion of the specified name prefix
hasValue            : [static method]Determines whether the second element of the data enumeration constant value exists and, if a name prefix is specified, determines only the portion of the specified name prefix
byKey               : [static method]Gets the enumeration instance from the first element of the data enumeration constant value, judging only the portion of the specified name prefix if it is specified
byValue             : [static method]Gets the enumeration instance based on the second element of the data enumeration constant value and, if a name prefix is specified, judges only the portion of the specified name prefix
```

The following takes uniform error code as an example to introduce the use of array enumeration. In the following error code enumeration, key is error code and value is error description

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
    
You can get error codes and error descriptions in the following ways

    ErrorCodeEnum::OK()->getKey(); // string(1) "0"
    ErrorCodeEnum::OK()->getValue(); // string(2) "ok"
    
To implement the return uniform format error code, you also need to customize the exception class

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
    
When a failed result is returned, a custom exception is thrown and an error code enumeration is specified

    throw new ApiException(ErrorCodeEnum::ERROR_DATA_VALIDATION());
    // {"code":10000,"msg":"The given data was invalid","data":""}
    
    throw new ApiException(ErrorCodeEnum::ERROR_USER_INVALID(),'This is data');
    // {"code":20000,"msg":"User credentials was invalid","data":"This is data"}
    
Results that return success should be defined separately

    return [
        'code' => ErrorCodeEnum::OK()->getKey(),
        'msg' => ErrorCodeEnum::OK()->getValue(),
        'data' => ''，
    ];
    // {"code":"0","msg":"ok","data":""}