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
    <?php if($user_connected['role_id'] != 2 || ($auths[30] || $auths[31])) : ?>
    <div class="col-md-4">
        <div class="panel panel-info">
            <div class="panel-heading">
                Maternity Reminders
                </div>
            <div class="panel-body" style="height:300px;overflow-y:scroll">
                    <?php foreach($newborns as $newborn) : ?>
                        <div class="row">
                            <div class="col-xs-8">
                                <p style="color:black"><span class="fa fa-user" style="margin-right:12px"></span> <?= $newborn->policy->customer->name ?></p>
                                <p style="color:black"><span class="fa fa-hashtag" style="margin-right:8px"></span> <?= "Policy : " . $newborn->policy->policy_number ?></p>
                                <p style="color:black;margin-top:10px"><span class="fa fa-bank" style="margin-right:8px"></span> <?= $newborn->policy->company->name . " / ".  $newborn->policy->option->name ?></p>
                                <p style="color:black;margin-top:10px"><span class="fa fa-calendar" style="margin-right:11px"></span> <strong>Due Date :</strong> <?= date("M d Y", strtotime($newborn->due_date)) ?></p>
                            </div>
                            <div class="col-xs-4" class="text-right">
                                <?php if($user_connected['role_id'] != 2 || ($auths[31])) : ?>
                                <button class="btn btn-success" data-toggle="modal" data-target="#confirm_maternity_<?= $newborn->id ?>" style="float:right;margin-top:40px"><span class="fa fa-check"></span></button>
                            <?php endif; ?>
                            </div>
                        </div>
                        <hr>
                <?php endforeach; ?>
            </div>
        </div>
    </div> 
<?php endif; ?>
    <div class="col-md-4">
        <div class="panel panel-warning">
            <div class="panel-heading">
                Birthdays
                </div>
            <div class="panel-body" style="height:300px;overflow-y:scroll">
                    <?php foreach($birthdays as $birthday) : ?>
                        <div class="row">
                            <div class="col-xs-12">
                                <p style="color:black"><span class="fa fa-user" style="margin-right:13px"></span> <?= $birthday->name ?></p>
                                <p style="color:black;margin-top:10px"><span class="fa fa-calendar" style="margin-right:10px"></span> <?= date('M d Y', strtotime($birthday->dob)) ?></p>
                                <p style="color:black;margin-top:10px"><span class="fa fa-phone" style="margin-right:13px"></span> <?= $birthday->home_phone ?></p>
                            </div>
                        </div>
                        <hr>
                <?php endforeach; ?>
            </div>
        </div>
    </div> 
    <?php if($user_connected['role_id'] != 2 || ($auths[52] || $auths[53] || $auths[55])) : ?>
    <div class="col-md-4">
        <div class="panel panel-teal">
            <div class="panel-heading">
                Open CLaims
                </div>
            <div class="panel-body" style="height:300px;overflow-y:scroll;background:white">
                    <?php foreach($claims as $claim) : ?>
                    <div class="row">
                            <div class="col-xs-8">
                                <p style="color:black"><span class="fa fa-user" style="margin-right:12px"></span> <?= $claim->policy->customer->name . " - " . $claim->policy->policy_number ?></p>
                            </div>
                            <div class="col-xs-4" class="text-right">
                                <a class="btn btn-info" target="_blank" href="<?= ROOT_DIREC ?>/claims/view/<?= $claim->id ?>" style="float:right"><span class="fa fa-eye"></span></a>
                            </div>
                        </div>
                        <hr>
                <?php endforeach; ?>

            </div>
        </div>
    </div> 
<?php endif; ?>
    
</div>

 <?php if($user_connected['role_id'] != 2 || ($auths[23] || $auths[24])) : ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default articles" >
            <div class="panel-heading">
                New Policies
            </div>
            <div class="panel-body articles-container" style="max-height:500px;overflow-y:scroll">       
    <table class="table table-striped datatable">
                <thead> 
                    <th class="text-left">Number</th>
                    <th class="text-center">Holder</th>
                    <th class="text-center">Country</th>
                    <th class="text-center">Company</th>
                    <th class="text-center">Premium</th>

                    <th class="text-center">Mode</th>
                    <th class="text-right">Effective Date</th>
                </thead>
            <tbody> 
        <?php foreach($newBusiness as $policy) : ?>
            <tr>
                <td class="text-left"><a href="<?= ROOT_DIREC ?>/policies/view/<?= $policy->id ?>"><?= $policy->policy_number ?></a></td>
                <td class="text-center"><?= $policy->customer->name ?></td>
                <td class="text-center"><?= substr($policy->customer->country->name, 0, 5) ?></td>
                <?php if(!empty($policy->company)) : ?>
                    <?php if(!empty($policy->option)) : ?>
                    <td class="text-center"><?= $policy->company->name . " / ".  $policy->option->name ?></td>
                    <?php else : ?>
                        <td class="text-center"><?= $policy->company->name ?></td>
                    <?php endif; ?>
                <?php else : ?>
                    <?php if(!empty($policy->option)) : ?>
                    <td class="text-center"><?= $policy->option->name ?></td>
                    <?php else : ?>
                        <td class="text-center"></td>
                    <?php endif; ?>
                <?php endif; ?>
                
                <td class="text-center"><?= number_format($policy->premium,2,".",",") ?></td>
                <td class="text-center"><?= $modes[$policy->mode] ?></td>
            
                <td class="text-right">
                    <?= date("M d Y", strtotime($policy->effective_date)) ?>
                </td>

            </tr>
        <?php endforeach; ?>
        </tbody>
        </table>
            </div>
            
        </div>
    </div> 
 
</div> 
<?php endif; ?>

 <?php if($user_connected['role_id'] != 2 || ($auths[27] || $auths[28])) : ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default articles" >
            <div class="panel-heading">
                Pending New Business
            </div>
            <div class="panel-body articles-container" style="max-height:300px;overflow-y:scroll">       
<table class="table table-striped datatable">
                <thead> 
                    <th class="text-left">Name</th>
                    <th class="text-center">Company / Option</th>
                    <th class="text-center">Country</th>
                    <th class="text-center">Dependants</th>
                    <th class="text-center">Last Contact Date</th>
                     <?php if($user_connected['role_id'] != 2 || ($auths[28])) : ?>
                    <th class="text-right">Action(s)</th>
                <?php endif; ?>
                </thead>
            <tbody> 
        <?php foreach($pendings as $pending) : ?>
          <?php if($pending->country_id == $filter_country || empty($filter_country)) : ?>
            <tr>
                <td class="text-left"><?= $pending->name ?></td>
                <td class="text-center"><?= $pending->company->name. " / ".$pending->option->name ?></td>
                <td class="text-center"><?= $pending->country->name ?></td>
                <td class="text-center"><?= $pending->dependants ?></td>
                <?php if(!empty($pending->last_contact_date)) : ?>
                <td class="text-center"><?= date("M d Y", strtotime($pending->last_contact_date)) ?></td> 
                <?php else : ?>
                    <td></td>
                <?php endif; ?>
                 <?php if($user_connected['role_id'] != 2 || ($auths[28])) : ?>
                <td class="text-right"><button class="btn btn-success" data-toggle="modal" data-target="#confirm_pending_<?= $pending->id ?>"><span class="fa fa-check"></span></button></td>
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
<?php endif; ?>

 <?php if($user_connected['role_id'] != 2 || ($auths[40] || $auths[42] || $auths[36] || $auths[38])) : ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default articles">
            <div class="panel-heading">
                CGR - Awaiting Transactions
            </div>
            <div class="panel-body articles-container" style="max-height:300px;overflow-y:scroll">       
<table class="table table-striped datatable">
                <thead> 
                    <th class="text-left">Renewal #</th>
                    <th class="text-center">Corporate Group</th>
                    <th class="text-center">Group</th>
                    <th class="text-center">Employee</th>
                    <th class="text-center">Family Member</th>
                    <th class="text-center">Created</th>
                    <th class="text-right">Action(s)</th>
                </thead>
            <tbody> 
                <?php foreach($transactions as $transaction) : ?>
                    <td><a target="_blank" href="<?= ROOT_DIREC ?>/renewals/view/<?= $transaction->renewal_id ?>"><?= $transaction->renewal->renewal_number ?></a></td>
                    <td class="text-center"><?= $transaction->renewal->business->name ?></td>
                    <td class="text-center"><?= $transaction->grouping->grouping_number ?></td>
                    <td class="text-center"><?= $transaction->employee->first_name." ".$transaction->employee->last_name ?></td>
                    <td class="text-center"><?= $transaction->family->first_name." ".$transaction->family->last_name ?></td>
                    <td class="text-center"><?= date("M d Y", strtotime($transaction->created)) ?></td>
                    <td class="text-right"><button class="btn btn-success" data-toggle="modal" data-target="#confirm_transaction_<?= $transaction->id ?>"><span class="fa fa-check"></span></button></td>
                <?php endforeach; ?>
        </tbody>
        </table>
            </div>
            
        </div>
    </div> 
 
</div> 

<?php endif; ?>

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


<?php if($pendings->count() > 0) : ?>
<?php foreach($pendings as $pending) : ?>
    <div class="modal fade" id="confirm_pending_<?= $pending->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update PNB for <?= $pending->name ?></h5>
      </div>
      <?= $this->Form->create(null, array("url" => "/pendings/update")) ?>
      <?= $this->Form->input('pending_id', array('type' => 'hidden', "value" => $pending->id)); ?>
      <div class="modal-body">
            <div class="row">
            <div class="col-md-6">
                <?= $this->Form->control('status', array('class' => 'form-control', "label" => "Status *", "empty" => "-- Choose --", "options" => array(1=> "Pending", 2 => "Canceled", 3 => "Confirmed"), 'value' => $pending->status)); ?>
            </div> 
            <div class="col-md-6"><?= $this->Form->control('last_contact_date', array('class' => 'form-control', "label" => "Last Contact Date", "type" => "Date", "value" => $pending->last_contact_date, 'required' => true, 'style' => "height:46px")); ?></div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success">Update</button>
      </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>
<?php endforeach; ?>
<?php  endif; ?>



<?php foreach($newborns as $newborn) : ?>
    <div class="modal fade" id="confirm_maternity_<?= $newborn->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <?= $this->Form->create(null, array("url" => "/policies/adddependant")) ?>
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
            Add Dependant for <?= $newborn->policy->customer->name ?>
        </h5>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->control('policy_id', array('type' => 'hidden', "value" => $newborn->policy->id)); ?>
                <?= $this->Form->control('newborn_id', array('type' => 'hidden', "value" => $newborn->id)); ?>
                <?= $this->Form->control('name', array('class' => 'form-control', "label" => "Name *", "placeholder" => "Name")); ?>
                <hr>
                <?= $this->Form->control('sexe', array('class' => 'form-control', "label" => "Sexe *", "empty" => "-- Choose --", 'options' => $sexe)); ?>
                <hr>
                <?= $this->Form->control('relation', array('class' => 'form-control', "label" => "Relation *", "empty" => "-- Choose --", 'options' => $relations)); ?>
                <hr>
                <?= $this->Form->control('dob', array('class' => 'form-control', "type" => "date", "label" => "DOB *")); ?>
                <hr>
                <?= $this->Form->control('limitations', array('class' => 'form-control', "label" => "Exclusions", "placeholder" => "Exclusions / Limitations")); ?>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">CANCEL</button>
        <button type="submit" class="btn btn-success">ADD</button>
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

    @media only screen and (max-width: 600px) {
      .panel-heading{
        font-weight: bold;
        font-size: 18px;
      }
    }
</style>