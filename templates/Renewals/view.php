<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Renewal $renewal
 */
$summary_due = 0;
$summary_payments = 0;
$summary_cancelations = 0;
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/Renewals">Renewals</a></li>
        <li>View</li>
        <li><?= $renewal->business->name ?></li>
        <li><?= $renewal->year ?></li>
        <a href="<?= ROOT_DIREC ?>/renewals/exportexcel/<?= $renewal->id ?>" style="float: right;background: black;color: white;padding: 4px 8px;margin-top:-5px">Excel</a>
        
    </ol>
    
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
    <!-- <div class="panel panel-default articles"> -->
        <!-- <div class="panel-body articles-container">        -->
            <ul class="nav nav-tabs">
                <?php foreach($groups as $group) : ?>
                    <li><a href="#group_<?= $group->id ?>" data-toggle="tab"><?= $group->grouping_number ?></a></li>
                <?php endforeach; ?>
                <li style="float:right" class="active"><a href="#summary" data-toggle="tab">Summary</a></li>
                <li style="float:right"><a href="#transactions" data-toggle="tab">Transactions</a></li>
                
            </ul>
            <div class="tab-content" style="background:white">
                <?php foreach($groups as $group) : ?>
                <div class="tab-pane fade" id="group_<?= $group->id ?>">
                    <div class="table-responsive">
                    <table class="table table-hover datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center">Last Name</th>
                                <th class="text-center">First Name</th>
                                <th class="text-center">DOB</th>
                                <th class="text-center">Age</th>
                                <th class="text-center">Gender</th>
                                <th class="text-center">Relationship</th>
                                <th class="text-center">Type</th>
                                <th class="text-right">Premium</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $membership_number = 'sdfsdf'; $background = '#ffffff'; $total_credit = 0; $total_debit = 0; foreach($renewal->transactions as $transaction) : ?>
                            <?php if($transaction->grouping_id == $group->id && !empty($transaction->family_id) && $transaction->type == 1) : ?>
                                <?php 
                                $total_credit = $total_credit + $transaction->credit;
                                $total_debit = $total_debit + $transaction->debit;
                                    $age = "N/A";
                                        if(!empty($transaction->family->dob)){
                                            $dob = $transaction->family->dob->year."-".$transaction->family->dob->month."-".$transaction->family->dob->day;
                                            $today = date("Y-m-d");
                                            $diff = date_diff(date_create($dob), date_create($today));
                                            $age = $diff->format('%y');
                                        }

                                        if($transaction->employee->membership_number != $membership_number){
                                            if($background == '#ffffff'){
                                                $background = '#f3f3f3'; 
                                            }else{
                                                $background = '#ffffff'; 
                                            }
                                        }

                                        $membership_number = $transaction->employee->membership_number;
                                    ?>
                                <tr style="background:<?= $background ?>">
                                    <td><?= $transaction->employee->membership_number ?></td>
                                    
                                    <td class="text-center"><?= $transaction->family->last_name ?></td>

                                    <td class="text-center"><?= $transaction->family->first_name ?></td>
                                    <td class="text-center"><?= date('m/d/Y', strtotime($dob)) ?></td>
                                    <td class="text-center"><?= $age ?></td>
                                    <td class="text-center"><?= $genders[$transaction->family->gender] ?></td>
                                    <td class="text-center"><?= $relationships[$transaction->family->relationship ] ?></td>
                                    <?php if($transaction->type == 1) : ?>
                                        <td class="text-center"><span class="label label-warning">PREMIUM</span></td>
                                    <?php elseif($transaction->type == 2) : ?>
                                        
                                        <td class="text-center"><span class="label label-success">PAYMENT</span></td>
                                    <?php else : ?>
                                        
                                        <td class="text-center"><span class="label label-danger">CANCELATION</span></td>
                                    <?php endif; ?>

                                    <?php if($transaction->debit > 0) :  ?>
                                        <td class="text-right" style="font-weight:bold"><?= number_format($transaction->debit,2,".",",") ?></td>
                                    <?php else :  ?>
                                        <td class="text-right" style="color:green;font-weight:bold"></td>
                                    <?php endif; ?>
                                </tr>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <?php $total = $total_debit; $summary_due = $summary_due + $total_debit; ?>
                            <tr>
                                <th colspan="8">TOTAL</th>
                                <th class="text-right"><?= number_format($total_debit, 2, ".", ",") ?></th>
                            </tr>
                        </tfoot>
                    </table>
                    </div>
                </div>
                <?php endforeach; ?>

                <div class="tab-pane fade" id="transactions">
                    <div class="table-responsive">
                        <button class="btn btn-info" data-toggle="modal" data-target="#new_transaction">New Transaction</button>
                        <button class="btn btn-info" data-toggle="modal" data-target="#new_employee">New Employee</button>
                        <button class="btn btn-info" data-toggle="modal" data-target="#new_family">New Family Member</button>
                        <table class="table table-hover datatable">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th class="text-center">Membership</th>
                                <th class="text-center">Employee</th>
                                <th class="text-center">Family Member</th>
                                <th class="text-center">Type</th>
                                <th class="text-center">Debit</th>
                                <th class="text-center">Credit</th>
                                <th class="text-center">Memo</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $membership_number = 'sdfsdf'; $background = '#ffffff'; $total_credit = 0; $total_debit = 0; foreach($renewal->transactions as $transaction) : ?>
                            <?php if($transaction->type != 1) : ?>
                                <?php $total_credit = $total_credit + $transaction->credit; $total_debit = $total_debit + $transaction->debit; ?>
                                <tr>
                                    <td><?= date('m/d/Y', strtotime($transaction->created)) ?></td>
                                    <?php if(!empty($transaction->employee)) : ?>
                                        <td class="text-center"><?= $transaction->employee->membership_number ?></td>
                                    <?php else : ?>
                                        <td class="text-center">-</td>
                                    <?php endif; ?>

                                    <?php if(!empty($transaction->employee)) : ?>
                                        <td class="text-center"><?= $transaction->employee->first_name. " ".$transaction->employee->last_name ?></td>
                                    <?php else : ?>
                                        <td class="text-center">-</td>
                                    <?php endif; ?>

                                    <?php if(!empty($transaction->family)) : ?>
                                        <td class="text-center"><?= $transaction->family->first_name." ".$transaction->family->last_name ?></td>
                                    <?php else : ?>
                                        <td class="text-center">-</td>
                                    <?php endif; ?>

                                    <?php if($transaction->type == 1) : ?>
                                        <td class="text-center"><span class="label label-warning">PREMIUM</span></td>
                                    <?php elseif($transaction->type == 2) : ?>
                                        <?php $summary_payments = $summary_payments + $transaction->credit ?>
                                        <td class="text-center"><span class="label label-success">PAYMENT</span></td>
                                    <?php elseif($transaction->type == 4) : ?>
                                        <?php $summary_payments = $summary_payments + $transaction->credit ?>
                                        <td class="text-center"><span class="label label-warning">REFUND</span></td>
                                    <?php else : ?>
                                        <?php $summary_cancelations = $summary_cancelations + $transaction->credit ?>
                                        <td class="text-center"><span class="label label-danger">CANCELATION</span></td>
                                    <?php endif; ?>

                                    <?php if($transaction->debit > 0) :  ?>
                                        <td class="text-center" style="font-weight:bold;color:red"><?= number_format($transaction->debit,2,".",",") ?></td>
                                    <?php else :  ?>
                                        <td class="text-center" style="color:green;font-weight:bold"></td>
                                    <?php endif; ?>

                                     <?php if($transaction->credit > 0) :  ?>
                                        <td class="text-center" style="font-weight:bold;color:green"><?= number_format($transaction->credit,2,".",",") ?></td>
                                    <?php else :  ?>
                                        <td class="text-center" style="color:green;font-weight:bold"></td>
                                    <?php endif; ?>
                                    <td class="text-center"><?= $transaction->memo ?></td>
                                    <td class="text-right">

                                        <a href="<?= ROOT_DIREC ?>/transactions/delete/<?= $transaction->id ?>" onclick="return confirm('Are you sure you would like to delete this transaction')" style="font-size:1.3em!important;margin-left:5px"><span class="fa fa-xl fa-trash color-red"></span></a>
                                    </td>
                                </tr>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <?php $total = $total_debit ?>
                            <tr>
                                <th colspan="5">TOTAL</th>
                                <th class="text-center"><?= number_format($total_debit, 2, ".", ",") ?></th>
                                <th class="text-center"><?= number_format($total_credit, 2, ".", ",") ?></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                    </div>
                </div>
                <div class="tab-pane fade active in" id="summary">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped">
                                <tbody>
                                    <tr>
                                        <th>Company</th>
                                        <td class="text-right"><?= $renewal->business->name ?></td>
                                    </tr>
                                    <tr>
                                        <th>Created</th>
                                        <td class="text-right"><?= date('F d Y',strtotime($renewal->created)) ?></td>
                                    </tr>
                                    <tr>
                                        <th>Renewal Year</th>
                                        <td class="text-right"><?= $renewal->year ?></td>
                                    </tr>
                                    <tr>
                                        <th>Groups</th>
                                        <td class="text-right"><span class="label label-warning"><?= count($renewal->business->groupings) ?></span></td>
                                    </tr>
                                    <tr>
                                        <th>Premium</th>
                                        <td class="text-right"><?= number_format($summary_due, 2, ",", ",") ?></td>
                                    </tr>
                                    <tr>
                                        <th>Payments / Refunds</th>
                                        <td class="text-right"><?= number_format($summary_payments, 2, ",", ",") ?></td>
                                    </tr>
                                    <tr>
                                        <th>Cancelations</th>
                                        <td class="text-right"><?= number_format($summary_cancelations, 2, ",", ",") ?></td>
                                    </tr>
                                    <tr>
                                        <th>Balance</th>
                                        <?php $balance = $summary_due - $summary_payments - $summary_cancelations ?>
                                        <td class="text-right"><?= number_format($balance, 2, ".", ",") ?></td>
                                    </tr>
                                </tbody>
                            </table>
                            <p style="background:#d9edf7;padding:5px;text-align:center">If balance is negative, the customer has an available credit. If positive, they have a balance to pay, if the balance is 0, they have paid for all their employees.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- </div> -->
<!-- </div> -->
    </div>
</div>


<style type="text/css">
    .nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover{
        border:none!important;
    }
    .nav-tabs{
        background:none!important;
    }
</style>


<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({
        'paging' : false,
        'ordering': false
    } );
} );</script>

<style>
    .dt-button{
        padding:5px;
        background:black;
        border:2px solid black;
        border-radius:2px;;
        color:white;
        margin-bottom:-10px;
    }
    .dt-buttons{
        margin-bottom:-25px;
    }
    td{
        vertical-align:middle!important;
    }
</style>


<div class="modal fade" id="new_transaction" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Transaction</h5>
      </div>
      <?= $this->Form->create(null, array("url" => "/renewals/addtransaction")) ?>
      <?= $this->Form->input('renewal_id', array('type' => 'hidden', "value" => $renewal->id)); ?>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-12"><?= $this->Form->control('grouping_id', array('class' => 'form-control', "empty" => '-- Choose Group --', "label" => "Group *", "multiple" => false, 'required' => false, 'style' => "height:46px", 'options' => $groupings)); ?></div> 
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6"><?= $this->Form->control('employee_id', array('class' => 'form-control', "empty" => '-- Choose Employee --', "label" => "Employee", "multiple" => false, 'required' => false, 'style' => "height:46px")); ?></div> 
            <div class="col-md-6"><?= $this->Form->control('family_id', array('class' => 'form-control', "empty" => '-- Choose Employee to see Family Members --', "label" => "Family Member", "multiple" => false, 'required' => false, 'style' => "height:46px")); ?></div> 
        </div>
        <hr>
        <div class="row">
            <div class="col-md-4"><?= $this->Form->control('type', array('class' => 'form-control', "empty" => '-- Type --', "label" => "Type", 'options' => array(2=>"Payment", 3 => "Cancelation") , 'required' => false, 'style' => "height:46px")); ?></div> 
            <div class="col-md-4"><?= $this->Form->control('operation', array('class' => 'form-control', "label" => "Operation", 'options' => array(1=>"Credit", 2 => "Debit") , "multiple" => false, 'required' => true, 'style' => "height:46px")); ?></div> 
            <div class="col-md-4"><?= $this->Form->control('amount', array('class' => 'form-control', "label" => "Amount", 'placeholder' => "Amount")); ?></div> 
        </div>
        <hr>
        <div class="row">
            <div class="col-md-12"><?= $this->Form->control('memo', array('class' => 'form-control', "label" => "Memo", 'placeholder' => "Memo")); ?></div> 
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success">Add</button>
      </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>

<div class="modal fade" id="new_employee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Employee</h5>
      </div>
      <?= $this->Form->create(null, array("url" => '/renewals/addemployee')) ?>
      <div class="modal-body">
            <div class="row">
                    <div class="col-md-4"><?= $this->Form->control('first_name', array('class' => 'form-control', "label" => "First Name *", "placeholder" => "First Name")); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('last_name', array('class' => 'form-control', "label" => "Last Name *", "placeholder" => "Last Name")); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('membership_number', array('class' => 'form-control', "label" => "Membership / Policy # *", "placeholder" => "Membership Number")); ?></div>
                </div>
                <hr>  
                <div class="row">
                  <div class="col-md-4"><?= $this->Form->control('dob', array('class' => 'form-control', "label" => "Date of Birth *", "type" => "date")); ?></div>
                  <div class="col-md-4"><?= $this->Form->control('gender', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $genders, "label" => "Gender", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?></div> 
                  <div class="col-md-4"><?= $this->Form->control('country', array('class' => 'form-control', "label" => "Country of Residence *", "placeholder" => "Country of Residence")); ?></div>
                </div>
                <hr>
                <div class="row">
                <?= $this->Form->control('business_id', array('type' => 'hidden', 'value' => $renewal->business_id )); ?>
                <?= $this->Form->control('renewal_id', array('type' => 'hidden', 'value' => $renewal->id )); ?>
                    <div class="col-md-4"><?= $this->Form->control('grouping_id', array('class' => 'form-control', "empty" => '-- Group --', "label" => "Group *", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?></div> 
                    <div class="col-md-4"><?= $this->Form->control('deductible', array('class' => 'form-control', "label" => "Deductible *", "placeholder" => "Deductible")); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('effective_date', array('class' => 'form-control', "label" => "Effective Date *", "type" => 'date')); ?></div>
                </div>
                <hr>
                <div class="row">
                  
                  <div class="col-md-4"><?= $this->Form->control('status', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $status, "label" => "Status", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?></div> 
                  <div class="col-md-4"><?= $this->Form->control('premium', array('class' => 'form-control', "label" => "Full Premium *", "placeholder" => "Full Premium")); ?></div>
                  <div class="col-md-4"><?= $this->Form->control('debit', array('class' => 'form-control', "label" => "Charged Premium *", "placeholder" => "Charged Premium for this renewal")); ?></div>
                </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Add</button>
      </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>

<div class="modal fade" id="new_family" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Family Member</h5>
      </div>
      <?= $this->Form->create(null, array("url" => '/renewals/addfamily')) ?>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-6"><?= $this->Form->control('grouping_id', array('class' => 'form-control', "empty" => '-- Choose Group --', 'id' => 'grouping-id2', "label" => "Group *", "multiple" => false, 'required' => false, 'style' => "height:46px", 'options' => $groupings)); ?></div> 
            <div class="col-md-6"><?= $this->Form->control('employee_id', array('class' => 'form-control', "empty" => '-- Choose Employee --', 'id' => 'employee-id2', "label" => "Employee *", "multiple" => false, 'required' => false, 'style' => "height:46px")); ?></div> 
        </div>
        <hr>
            <div class="row">
                    <div class="col-md-6"><?= $this->Form->control('first_name', array('class' => 'form-control', "label" => "First Name *", "placeholder" => "First Name")); ?></div>
                    <div class="col-md-6"><?= $this->Form->control('last_name', array('class' => 'form-control', "label" => "Last Name *", "placeholder" => "Last Name")); ?></div>
                    
                </div>
                <hr>
                <div class="row">
                    <?= $this->Form->control('business_id', array('type' => 'hidden',"value" => $renewal->business_id)); ?>
                    <?= $this->Form->control('renewal_id', array('type' => 'hidden',"value" => $renewal->id)); ?>
                    <div class="col-md-6"><?= $this->Form->control('relationship', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $relationships, "label" => "Relationship", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?></div> 
                    <div class="col-md-6"><?= $this->Form->control('dob', array('class' => 'form-control', "label" => "Date of Birth *", 'type' => 'date')); ?></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6"><?= $this->Form->control('gender', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $genders, "label" => "Gender *", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?></div> 
                    <div class="col-md-6"><?= $this->Form->control('country', array('class' => 'form-control', "label" => "Country of Residence *", "placeholder" => "Country of Residence")); ?></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-6"><?= $this->Form->control('premium', array('class' => 'form-control', "label" => "Full Premium *", "placeholder" => "Premium")); ?></div>
                    <div class="col-md-6"><?= $this->Form->control('debit', array('class' => 'form-control', "label" => "Charged Premium *", "placeholder" => "Charged Premium for this renewal")); ?></div>
                </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Add</button>
      </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>

<?php 
echo '<script> var ROOT_DIREC = "'.ROOT_DIREC.'";</script>'

?>

<script type="text/javascript">
    $(document).ready(function(){
        $("#grouping-id").change(function(){
            $("#employee-id").empty();
            $("#employee-id").append("<option value=''>-- Choose Employee --</option>")
            var token =  $('input[name="_csrfToken"]').val();
            var group = $(this).val();
            $.ajax({
                 url : ROOT_DIREC+'/employees/list',
                 type : 'POST',
                 data : {group_id : group},
                 headers : {
                    'X-CSRF-Token': token 
                 },
                 dataType : 'json',
                 success : function(data, statut){
                      for (var i = data.length - 1; i >= 0; i--) {
                          $("#employee-id").append("<option value='"+data[i].id+"'>" + data[i].last_name +  " "+data[i].first_name+ "</option>")
                      }
                 },
                 error : function(resultat, statut, erreur){
                  console.log(erreur)
                 }, 
                 complete : function(resultat, statut){
                    console.log(resultat)
                 }
            });
        })

        $("#grouping-id2").change(function(){
            $("#employee-id2").empty();
            $("#employee-id2").append("<option value=''>-- Choose Employee --</option>")
            var token =  $('input[name="_csrfToken"]').val();
            var group = $(this).val();
            $.ajax({
                 url : ROOT_DIREC+'/employees/list',
                 type : 'POST',
                 data : {group_id : group},
                 headers : {
                    'X-CSRF-Token': token 
                 },
                 dataType : 'json',
                 success : function(data, statut){
                      for (var i = data.length - 1; i >= 0; i--) {
                          $("#employee-id2").append("<option value='"+data[i].id+"'>" + data[i].last_name +  " "+data[i].first_name+ "</option>")
                      }
                 },
                 error : function(resultat, statut, erreur){
                  console.log(erreur)
                 }, 
                 complete : function(resultat, statut){
                    console.log(resultat)
                 }
            });
        })

        $("#employee-id").change(function(){
            $("#family-id").empty();
            $("#family-id").append("<option value=''>-- Choose Family Member --</option>")
            var token =  $('input[name="_csrfToken"]').val();
            var employee = $(this).val();
            $.ajax({
                 url : ROOT_DIREC + '/families/list',
                 type : 'POST',
                 data : {employee_id : employee},
                 headers : {
                    'X-CSRF-Token': token 
                 },
                 dataType : 'json',
                 success : function(data, statut){
                      for (var i = data.length - 1; i >= 0; i--) {
                          $("#family-id").append("<option value='"+data[i].id+"'>" + data[i].last_name +  " "+data[i].first_name+ " ( Premium : "+parseFloat(data[i].premium).toFixed(2)+")</option>")
                      }
                 },
                 error : function(resultat, statut, erreur){
                  console.log(erreur)
                 }, 
                 complete : function(resultat, statut){
                    console.log(resultat)
                 }
            });
        })
    })
</script>