<?php

/** @var yii\web\View $this */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<section class="add-result ar">
<?php $form = ActiveForm::begin(['id' => 'form-order-article form', 'class' => 'forms', 'enableClientValidation' => true, 'enableAjaxValidation' => false,

'action' => ['/site/addres'],

'options' => ['enctype' => 'multipart/form-data']]); ?>
    <div class="msgContainer"></div>
    <?= $form->field($model, 'party_abbreviation') -> input('text') ?>
    <?= $form->field($model, 'party_score') -> input('number') ?>
    <?= $form->field($model, 'entered_by_user') -> input('text') ?>
    <?= $form->field($model, 'date_entered') -> input('datetime-local') ?>
    <?= $form->field($model, 'user_ip_address') -> input('text') ?>

    <div class="form-group">
        <?= Html::submitButton('Add Result', ['class' => 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>
</section>

<script>
    window.onload = function(){
        $('form').on('beforeSubmit', function(e) {

        var form = $(this);

        var formData = form.serialize();

        $.ajax({
            url: form.attr("action"),
            type: form.attr("method"),
            data: formData,
            success: function (data) {
                $('.msgContainer').html(`<p class="msg green">
                    Data Added Successfully.
                </p>`)
                setTimeout(() => {
                    $('.msgContainer').empty();  
                }, 3500);
                $('form')[0].reset();
            },
            error: function (err) {
                $('.msgContainer').html(`<p class="msg red">
                    Failed To Add Data.
                </p>`)
                setTimeout(() => {
                    $('.msgContainer').empty();  
                }, 3000);
            }

        });

        }).on('submit', function(e){

        e.preventDefault();

        });
    }
</script>