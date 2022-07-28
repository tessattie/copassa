<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ClaimsType $claimsType
 */
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/claims">
            Claim Details
        </a></li>
        <li>Edit</li>
        <li class="active"><?= $claimsType->title ?></li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Edit Claim Detail : <?= $claimsType->title ?>
            <a class="btn btn-info" style="float:right" href="<?= ROOT_DIREC ?>/claims/view/<?= $claimsType->claim_id ?>"><em class="fa fa-arrow-left"></em></a>
        </div>
    <div class="panel-body articles-container">       
            <?= $this->Form->create($claimsType, array('type' => 'file')) ?>
                <div class="row">
                <div class="col-md-12"><?= $this->Form->control('title', array('class' => 'form-control', "label" => "Title / Service *", "placeholder" => "Title")); ?></div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12"><?= $this->Form->control('description', array('class' => 'form-control', "label" => "Description / Contact Information *", "placeholder" => "Description")); ?></div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6"><?= $this->Form->control('type_id', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $claims_types, "label" => "Type", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?></div> 
                <div class="col-md-6">
                  <div class="form-group">
                    <label for="exampleInputFile">Attachment<?php if(!empty($claimsType->attachment)) : ?>
                                <small class="text-center"><?= $this->Html->link(' (View Current)', '/img/claims/'.$claimsType->attachment ,array('download'=> $claimsType->attachment)); ?></small>
                            <?php else : ?>
                                <small class="text-center"></small>
                            <?php endif; ?></label>
                    <input type="file" id="exampleInputFile" name="attachment">
                    <p class="help-block">Upload Attachment here.</p>
                  </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-6"><?= $this->Form->control('amount', array('class' => 'form-control', "label" => "Amount *", "placeholder" => "Amount")); ?></div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-4"><?= $this->Form->control('received_date', array('class' => 'form-control', "type" => "date", "label" => "Date Received", 'value' => date("Y-m-d"))); ?>
                    </div>
                    <div class="col-md-4"><?= $this->Form->control('service_date', array('class' => 'form-control', "type" => "date", "label" => "Date of Service")); ?>
                    </div>
                    <div class="col-md-4"><?= $this->Form->control('processed_date', array('class' => 'form-control', "type" => "date", "label" => "Date Processed")); ?>
                    </div>
            </div>
            <div class="row">
                    <div class="col-md-12"><?= $this->Form->button(__('Update'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
                </div>  


            <?= $this->Form->end() ?>
        </div>
        
    </div>
</div><!--End .articles-->




