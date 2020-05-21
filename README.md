## [中文文档](https://github.com/yinfuyuan/php-enum/blob/master/README_CN.md)

# Overview

Reading this document assumes that you already know the basics of enumeration. If not, consult the documentation first.

Enums can be used in every project, but they are defined and used in different ways. In PHP, most enums exist as either constants or static variables.

PHP has provided us with enumeration classes through the SQL class library, but unfortunately it needs to be installed in an extended way and the methods provided are limited.

As a result, developers provide many excellent enumeration libraries, but many times the enumeration values we need are not single, so this library provides support for multiple enumeration values.

## Install

    $ composer require yinfuyuan/php-enum
    
## Document

All enumeration classes are abstract classes, which cannot be directly instantiated. Enumeration properties need to be defined after inheritance, and the inherited subclasses cannot get the instance in the way of new.

* ### Enum [src](https://github.com/yinfuyuan/php-enum/blob/master/src/Enum.php) [tests](https://github.com/yinfuyuan/php-enum/blob/master/tests/EnumTest.php)

The enumeration value of the underlying enumeration has no type limitation, but all the enumeration values of the same enumeration class should have the same type. When the enumeration property value is null or the enumeration property is not defined, null will be returned.

However, if the constant is not defined, an e_warn-level error is generated. An ErrorException exception is thrown in the partial version, so the use of null values should be avoided

The following takes user enumeration as an example to introduce the use of basic enumeration. In the following definition, enumeration includes both the gender of the user and the state of the user, and the two groups of enumeration are distinguished by different prefixes

You should also use prefix arguments when looking up or getting a set of properties, otherwise you will fail to get the expected results because two of the same values will cause key conflicts. You can also split the enumeration of users

Are defined as gender enumeration and state enumeration, respectively

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
    
Get an example of a male gender in the following way

    UserEnum::SEX_MAN();
    
The basic enumeration provides the following methods
    
```
getKey              : Gets the name of the enumeration
getValue            : Gets the value of the enumeration
keyEquals           : Whether the key of the enumeration is equal to the given key（==）
valueEquals         : Whether the value of an enumeration is equal to a given value（==）
getKeys             : [static method] gets all the keys enumerated and returns them as data. If the key prefix is specified, only the specified key prefix is searched
getValues           : [static method] gets all values of the enumeration and returns them in the form of data. The key of the array is the enumeration name. If the key prefix is specified, only the specified key prefix will be searched
keyExist            : [static method] read whether the specified key exists in the enumeration, and if the key prefix is specified, only look it up according to the specified key prefix
valueExist          : [static method] determines whether the specified value exists in the enumeration. If the key prefix is specified, only the specified key prefix is searched
searchKey           : [static method] look up the key value according to the specified value. If the key prefix is specified, look up only according to the specified key prefix
searchValue         : [static method] look up the value according to the specified key. If the key prefix is specified, look up only according to the specified key prefix
getSize             : [static method] returns the number of enumerated properties, and if the key prefix is specified, only the specified key prefix is searched
```

The basic enumeration can be combined with the validator of the framework to determine the domain value
    
    ['sex' => 'required|in:' . implode(',', UserEnum::getValues('sex'))];
    
    in_array($sex, UserEnum::getValues('sex'));
    
It can also be assigned or judged as a default property

    $user->status = UserEnum::SEX_MAN()->getValue();

    UserEnum::SEX_MAN()->valueEquals($user->status);

* ### ListEnum [src](https://github.com/yinfuyuan/php-enum/blob/master/src/ListEnum.php) [tests](https://github.com/yinfuyuan/php-enum/blob/master/tests/ListEnumTest.php)

List enumeration inherits from the underlying enumeration. Enumeration properties are limited to one-dimensional arrays of unfixed length, and the length of the enumeration property is specified by overriding the static constant **$ENUM_LENGTH** after the enumeration of the inherited list

The following takes city enumeration as an example to introduce the use of list enumeration. In the following definition, enumeration length is 3, which respectively represents the province code, city code and city name

    /**
     * @method static self CIRY_BEIJING
     * @method static self CIRY_LIAONING
     * @method static self CIRY_SHENYANG
     * @method static self CIRY_DALIAN
     */
    class CityEnum extends \PhpEnum\ListEnum
    {
        protected static $ENUM_LENGTH = 3;
        const CIRY_BEIJING = ['110000', '110000', 'BEIJINGSHI'];
        const CIRY_LIAONING = ['22000', '22000', 'LIAONINGSHENG'];
        const CIRY_SHENYANG = ['22000', '210100', 'SHENYANGSHI'];
        const CIRY_DALIAN = ['22000', '210200', 'DALIANSHI'];
        private $enum_pcode;
        private $enum_code;
        private $enum_name;
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
    
The enumeration example of shenyang city is obtained in the following way

    CityEnum::CIRY_SHENYANG();
    
List enumerations inherit from the methods of the underlying enumeration and provide the following methods
    
```
get                 : Gets the value of the specified index
getLength           : [static method] gets the enumeration property length
```

List enumerations provide two quick ways to access the list because the length of the enumeration properties is not fixed

1. By accessing the enumeration of nonexistent property names containing numeric subscripts, for example:
    
    CityEnum::CIRY_SHENYANG()->property0 // An element that represents access to an array of enumerated attributes subscript 0, and so on
    
2. If the enumeration property is no longer than 26, the list enumeration provides access to large letters instead of numeric subscripts. For example:

    CityEnum::CIRY_SHENYANG()->A // An element that represents access to an array of enumerated attributes subscript 0, and so on
    
In addition to the above two shortcuts, it is recommended that you provide an attribute for each element, as defined by CityEnum, starting with a lowercase enum_, private or protected, and providing a getter,

Do not provide setters, as this may break the enumeration structure. When you get a list enumeration instance, the attributes of each element are automatically initialized in the order defined. Note that the number of properties and the length of enumeration properties should be the same.

List enumerations can be found by looking at the parent city enumeration

    // todo
    
List enumerations can be found for all child city enumerations by the following method

    // todo
    
* ### ArrayEnum [src](https://github.com/yinfuyuan/php-enum/blob/master/src/ArrayEnum.php) [tests](https://github.com/yinfuyuan/php-enum/blob/master/tests/ArrayEnumTest.php)

The array enumeration inherits from the list enumeration, and the enumeration property is fixed to 2 in length, always taking the first element as the key and the second element as the value

Let's take the error code as an example to introduce the use of array enumeration. In the following definition, key is the error code and value is the error description

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
        
Get an error-free enumeration instance in the following manner

    ErrorCodeEnum::OK();
    
List enumerations inherit from the methods of the base and list enumerations and provide the following methods
    
```
getEnumKey          : Get the enumeration name
getEnumValue        : Get enumeration values
getKey              : [rewrite] Gets the first element of the enumeration value
getValue            : [rewrite] Gets the second element of the enumeration value
getValues           : [rewrite] Key is the first element of the enumeration value, and value is the second element of the enumeration value. If the key prefix is specified, only the specified key prefix will be searched
```

To return a uniform error code, you need an exception class to handle it

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
    
Define a successful return format with the help of the framework

    Response::macro('caps', function ($data) {
        return [
            'code' => ErrorCodeEnum::OK()->getKey(),
            'msg' => ErrorCodeEnum::OK()->getValue(),
            'data' => $data,
        ];
    });
    
Returns the result of success

    return response()->caps('');
    // {"code":"0","msg":"ok","data":""}
    
Returns the result of a failure

    throw new ApiException(ErrorCodeEnum::ERROR_DATA_VALIDATION());
    // {"code":10047,"msg":"The given data was invalid","data":""}
    
    throw new ApiException(ErrorCodeEnum::ERROR_USER_INVALID(),'This is data');
    // {"code":10010,"msg":"User credentials was invalid","data":"This is data"}