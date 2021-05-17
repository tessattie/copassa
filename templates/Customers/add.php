<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/customers">
            Policy Holders
        </a></li>
        <li class="active">add</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            New Policy Holder
            <ul class="pull-right panel-settings panel-button-tab-right">
                <li class="dropdown"><a href="<?= ROOT_DIREC ?>/customers">
                    <em class="fa fa-arrow-left"></em>
                </a>
                    
                </li>
            </ul>
        </div>
    <div class="panel-body articles-container">       
            <?= $this->Form->create($customer) ?>
                <div class="row">
                    <div class="col-md-4"><?= $this->Form->control('name', array('class' => 'form-control', "label" => "Name *", "placeholder" => "Name")); ?>
                    </div>
                    <div class="col-md-4"><?= $this->Form->control('email', array('class' => 'form-control', "label" => "E-mail *", "placeholder" => "E-mail")); ?>
                    </div>
                    <div class="col-md-4"><?= $this->Form->control('status', array('class' => 'form-control', 'options' => $status, "label" => "Status", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <label>Home Phone</label>
                        <div class="row">
                            <div class="col-md-4" style="padding-right:0px">
                                <?= $this->Form->control('home_area_code', array('class' => 'form-control', "label" => false, "value" => "509", 'options' => $area_codes)); ?>
                            </div>
                            <div class="col-md-8">
                               <?= $this->Form->control('home_phone', array('class' => 'form-control', "label" => false, "placeholder" => "Phone")); ?> 
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-md-4">
                        <label>Cell Phone</label>
                        <div class="row">
                            <div class="col-md-4" style="padding-right:0px">
                                <?= $this->Form->control('cell_area_code', array('class' => 'form-control', "label" => false, "value" => "509", 'options' => $area_codes)); ?>
                            </div>
                            <div class="col-md-8">
                               <?= $this->Form->control('cell_phone', array('class' => 'form-control', "label" => false, "placeholder" => "Phone")); ?> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>Other Phone</label>
                        <div class="row">
                            <div class="col-md-4" style="padding-right:0px">
                                <?= $this->Form->control('other_area_code', array('class' => 'form-control', "label" => false, "value" => "509", 'options' => $area_codes)); ?>
                            </div>
                            <div class="col-md-8">
                               <?= $this->Form->control('other_phone', array('class' => 'form-control', "label" => false, "placeholder" => "Phone")); ?> 
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <?= $this->Form->control('address', array('class' => 'form-control', "label" => "Address *", "placeholder" => "Address")); ?>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12"><?= $this->Form->button(__('Add'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
                </div>  


            <?= $this->Form->end() ?>
        </div>
        
    </div>
</div><!--End .articles-->