Custom pages
===================
Module contains backend and frontend parts.
Placed to backend it gives you ability to create custom pages in cms-like way.
Pages devides by categories, i.e. news, articles, etc.
Placed to frontend module displays category (list of pages previews) and pages itself by their SEF urls.
Pages of each category and category itself has own templates (Views), which you can define in category settings.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
composer require andrewdanilov/yii2-custom-pages "dev-master"
```

or add

```
"andrewdanilov/yii2-custom-pages": "dev-master"
```

to the require section of your `composer.json` file.

Than run db migrations, to create needed tables:

yii migrate --migrationPath=@andrewdanilov/custompages/migrations

Usage
-----

In backend main config modules section add:
```php
$config = [
    ...
    'modules' => [
        ...
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
            ],
            // path to Views for pages and categories
            'templatesPath' => '@frontend/views/custompages',
        ],
    ],
];
```

In frontend main config modules section add:
```php
$config = [
    ...
    'modules' => [
        ...
        'custompages' => [
            'class' => 'andrewdanilov\custompages\Module',
            // path to Views for pages and categories
            'templatesPath' => '@frontend/views/custompages', // path to pages and categories template views
        ],
    ],
];
```

If you use own _templatesPath_ you need to copy example files from __/vendor/andrewdanilov/yii2-custom-pages/src/views/frontend/default__ to your _templatesPath_ directory. Modify them or add as many templates as you need.

Note, that template file name for category must begins with prefix 'category.', meanwhile template file name for page must begins with prefix 'page.'