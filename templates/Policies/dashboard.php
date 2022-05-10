<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li>
            Dashboard
        </li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid">   
<div class="row">
    <div class="col-md-6">
        <div class="panel panel-default articles" style="height:300px;overflow-y:scroll">
            <div class="panel-heading">
                Maternity Reminders
            </div>
            <div class="panel-body articles-container">       
                <table class="table table-striped table-bordered">
                <thead> 
                    <th class="text-left">Policy Number</th>
                    <th class="text-center">Policy Holder</th>
                    <th class="text-center">Company</th>
                    <th class="text-center">Due Date</th>
                </thead>
            <tbody> 
        <?php foreach($newborns as $newborn) : ?>
            <tr>
                <td class="text-left"><a href="<?= ROOT_DIREC ?>/policies/view/<?= $newborn->policy->id ?>"><?= $newborn->policy->policy_number ?></a></td>
                <td class="text-center"><?= $newborn->policy->customer->name ?></td>
                <td class="text-center"><?= $newborn->policy->company->name . " / ".  $newborn->policy->option->name ?></td>
                <td class="text-center"><?= date("M d Y", strtotime($newborn->due_date)) ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
            </div>
            
        </div>
    </div> 

    <div class="col-md-6">
        <div class="panel panel-default articles" style="height:300px;overflow-y:scroll">
            <div class="panel-heading">
                Birthdays
            </div>
            <div class="panel-body articles-container">       
                <table class="table table-striped table-bordered">
                <thead> 
                    <th class="text-left">Policy Holder</th>
                    <th class="text-center">DOB</th>
                    <th class="text-center">Phone</th>
                </thead>
            <tbody> 
        <?php foreach($birthdays as $birthday) : ?>
            <tr>
                <td class="text-left"><?= $birthday->name ?></td>
                <td class="text-center"><?= date('M d Y', strtotime($birthday->dob)) ?></td>
                <td class="text-center"><?= $birthday->home_phone ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
            </div>
            
        </div>
    </div> 
    
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default articles" style="height:300px;overflow-y:scroll">
            <div class="panel-heading">
                Pending New Business
            </div>
            <div class="panel-body articles-container">       
<table class="table table-striped table-bordered">
                <thead> 
                    <th class="text-left">Name</th>
                    <th class="text-center">Company</th>
                    <th class="text-center">Option</th>
                    <th class="text-center">Country</th>
                    <th class="text-center">Dependants</th>
                    <th class="text-center">Last Contact Date</th>
                </thead>
            <tbody> 
        <?php foreach($pendings as $pending) : ?>
          <?php if($pending->country_id == $filter_country || empty($filter_country)) : ?>
            <tr>
                <td class="text-left"><?= $pending->name ?></td>
                <td class="text-center"><?= $pending->company->name ?></td>
                <td class="text-center"><?= $pending->option->name ?></td>
                <td class="text-center"><?= $pending->country->name ?></td>
                <td class="text-center"><?= $pending->dependants ?></td>
                <?php if(!empty($pending->last_contact_date)) : ?>
                <td class="text-center"><?= date("M d Y", strtotime($pending->last_contact_date)) ?></td> 
                <?php else : ?>
                    <td></td>
                <?php endif; ?>
            </tr>
          <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
        </table>
            </div>
            
        </div>
    </div> 
 
</div> 


<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default articles" style="height:300px;overflow-y:scroll">
            <div class="panel-heading">
                Corporate Groups Renewals - Awaiting Transactions
            </div>
            <div class="panel-body articles-container">       
<table class="table table-striped table-bordered">
                <thead> 
                    <th class="text-left">Renewal #</th>
                    <th class="text-center">Corporate Group</th>
                    <th class="text-center">Group</th>
                    <th class="text-center">Employee</th>
                    <th class="text-center">Family Member</th>
                    <th class="text-center">Created</th>
                    <th class="text-center">Action(s)</th>
                </thead>
            <tbody> 
                <?php foreach($transactions as $transaction) : ?>
                    <td><a target="_blank" href="<?= ROOT_DIREC ?>/renewals/view/<?= $transaction->renewal_id ?>"><?= $transaction->renewal->renewal_number ?></a></td>
                    <td class="text-center"><?= $transaction->renewal->business->name ?></td>
                    <td class="text-center"><?= $transaction->grouping->grouping_number ?></td>
                    <td class="text-center"><?= $transaction->employee->first_name." ".$transaction->employee->last_name ?></td>
                    <td class="text-center"><?= $transaction->family->first_name." ".$transaction->family->last_name ?></td>
                    <td class="text-center"><?= date("M d Y", strtotime($transaction->created)) ?></td>
                    <td class="text-center"><button class="btn btn-success" data-toggle="modal" data-target="#confirm_transaction_<?= $transaction->id ?>">Confirm</button></td>
                <?php endforeach; ?>
        </tbody>
        </table>
            </div>
            
        </div>
    </div> 
 
</div> 

</div><!--End .articles-->


<?php foreach($transactions as $transaction) : ?>
    <div class="modal fade" id="confirm_transaction_<?= $transaction->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirm Transaction for <?= $transaction->employee->first_name." ".$transaction->employee->last_name ?></h5>
      </div>
      <?= $this->Form->create(null, array("url" => "/renewals/confirmtransaction")) ?>
      <?= $this->Form->input('transaction_id', array('type' => 'hidden', "value" => $transaction->id)); ?>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-6"><?= $this->Form->control('credit', array('class' => 'form-control', "label" => "Credit", 'placeholder' => "Amount", 'value' => $transaction->credit)); ?></div> 
            <div class="col-md-6"><?= $this->Form->control('debit', array('class' => 'form-control', "label" => "Debit", 'placeholder' => "Amount", 'value' => $transaction->debit)); ?></div> 
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12"><?= $this->Form->control('memo', array('class' => 'form-control', "label" => "Memo", 'placeholder' => "Memo", 'value' => $transaction->memo)); ?></div> 
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success">Confirm</button>
      </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>
<?php endforeach; ?>

<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({

    } );
} );</script>

<style type="text/css">
    th,td{
        vertical-align: middle!important;
    }
</style>