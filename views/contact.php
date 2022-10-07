<?php
/** @var $this \app\core\View */
/** @var $model \app\models\ContactForm */

$this->title = 'Contact';
?>
<h1> Contact us</h1>
<?php $form = \app\core\form\Form::begin('', 'post') ?>
<?= $form->field($model, 'subject')?>
<?= $form->field($model, 'email') ?>
<?= new \app\core\form\TextareaField($model, 'body') ?>
<button type="submit" class="btn btn-primary">Submit</button>
<?php \app\core\form\Form::end() ?>
