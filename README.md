## Installing / Getting started

0. add to composer.json & update composer
```json
    "repositories": [
        ...
        {
            "type": "vcs",
            "url": "https://github.com/zeroonebeatz/yii2-seo.git"
        }
    ]
```

1. create `seotext` table

```php
public function up()
{
    $this->createTable('seotext', [
        'id' => $this->primaryKey(),
        'h1' => $this->string(128),
        'title' => $this->string(128),
        'description' => $this->string(),
        'keywords' => $this->string(),
    ]);
}

public function down()
{
    $this->dropTable('seotext');
}
```

2. set behavior on model

```php
public function behaviors()
{
    return [
        //...
        'seoBehavior' => zeroonebeatz\seo\SeoBehavior::className(),
    ];
}
```

3. add seo widget to create/update form in view

```html
<?php $form = ActiveForm::begin(); ?>
...

<?= zeroonebeatz\seo\widget\SeoForm::widget(['model' => $model]) ?>

...
<?php ActiveForm::end(); ?>
```

4. register seo in controller

```php
public function actionPage($id_slug)
{
    $model = Model::find()
      ->with('seo') // get relation
      ->where(['or', 'id=:id_slug', 'slug=:id_slug'], [':id_slug' => $id_slug])
      ->one();

    if (is_null($model)) {
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    $seo = new zeroonebeatz\seo\services\RegisterSeo($model, $this);
    $seo->register();

    return $this->render('page', ['model' => $model]);
}
```

forked from [Easyii](https://github.com/noumo/easyii)