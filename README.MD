Yii2-icon-select
================

Yii2 image\icon picker, based on [iconselect.js](https://github.com/bug7a/iconselect.js/tree/master).

##Installation

`composer require xdan/yii2-icon-select`

##Usage

```
$items = [
    "icon1.png",
    "icon2.png",
];

echo \xdan\IconSelectWidget::widget([
    'model' => $model,
    'attribute' => 'attributeName',
    'items' => $items,
    'options' => [
        //Html::activeInput() options
    ],
    'pluginOptions' => [
        // iconselect.js options
    ],
]);
```
OR

```
echo $form->field($model, 'attribute')->widget(\xdan\IconSelectWidget::className(), [
    'items' => $items,
    'pluginOptions' => [...],
]);
```