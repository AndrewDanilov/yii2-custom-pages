<?php

use andrewdanilov\custompages\common\models\Category;
use andrewdanilov\custompages\common\models\Page;
use yii\db\Migration;
use yii\db\Query;

/**
 * Class m221211_083551_custom_pages_move_source_field_to_custom_fields
 */
class m221211_083551_custom_pages_move_source_field_to_custom_fields extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // Checking if filled 'source' field exists
        $pages = Page::find()->select(['source', 'id', 'category_id', 'fields_data'])->where(['not', ['source' => '']])->asArray()->all();
        // Categories needs to be modified
        $categories = [];
        // Modified categories
        $modified_categories = [];
        if ($pages) {
            foreach ($pages as $page) {
                if ($page['source']) {
                    // Moving 'source' field to 'fields_data'
                    $fields_data = json_decode($page['fields_data'], true);
                    $fields_data['source'] = $page['source'];
                    (new Query())->createCommand()->update('{{%page}}', [
                        'fields_data' => json_encode($fields_data),
                    ], [
                        'id' => $page['id'],
                    ])->execute();
                    // Collecting categories needs to be modified
                    $categories[$page['category_id']] = $page['category_id'];
                }
            }
            // Modifying categories
            foreach ($categories as $category_id) {
                if ($category_id) {
                    $category = Category::find()
                        ->select(['id', 'pages_fields'])
                        ->where(['id' => $category_id])
                        ->asArray()
                        ->one();
                    if ($category) {
                        $pages_fields = json_decode($category['pages_fields'], true);
                        $pages_fields[] = [
                            'name' => 'source',
                            'type' => 'string',
                            'label' => 'Source',
                        ];
                        $result = (new Query())->createCommand()->update('{{%page_category}}', [
                            'pages_fields' => json_encode($pages_fields),
                        ], [
                            'id' => $category['id'],
                        ])->execute();
                        if ($result) {
                            $modified_categories[] = $category['id'];
                        }
                    }
                }
            }
        }
        // Now we can remove field 'source' only if there is no not modified categories that needs to be modified.
        // For i.e. it can be 0 category (root category), if there are pages with no category assigned. Or pages with not existed category.
        if (!array_diff($categories, $modified_categories)) {
            $this->dropColumn('{{%page}}', 'source');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m221211_083551_custom_pages_move_source_field_to_custom_fields cannot be reverted.\n";

        return false;
    }
}
