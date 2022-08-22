<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Prenewal $prenewal
 */
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/policies">
            Policies
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/prenewals/index/<?= $prenewal->policy_id ?>">
            Renewals
        </a></li>
        <li class="active">Edit</li>
        <li class="active">#<?= h($prenewal->policy->policy_number) ?></li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Edit Renewal for policy #<?= h($prenewal->policy->policy_number) ?>
            <a class="btn btn-info" style="float:right" href="<?= ROOT_DIREC ?>/prenewals/index/<?= $prenewal->policy_id ?>"><em class="fa fa-arrow-left"></em></a>
        </div>
        <div class="panel-body articles-container">       
            <?= $this->Form->create($prenewal) ?>
                <div class="row">
                    <div class="col-md-6"><?= $this->Form->control('renewal_date', array("type" => "date", 'class' => 'form-control', "label" => "Renewal Date *", "placeholder" => "Renewal Date")); ?></div>
                    <div class="col-md-6"><?= $this->Form->control('status', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => array(1 => "Upcomming", 2 => "Paid", 3 => "Canceled"), "label" => "Type", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6"><?= $this->Form->control('premium', array('class' => 'form-control', "label" => "Premium", "placeholder" => "Premium")); ?></div>
                    <div class="col-md-6"><?= $this->Form->control('policy_status', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => array(0 => "Cancel next Renewals", 1 => "Continue Renewals"), "label" => "Policy Status", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6"><?= $this->Form->control('payment_date', array("type" => "date", 'class' => 'form-control', "label" => "Payment Date *", "placeholder" => "Payment Date")); ?></div>
                    <div class="col-md-6"><?= $this->Form->control('memo', array('class' => 'form-control', "label" => "Memo", 'Placeholder' => "Memo")); ?></div>
                </div>
                <div class="row">
                    <div class="col-md-12"><?= $this->Form->button(__('Update'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
                </div>  
            <?= $this->Form->end() ?>
        </div>
        
    </div>
</div><!--End .articles-->


<style type="text/css">
    @media only screen and (max-width: 600px) {
      .input label, #cell-phone, #home-phone, #other-phone, .col-md-4 label{
        margin-top: 15px;
      }

      
    }
</style>