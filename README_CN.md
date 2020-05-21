阅读此文档时，假设您已经了解了枚举的基础知识。如果没有，请先查阅相关文档。

枚举在每个项目都可能会被用到，只是定义和使用的方式大有不同，在php中大多数枚举是以常量或静态变量的形式存在的

PHP通过SPL类库为我们提供了枚举类SplEnum，但遗憾的是，首先它提供的方法需要再次进行封装才能满足一些需求，其次它需要以扩展的方式安装才能进行使用。

由此，许多优秀的开发人员提供了许多功能强大的枚举类库，而此枚举类库提供了更严谨的使用方式。

规范：

1. 在定义枚举时应该使用const关键字进行声明，而枚举名称需要全部大写
2. 在定义枚举值时，所有枚举值的类型和长度应该一致
3. 一组枚举命名应该使用统一前缀
4. 定义枚举时同时也应该定义枚举对应的注释

例：

	/**
	 * @method static StatusEnum STATUS_NORMAL
	 * @method static StatusEnum STATUS_INVALID
	 */
	class StatusEnum extends \PhpEnum\ArrayEnum
	{
	    const STATUS_NORMAL = ['1', 'normal'];
	    const STATUS_INVALID = ['9', 'invalid'];
	}

当枚举属性值为null或者未定义枚举属性时 都会返回null，但是如果常量未定义，会产生一个 E_WARNING 级别的错误。在php7以上版本会抛出一个ErrorException异常