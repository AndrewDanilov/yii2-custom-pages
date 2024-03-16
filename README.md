Custom pages
===================
Module contains backend and frontend parts.
Placed to backend it gives you ability to create custom pages in cms-like way.
Pages groups by categories, i.e. news, articles, etc.
Placed to frontend module displays category (list of pages previews) and pages itself by their friendly urls.
Pages and categories has own templates (Views), which you can define in page or category settings.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require andrewdanilov/yii2-custom-pages "~2.0.0"
```

or add

```
"andrewdanilov/yii2-custom-pages": "~2.0.0"
```

to the `require` section of your `composer.json` file.

Then run db migrations, to create needed tables:

```
php yii migrate --migrationPath=@andrewdanilov/custompages/console/migrations
```

Do not forget to run migrations after extension updates too.

Usage
-----

In backend main config `modules` section add:

```php
$config = [
    // ...
    'modules' => [
        // ...
        'custompages' => [
            'class' => 'andrewdanilov\custompages\backend\Module',
            // access role for module controllers, optional, default is ['@']
            'access' => ['admin'],
            // path to Views for pages and categories
            'templatesPath' => '@frontend/views/custompages',
            // optional, path to user translates
            'translatesPath' => '@common/messages/custompages',
            // optional, enables controls for managing page tags, default is true
            'enableTags' => false,
            // optional, enables controls for managing page albums, default is true
            'enableAlbums' => false,
            // optional, enables controls for managing categories, default is true
            'enableCategories' => false,
            // optional, enables controls for managing pages extra fields, default is true
            'enablePageFields' => false,
            // file manager configuration, optional, default is:
            'fileManager' => [
                'basePath' => '@frontend/web',
                'paths' => [
                    [
                        'name' => 'News',
                        'path' => 'upload/images/news',
                    ],
                    [
                        'name' => 'Articles',
                        'path' => 'upload/images/articles',
                    ],
                ],
            ],
            // bootstrap version to use, optional, default is '5.x'
            'bsVersion' => '5.x',
        ],
    ],
];
```

Here `access` option allows restricting access to defined roles.

Backend CRUD actions are available by links:

```php
use yii\helpers\Url;

$categoryUrl = Url::to(['/custompages/category']);
$pageUrl = Url::to(['/custompages/page']);
$pageTagUrl = Url::to(['/custompages/page-tag']);
```

Backend menu items example:

```php
$custom_pages_menu_items = [
    ['label' => 'Custom Pages'],
    ['label' => 'Articles', 'url' => ['/custompages/page', 'PageSearch' => ['category_id' => 123]], 'icon' => 'file'],
    ['label' => 'Without Category', 'url' => ['/custompages/page', 'PageSearch' => ['category_id' => 0]], 'icon' => 'file'],
    ['label' => 'All Pages', 'url' => ['/custompages/page'], 'icon' => 'file'],
];

echo \yii\widgets\Menu::widget(['items' => $custom_pages_menu_items]);
```

In frontend main config `modules` section add:
```php
$config = [
    // ...
    'modules' => [
        // ...
        'custompages' => [
            'class' => 'andrewdanilov\custompages\frontend\Module',
            // optional, path to template Views for pages and categories
            'templatesPath' => '@frontend/views/custompages',
            // optional, path to user translates
            'translatesPath' => '@common/messages/custompages',
            // optional, page text short version length, default is 50
            'pageShortTextWordsCount' => '100',
            // optional, callable functions to process page and category text,
            // i.e. to replace some shortcodes on it
            'pageTextProcessor' => 'frontend\components\MyPageTextProcessor::replaceShortcodes',
            'categoryTextProcessor' => 'frontend\components\MyCategoryTextProcessor::replaceShortcodes',
            // pagination settings
            'paginationForcePageParam' => false, // optional, whether to always have the page parameter in the URL, even on first page, default is false
            'paginationPageParam' => 'page', // optional, name of the parameter storing the current page index, default is 'page'
            'paginationPageSizeParam' => false, // optional, false or name of the parameter storing the page size, default is false
            'paginationPageSize' => 20, // optional, number of items per page, default is 20
        ],
    ],
];
```

Frontend __page__, __category__ and __tag__ urls:

```php
use yii\helpers\Url;

// detailed page url
$pageUrl = Url::to(['/custompages/default/page', 'id' => 123]);
// pages list url, shows pages in defined category
$categoryUrl = Url::to(['/custompages/default/category', 'id' => 1]);
// pages list url by tag id
$pageTagUrl = Url::to(['/custompages/default/page-tag', 'id' => 7]);
// pages list url by tag slug
$pageTagUrl = Url::to(['/custompages/default/page-tag', 'slug' => 'tagname']);
// pages list url by tag id, shows pages in defined category only
$pageTagUrl = Url::to(['/custompages/default/page-tag', 'id' => 7, 'category_id' => 123]);
// pages list url by tag slug, shows pages in defined category only
$pageTagUrl = Url::to(['/custompages/default/page-tag', 'slug' => 'tagname', 'category_id' => 123]);
```

Features
--------

Out of the box available some usefull features.

### Page cover

You can add some picture, represents your page. It is usefull in case of making blog posts, site news or articles.

### Html visual editor

Embedded WYSIWYG-editor helps you easily make any visual content. It has ability to place images, videos and other usefull things in content of your pages or categories. 

### Human-friendly urls

You can define slugs for categories and pages. For nested categories and their pages, a link is consistently composed of slugs of hierarchically nested categories.

### Main page

You can define a page as main page of the site. Then it repleces index action of default controller.

### Publish date

Any date can be defined to pospone publication of page. If not set manually, the creation date will be set as publish date.

### Shortcodes

You can use some predefined shortcodes in text content of created pages. To place gallery or slider inside page content, you can add theese shortcodes to page WYSIWYG-editor in admin area:

```text
[gallery album1566731453428]

or

[slider album1566731453428]

or

[gallery album1566731453428 alt="Some photo description, fig. {index}"]
```

Before that, album and some photos needs to be added to page (press "Add album" and than "Add photo"). Albums has own buttons to copy their shortcodes to clipboard.

With extended syntax of shortcode you can add "alt" attribute to all pictures of gallery or slider. It can contain substitutions: {index}, {filename}, {basename}, {extension}.

### SEO

There is ability to set seo-fields for any created page or category. You can define browser title and meta description.

### Categories

Pages grouped by categories. You can add unlimited count of categories with unlimited count of pages inside each other. Categories can have unlimited nesting level. Besides, pages can exist without any categories at all.

### Tags

Pages also can be grouped by tags. One tag can represent several pages. One page can contain many tags.

### Templates

Each category can have own template for itself and separete template for pages stored in it. At the same time, pages can have their own template, even if it was set in the category settings. If page template is not set in page settings, page template of category settings will be applied to it. If page have no own template and have no category, the default template will be used.

If you use own `templatesPath` you need to copy example templates from __/vendor/andrewdanilov/yii2-custom-pages/src/frontend/views__ to your `templatesPath` directory, for example to `frontend/views/custompages`. Modify them or add as many templates as you need.

Note, that template file name for a category must begin with the prefix '_category._', template file name for a page must begin with the prefix '_page._'. The default template names are '_category.default.php_' for category and '_page.default.php_' for page.

Template file name for a tag must begin with the prefix '_page-tag._'. A dot at the end of the prefix is required. Next to it you can place category slug to make standalone template for tag-page with defined category. For i.e. '_page-tag.fruits.php_' for category with slug '_fruits_'. If there is no such template file the default will be used. Default template file for page-tag is '_page-tag.default.php_'.

### Custom fields

For each category you can define extra fields applied to pages of that category. You can set values of this fields from backend within a page editor, and access them from your templates like this:

```php
<?php /* @var \andrewdanilov\custompages\common\models\Page $page */ ?>
Some Field Value: <?= $page->getField('some_field') ?>
Some Field Type: <?= $page->getFieldType('some_field') ?>
Some Field Exists: <?php if ($page->hasField('some_field')) echo 'yes'; else echo 'no'; ?>
```

For this feature to work you must enable `enablePageFields` property of custompage module in backend config (see above). If requested field is not exist, then getField() returns __empty string__, hasField() and getFieldType() returns __false__

Since the 2.0.20 update, if you previously used the "_source_" page field, you need to replace it in your templates with the custom fields method. For example, if you called $page->source, now you need to call $page->getField('source'). Your data from old field was converted to custom fields automatically.

### I18n

Extension supports internationalisation. You can set your language in `common/config/main.php`

```php
return [
    // ...
    'language' => 'ru-RU',
    // ...
];
```

On the moment you can use one of languages out of the box: English, Russian. Also you can create and use your own
translations by defining `translatesPath` property of custompages module (see above). Therefore, you need to place
the files `xx-XX/category.php`, `xx-XX/page.php`, `xx-XX/page-tag.php`, `xx-XX/common.php` in this path.
You can copy them from `src/common/messages` path of extension.

### Page and Category text processor

You can define static function, that will process and change page or category text content. See example with
parameter `pageTextProcessor` and `categoryTextProcessor` in module config above. That function must accept one string parameter and return string
with modifications made. In example, you can replace some shortcodes in text with that function. Function applies to
the text when you get it via processedText property of Page or Category ActiveRecord object. Made changes are not storing to database.

Example of processor function:

```php
namespace frontend\components;

class MyPageTextProcessor
{
    public static function replaceShortcodes($text)
    {
        return str_replace('some string', 'other string', $text);
    }
}
```