Custom pages
===================
Module contains backend and frontend parts.
Placed to backend it gives you ability to create custom pages in cms-like way.
Pages groups by categories, i.e. news, articles, etc.
Placed to frontend module displays category (list of pages previews) and pages itself by their friendly urls.
Pages of each category and category itself has own templates (Views), which you can define in category settings.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require andrewdanilov/yii2-custom-pages "~1.0.0"
```

or add

```
"andrewdanilov/yii2-custom-pages": "~1.0.0"
```

to the require section of your `composer.json` file.

Then run db migrations, to create needed tables:

```
php yii migrate --migrationPath=@andrewdanilov/custompages/migrations
```

Do not forget to run migrations after extension updates too.

Usage
-----

In backend main config modules section add:
```php
$config = [
    // ...
    'modules' => [
        // ...
        'custompages' => [
            'class' => 'andrewdanilov\custompages\Module',
            'controllerMap' => [
                'category' => [
                    'class' => 'andrewdanilov\custompages\controllers\backend\CategoryController',
                    // access role for category controller
                    'access' => ['admin'],
                ],
                'page' => [
                    'class' => 'andrewdanilov\custompages\controllers\backend\PageController',
                    // access role for page controller
                    'access' => ['admin'],
                ],
                // page-tag is optional controller. Define it if you want to use tags on your pages.
                'page-tag' => [
                    'class' => 'andrewdanilov\custompages\controllers\backend\PageTagController',
                    // access role for page-tag controller
                    'access' => ['admin'],
                ],
            ],
            // path to Views for pages and categories
            'templatesPath' => '@frontend/views/custompages',
            // optional, path to user translates
            'translatesPath' => '@common/messages/custompages',
            // optional, enables controls for managing page tags, default is true
            'enableTags' => false,
            // optional, enables controls for managing page albums, default is true
            'enableAlbums' => false,
        ],
    ],
];
```

Here 'access' option allows to restrict access to defined roles.

Backend CRUD actions available by links:

```php
use yii\helpers\Url;

$categoryUrl = Url::to(['/custompages/category']);
$pageUrl = Url::to(['/custompages/page']);
$pageTagUrl = Url::to(['/custompages/page-tag']);
```

In frontend main config modules section add:
```php
$config = [
    // ...
    'modules' => [
        // ...
        'custompages' => [
            'class' => 'andrewdanilov\custompages\Module',
            // optional, path to template Views for pages and categories
            'templatesPath' => '@frontend/views/custompages',
            // optional, path to user translates
            'translatesPath' => '@common/messages/custompages',
            // optional, page text short version length, default is 50
            'pageShortTextWordsCount' => '100',
            // optional, callable functions to process page and category text,
            // i.e. to replace some shortcodes on it
            'pageTextProcessorProcessorProcessor' => 'frontend\components\MyPageTextProcessorProcessorProcessor::replaceShortcodes',
            'categoryTextProcessorProcessorProcessor' => 'frontend\components\MyCategoryTextProcessor::replaceShortcodes',
        ],
    ],
];
```

Frontend category, page and tag urls:

```php
use yii\helpers\Url;

$categoryUrl = Url::to(['/custompages/default/category', 'id' => 1]);
$pageUrl = Url::to(['/custompages/default/page', 'id' => 123]);
$pageTagUrl = Url::to(['/custompages/default/page-tag', 'slug' => 'tagname']);
```

If you use own _templatesPath_ you need to copy example templates from __/vendor/andrewdanilov/yii2-custom-pages/src/views/frontend__ to your _templatesPath_ directory. Modify them or add as many templates as you need.

Note, that template file name for category must begins with prefix 'category.', and template file name for page must begins with prefix 'page.'.

Features
--------

Out of the box available some usefull features.

### Page cover

You can add some picture, represents your page. It is usefull in case of making blog posts, site news or articles.

### Html visual editor

Embedded WYSIWYG-editor helps you easily make any visual content. It has ability to place images, videos and other usefull things in content of your pages. 

### Human-friendly urls

You can define slugs for categories and pages. Pages can be under defined category or can has own url without relativity to category.

### Main page

You can define page as main page of the site. Than it repleces default index controller/action.

### Publish date

Any date can be define to pospone publication of page. If not set - it will be current date by default.

### Shortcodes

You can use some shortcodes in text content of created pages. To place gallery or slider inside page content, you can add theese shortcodes to page WYSIWYG-editor in admin area:

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

There is ability to set seo-tags for any created page or category. You can define browser title and meta description.

### Categories

Pages grouped by categories. You can add unlimited count of categories with unlimited count of pages inside each other. Each category can have own template for itself and separete template for pages stored in it. Categories can have unlimited nesting level. Pages can exist without any categories at all. In this case, the default template will be applied to them.

### Tags

Pages also can be grouped by tags. One tag can represent several pages. One page can contain many tags.

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
translations by defining `translatesPath` property of custompages module (see above).

### Page and Category text processor

You can define static function, that will process and change content of page or category text. See example with
parameter `pageTextProcessorProcessor` and `categoryTextProcessor` in module config above. That function must accept one string parameter and return string
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