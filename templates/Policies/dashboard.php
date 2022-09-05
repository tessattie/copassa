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
<?php if($plan_type == 1) : ?>
<div class="row">
    <?php if($user_connected['role_id'] != 2 || ($auths[30] || $auths[31])) : ?>
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Maternity Reminders
                </div>
            <div class="panel-body" style="height:300px;overflow-y:scroll">
                    <?php foreach($newborns as $newborn) : ?>
                        <div class="row">
                            <div class="col-xs-8">
                                <p style="color:black"><span class="fa fa-user" style="margin-right:12px"></span> <?= h($newborn->policy->customer->name) ?></p>
                                <p style="color:black"><span class="fa fa-hashtag" style="margin-right:8px"></span> <?= h("Policy : " . $newborn->policy->policy_number) ?></p>
                                <p style="color:black;margin-top:10px"><span class="fa fa-bank" style="margin-right:8px"></span> <?= h($newborn->policy->company->name . " / ".  $newborn->policy->option->name) ?></p>
                                <p style="color:black;margin-top:10px"><span class="fa fa-calendar" style="margin-right:11px"></span> <strong>Due Date :</strong> <?= h(date("M d Y", strtotime($newborn->due_date))) ?></p>
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
    <div class="col-md-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                Birthdays
                </div>
            <div class="panel-body" style="height:300px;overflow-y:scroll">
                    <?php foreach($birthdays as $birthday) : ?>
                        <div class="row">
                            <div class="col-xs-12">
                                <p style="color:black"><span class="fa fa-user" style="margin-right:13px"></span> <?= h($birthday->name) ?></p>
                                <p style="color:black;margin-top:10px"><span class="fa fa-calendar" style="margin-right:10px"></span> <?= h(date('M d Y', strtotime($birthday->dob))) ?></p>
                                <p style="color:black;margin-top:10px"><span class="fa fa-phone" style="margin-right:13px"></span> <?= h($birthday->cell_area_code."-".$birthday->cell_phone) ?></p>
                            </div>
                        </div>
                        <hr>
                <?php endforeach; ?>
            </div>
        </div>
    </div> 
</div>
<?php else : ?>
    <div class="row">
    <?php if($user_connected['role_id'] != 2 || ($auths[30] || $auths[31])) : ?>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                Maternity Reminders
                </div>
            <div class="panel-body" style="height:300px;overflow-y:scroll">
                    <?php foreach($newborns as $newborn) : ?>
                        <div class="row">
                            <div class="col-xs-8">
                                <p style="color:black"><span class="fa fa-user" style="margin-right:12px"></span> <?= h($newborn->policy->customer->name) ?></p>
                                <p style="color:black"><span class="fa fa-hashtag" style="margin-right:8px"></span> <?= h("Policy : " . $newborn->policy->policy_number) ?></p>
                                <p style="color:black;margin-top:10px"><span class="fa fa-bank" style="margin-right:8px"></span> <?= h($newborn->policy->company->name . " / ".  $newborn->policy->option->name) ?></p>
                                <p style="color:black;margin-top:10px"><span class="fa fa-calendar" style="margin-right:11px"></span> <strong>Due Date :</strong> <?= h(date("M d Y", strtotime($newborn->due_date))) ?></p>
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
        <div class="panel panel-default">
            <div class="panel-heading">
                Birthdays
                </div>
            <div class="panel-body" style="height:300px;overflow-y:scroll">
                    <?php foreach($birthdays as $birthday) : ?>
                        <div class="row">
                            <div class="col-xs-12">
                                <p style="color:black"><span class="fa fa-user" style="margin-right:13px"></span> <?= h($birthday->name) ?></p>
                                <p style="color:black;margin-top:10px"><span class="fa fa-calendar" style="margin-right:10px"></span> <?= h(date('M d Y', strtotime($birthday->dob))) ?></p>
                                <p style="color:black;margin-top:10px"><span class="fa fa-phone" style="margin-right:13px"></span> <?= h($birthday->cell_area_code."-".$birthday->cell_phone) ?></p>
                            </div>
                        </div>
                        <hr>
                <?php endforeach; ?>
            </div>
        </div>
    </div> 
    <?php if($user_connected['role_id'] != 2 || ($auths[52] || $auths[53] || $auths[55])) : ?>
    <div class="col-md-4">
        <div class="panel panel-default">
            <div class="panel-heading">
                Open CLaims
                </div>
            <div class="panel-body" style="height:300px;overflow-y:scroll;background:white">
                    <?php foreach($claims as $claim) : ?>
                    <div class="row">
                            <div class="col-xs-8">
                                <p style="color:black"><span class="fa fa-user" style="margin-right:12px"></span> <?= h($claim->policy->customer->name . " - " . $claim->policy->policy_number) ?></p>
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
                <td class="text-left"><?= h($pending->name) ?></td>
                <td class="text-center"><?= h($pending->company->name. " / ".$pending->option->name) ?></td>
                <td class="text-center"><?= h($pending->country->name) ?></td>
                <td class="text-center"><?= h($pending->dependants) ?></td>
                <?php if(!empty($pending->last_contact_date)) : ?>
                <td class="text-center"><?= h(date("M d Y", strtotime($pending->last_contact_date))) ?></td> 
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


 <?php if($user_connected['role_id'] != 2 || ($auths[24] || $auths[23])) : ?>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default articles">
            <div class="panel-heading">
                Notes
                <button data-toggle="modal" data-target="#exampleModal" type="button" class="btn btn-default" style="float:right;padding:1px 10px 5px"><span class="fa fa-plus"></span></button>
            </div>
            <div class="panel-body articles-container" style="max-height:300px;overflow-y:scroll">
                <div class="row">
                    <?php foreach($notes as $note) : ?>
                        <div class="col-md-3 col-sm-6">
                            <div class="card" style="border:1px solid #ddd;border-radius:5px;padding:10px;height:200px;margin-bottom:30px">
                              <div class="card-body">
                                <h5 class="card-title"><?= h($note->customer->name) ?></h5>
                                <h6 class="card-subtitle mb-2 text-muted"><?= h($note->created) ?></h6>
                                <h6 class="card-subtitle mb-2 text-muted">Created By : <?= h($note->user->name) ?></h6>
                                <p class="card-text"><?= h($note->comment) ?></p>
                                <a target="_blank" href="<?= ROOT_DIREC ?>/customers/view/<?= $note->customer_id ?>" class="btn btn-warning" style="position:absolute;bottom:45px;right:35px">Read More</a>
                              </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div> 
            </div>
        </div>
        </div>
    </div>
<?php endif; ?>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <?= $this->Form->create(null, array("url" => "/notes/add")) ?>
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">New Note</h3>
      </div>
      <div class="modal-body">
        <?= $this->Form->control('customer_id', array('type' => 'hidden', "value" => $customer->id)); ?>
        <div class="row">
            <div class="col-md-12"><?= $this->Form->control('customer_id', array('class' => 'form-control', "label" => "Policy Holder *", "empty" => "-- Choose --", "options" => $customers, 'required' => true)); ?>
                        </div></div>
                        <hr>
                        <div class="row">
            <div class="col-md-12">
                <?= $this->Form->control('comment', array('class' => 'form-control', "label" => false, "placeholder" => "Write a note here...")); ?>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">CLOSE</button>
        <button type="submit" class="btn btn-success">ADD</button>
      </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>
<?php if($plan_type == 4) : ?>
 <?php if($user_connected['role_id'] != 2 || ($auths[40] || $auths[42] || $auths[36] || $auths[38])) : ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default articles">
            <div class="panel-heading">
               Pending Miscellaneous Payments
            </div>
            <div class="panel-body articles-container" style="max-height:300px;overflow-y:scroll">       
<table class="table table-striped datatable">
                <thead> 
                    <th class="text-left">Renewal #</th>
                    <th class="text-center">Corporate Group</th>
                    <th class="text-center">Group</th>
                    <th class="text-center">Employee</th>
                    <th class="text-center">Family Member</th>
                    <th class="text-center">Date</th>
                    <th class="text-right">Action(s)</th>
                </thead>
            <tbody> 
                <?php foreach($transactions as $transaction) : ?><tr>
                    <td><a target="_blank" href="<?= ROOT_DIREC ?>/renewals/view/<?= $transaction->renewal_id ?>"><?= h($transaction->renewal->renewal_number) ?></a></td>
                    <td class="text-center"><?= h($transaction->renewal->business->name) ?></td>
                    <td class="text-center"><?= h($transaction->grouping->grouping_number) ?></td>
                    <td class="text-center"><?= h($transaction->employee->first_name." ".$transaction->employee->last_name) ?></td>
                    <td class="text-center"><?= h($transaction->family->first_name." ".$transaction->family->last_name) ?></td>
                    <td class="text-center"><?= h(date("M d Y", strtotime($transaction->created))) ?></td>
                    <td class="text-right"><button class="btn btn-success" data-toggle="modal" data-target="#confirm_transaction_<?= $transaction->id ?>"><span class="fa fa-check"></span></button></td></tr>
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
        <h5 class="modal-title" id="exampleModalLabel">Confirm Transaction for <?= h($transaction->employee->first_name." ".$transaction->employee->last_name) ?></h5>
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
<?php endif; ?>

<?php if($pendings->count() > 0) : ?>
<?php foreach($pendings as $pending) : ?>
    <div class="modal fade" id="confirm_pending_<?= $pending->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Update PNB for <?= h($pending->name) ?></h5>
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
            Add Dependant for <?= h($newborn->policy->customer->name) ?>
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