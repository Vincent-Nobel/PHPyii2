<?php
/**
 * Created by PhpStorm.
 * User: 22121
 * Date: 2017/7/18
 * Time: 17:05
 */
$form=\yii\bootstrap\ActiveForm::begin();
echo $form->field($model,'name');
echo $form->field($model,'intro')->textarea();
echo $form->field($model,'imgFile')->fileInput();
echo $form->field($model,'sort');
echo $form->field($model,'status')->inline()->radioList(\backend\models\Brand::getBrandState());
echo \yii\bootstrap\Html::submitButton('确定',['class'=>'btn btn-info btn-sm']);
\yii\bootstrap\ActiveForm::end();