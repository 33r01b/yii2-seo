<?php
namespace zeroonbeatz\seo;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use zeroonebeatz\SeoText;

class SeoBehavior extends Behavior
{
    private $_model;

    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_INSERT => 'afterInsert',
            ActiveRecord::EVENT_AFTER_UPDATE => 'afterUpdate',
            ActiveRecord::EVENT_AFTER_DELETE => 'afterDelete',
        ];
    }

    public function afterInsert()
    {
        if($this->seoText->load(Yii::$app->request->post())){
            if(!$this->seoText->isEmpty()){
                $this->seoText->save();
            }
        }
    }

    public function afterUpdate()
    {
        if($this->seoText->load(Yii::$app->request->post())){
            if(!$this->seoText->isEmpty()){
                $this->seoText->save();
            } else {
                if($this->seoText->primaryKey){
                    $this->seoText->delete();
                }
            }
        }
    }

    public function afterDelete()
    {
        if(!$this->seoText->isNewRecord){
            $this->seoText->delete();
        }
    }

    public function getSeo()
    {
        return $this->owner->hasOne(SeoText::className(), ['item_id' => $this->owner->primaryKey()[0]])->where(['table_name' => $this->owner->tableName()]);
    }

    public function getSeoText()
    {
        if(!$this->_model)
        {
            $this->_model = $this->owner->seo;
            if(!$this->_model){
                $this->_model = new SeoText([
                    'table_name' => $this->owner->tableName(),
                    'item_id' => $this->owner->primaryKey
                ]);
            }
        }

        return $this->_model;
    }
}
