<?php
namespace zeroonbeatz\seo;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "seotext".
 *
 * @property string $h1
 * @property string $title
 * @property string $keywords
 * @property string $description
 */
class SeoText extends ActiveRecord
{
    public static function tableName()
    {
        return 'seotext';
    }

    public function rules()
    {
        return [
            [['h1', 'title', 'keywords', 'description'], 'trim'],
            [['h1', 'title'], 'string', 'max' => 128],
            [['description', 'keywords'], 'string', 'max' => 256],
        ];
    }

    public function attributeLabels()
    {
        return [
            'h1' => 'Seo H1',
            'title' => 'Seo Title',
            'keywords' => 'Seo Keywords',
            'description' => 'Seo Description',
        ];
    }

    public function isEmpty()
    {
        return (!$this->h1 && !$this->title && !$this->keywords && !$this->description);
    }
}