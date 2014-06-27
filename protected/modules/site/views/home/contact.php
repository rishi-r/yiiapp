<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Contact Us';
$this->breadcrumbs=array(
	'Contact',
);
?>

<section class="inner-top-bar">
<section class="container">
<h2 class="in-head">data</h2>
</section>
</section>
<section class="container">
	<section id="s1" class="row in-secion">
    	<h2 class="title">Contact us</h2>
    	<article class="col-md-12">
        	<p class="txtBI">Please select an option below based on your need and click the submit
        button. For data <a href="mailto:ex@example.com">ex@example.com</a> or call us at 
        <span class="bold">
            978787787887
        </span></p>
            
            
        </article>
        
        <div class="clearfix"></div>
    </section>
    <section id="s2" class="row">
    <div class="col-md-6">
    <h3>Addresses</h3>
        <div class="map clear">
        <div class="col-md-7">
        </div>
        <div class="col-md-5">
        <h3 id="#sanfran">
            Office Address
        </h3>
        <p>
            #1340 sadsa .
            <br>
            f dsafdsf dsfsdf
            <br>
            d sfdasf dsaf ds
            <br>
            df dsaf sdafdsf
            <br>
            <a href="mailto:ex@example.com">ex@example.com</a>
        </p>
        </div>
        <div class="clearfix"></div>
    </div>  
   </div>
    
<?php if(Yii::app()->user->hasFlash('contact')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('contact'); ?>
</div>

<?php endif;?>

<div class="col-md-6 form_sec">
<h3>Contact Form</h3>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contact-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php //echo $form->errorSummary($model); ?>

	<div class="input_sec">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('placeholder'=>'First Name')); ?>
		<?php echo $form->error($model,'name',array('class'=>'alert alert-danger')); ?>
	</div>

	<div class="input_sec">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('placeholder'=>'Email')); ?>
		<?php echo $form->error($model,'email',array('class'=>'alert alert-danger')); ?>
	</div>

	<div class="input_sec">
		<?php echo $form->labelEx($model,'subject'); ?>
		<?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>128,'placeholder'=>'Subject')); ?>
		<?php echo $form->error($model,'subject',array('class'=>'alert alert-danger')); ?>
	</div>

	<div class="input_sec">
		<?php echo $form->labelEx($model,'body'); ?>
		<?php echo $form->textArea($model,'body',array('placeholder'=>'Your Comments')); ?>
		<?php echo $form->error($model,'body',array('class'=>'alert alert-danger')); ?>
	</div>

	<?php if(CCaptcha::checkRequirements()): ?>
	<div class="input_sec">
		<?php echo $form->labelEx($model,'verifyCode'); ?>
		<div class="captchaimg">
		<?php $this->widget('CCaptcha'); ?>
		<?php echo $form->textField($model,'verifyCode',array('class'=>'capthacls')); ?>
		</div>
		<div class="hint">Please enter the letters as they are shown in the image above.
		<br/>Letters are not case-sensitive.</div>
                <?php echo $form->error($model,'verifyCode',array('class'=>'alert alert-danger')); ?>
                                    
	</div>
	<?php endif; ?>

	<div class="input_sec">
		<?php echo CHtml::submitButton('Submit',array('class'=>'btn btn-success')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
</div>
</section>
</section>
