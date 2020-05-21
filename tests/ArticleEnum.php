<?php

namespace PhpEnum\Tests;

/**
 * @method static self TYPE_ARTICLE
 * @method static self TYPE_STORY
 * @method static self TYPE_NEWS
 *
 * @method static self SHARE_PRIVATE
 * @method static self SHARE_PROTECTED
 * @method static self SHARE_PUBLIC
 *
 * @method static self STATUS_NORMAL
 * @method static self STATUS_AUDIT
 * @method static self STATUS_INACTIVE
 * @method static self STATUS_INVALID
 */
class ArticleEnum extends \PhpEnum\ArrayEnum
{

    const TYPE_ARTICLE = ['1', 'article']; // 文章
    const TYPE_STORY = ['2', 'story']; // 故事
    const TYPE_NEWS = ['3', 'news']; // 新闻

    const SHARE_PRIVATE = ['1', 'private']; // 私有
    const SHARE_PROTECTED = ['2', 'protected']; // 保护
    const SHARE_PUBLIC = ['3', 'public']; // 公开

    const STATUS_NORMAL = ['1', 'normal']; // 正常
    const STATUS_AUDIT = ['7', 'inactive']; // 待审核
    const STATUS_INACTIVE = ['8', 'inactive']; // 待激活
    const STATUS_INVALID = ['9', 'invalid']; // 失效

}
