# Php enum

Reading this document assumes that you already know the basics of enumeration. If not, consult the documentation first.

PHP has provided us with enumeration classes through the SQL class library, but unfortunately it needs to be installed in an extended way and the methods provided are limited.

As a result, developers provide many excellent enumeration libraries, but many times the enumeration values we need are not single, so this library provides support for multiple enumeration values.

## Install

    $ composer require yinfuyuan/php-enum
    
## Enum

It is generally not recommended to use this class directly unless you are clear about the purpose for which you are doing so.

## ArrayEnum

Array enum provides the definition and use of key-value enums in the form of arrays. It restricts a single enum property to a fixed length of 2. And the first element of the array of attributes will be used as the key of the enum, and the second element will be used as the value of the enum.

### Error code usage

If you use it as a unified error code return, it should look something like this

    /**
     * @method static ErrorCodeEnum OK
     *
     * @method static CodeEnum UNKNOWN_ERROR
     *
     * @method static ErrorCodeEnum ERROR_DATA_VALIDATION
     * @method static ErrorCodeEnum ERROR_USER_INVALID
     * @method static ErrorCodeEnum ERROR_CONFIG_ERROR
     */
    class ErrorCodeEnum extends \PhpEnum\ArrayEnum
    {
        const OK = ['0', 'ok'];

        const UNKNOWN_ERROR = ['99999', 'Unknown error'];
        
        const ERROR_DATA_VALIDATION = ['10047', 'The given data was invalid'];
        const ERROR_USER_INVALID = ['10010', 'User credentials was invalid'];
        const ERROR_CONFIG_ERROR = ['10031', 'Config info is error'];
    }
    
You need to define a separate exception class to use the enumeration

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
    
Returns the result of success

    return [
        'code' => ErrorCodeEnum::OK()->getKey(),
        'msg' => ErrorCodeEnum::OK()->getValue(),
        'data' => $data,
    ];
    // {"code":"0","msg":"ok","data":""}

You can do this when you encounter an exception that returns the expected result

    throw new ApiException(ErrorCodeEnum::ERROR_DATA_VALIDATION());
    // {"code":10047,"msg":"The given data was invalid","data":""}
    
    throw new ApiException(ErrorCodeEnum::ERROR_USER_INVALID(),'This is data');
    // {"code":10010,"msg":"User credentials was invalid","data":"This is data"}

### Enumeration usage

If you use it as enumeration, it should look something like this

    /**
     * @method static ArticleEnum TYPE_ARTICLE
     * @method static ArticleEnum TYPE_STORY
     * @method static ArticleEnum TYPE_NEWS
     *
     * @method static ArticleEnum SHARE_PRIVATE
     * @method static ArticleEnum SHARE_PROTECTED
     * @method static ArticleEnum SHARE_PUBLIC
     *
     * @method static ArticleEnum STATUS_NORMAL
     * @method static ArticleEnum STATUE_AUDIT
     * @method static ArticleEnum STATUE_INACTIVE
     * @method static ArticleEnum STATUS_INVALID
     */
    class ArticleEnum extends \PhpEnum\ArrayEnum
    {
        const TYPE_ARTICLE= ['1', 'article']; // 文章
        const TYPE_STORY = ['2', 'story']; // 故事
        const TYPE_NEWS = ['3', 'news']; // 新闻
    
        const SHARE_PRIVATE = ['1', 'private']; // 私有
        const SHARE_PROTECTED = ['2', 'protected']; // 保护
        const SHARE_PUBLIC = ['3', 'public']; // 公开
    
        const STATUS_NORMAL = ['1', 'normal']; // 正常
        const STATUE_AUDIT = ['7', 'inactive']; // 待审核
        const STATUE_INACTIVE = ['8', 'inactive']; // 待激活
        const STATUS_INVALID = ['9', 'invalid']; // 失效
    }
    
You can do this when you verify that you are within the defined type range

    in_array('1', ArticleEnum::getKeys('type')) // true
    in_array('1', ArticleEnum::getKeys()) // true deprecated when multiple groups exist
    in_array('news', ArticleEnum::getValues('type')); // true
    in_array('private', ArticleEnum::getValues('type')); // false
    in_array('private', ArticleEnum::getValues()); // false deprecated when multiple groups exist
    in_array('public', ArticleEnum::getValues('share')); // true
    in_array('public', ArticleEnum::getValues()); // true deprecated when multiple groups exist
    
When you process request parameters

    $_POST = [
        'type' => 'story',
        'share' => 'public',
    ]
    
    $article->type = ArticleEnum::searchKey($_POST['type'], 'type');
    $article->share = ArticleEnum::searchKey($_POST['share'], 'share');
    $article->status = ArticleEnum::STATUS_NORMAL()->getKey();
    
## ListEnum

    todo
    
## ScalarEnum

    todo