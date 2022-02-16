<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li>Maternity Reminder</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Maternity Reminder
            <button class="btn btn-success" style="float:right" data-target="#newmaternity" data-toggle="modal">Add</button>
        </div>
    <div class="panel-body articles-container">
        <div style="">
            <table class="table table-striped datatable">
                <thead> 
                    <th class="text-left">Policy Number</th>
                    <th class="text-center">Policy Holder</th>
                    <th class="text-center">Country</th>
                    <th class="text-center">Company</th>
                    <th class="text-center">Due Date</th>
                    <th class="text-center">Created By</th>
                    <th></th>
                </thead>
            <tbody> 
        <?php foreach($newborns as $newborn) : ?>
          <?php if($newborn->policy->customer->country_id == $filter_country || empty($filter_country)) : ?>
            <tr>
                <td class="text-left"><a href="<?= ROOT_DIREC ?>/policies/view/<?= $newborn->policy->id ?>"><?= $newborn->policy->policy_number ?></a></td>
                <td class="text-center"><?= $newborn->policy->customer->name ?></td>
                <td class="text-center"><?= $newborn->policy->customer->country->name ?></td>
                <td class="text-center"><?= $newborn->policy->company->name . " / ".  $newborn->policy->option->name ?></td>
                <td class="text-center"><?= date("M d Y", strtotime($newborn->due_date)) ?></td>
                <td class="text-center"><?= $newborn->user->name ?></td>                
                <td class="text-right">
                    <a href="<?= ROOT_DIREC ?>/newborns/delete/<?= $newborn->id ?>" class="btn btn-danger" style="float:right;margin-left:5px" onclick="return confirm('Are you sure you would like to delete this reminder?')">Delete</a>
                <button class="btn btn-warning" style="float:right" data-target="#confirm_maternity_<?= $newborn->id ?>" data-toggle="modal">Confirm</button>

                </td>

            </tr>
          <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
        </table>
            </div><!--End .article-->
        </div>
        
    </div>
</div><!--End .articles-->

<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({

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
    td, th{
        vertical-align:middle!important;
    }
</style>

<div class="modal fade" id="newmaternity" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <?= $this->Form->create(null, array('url' => '/newborns/add')) ?>
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Maternity Reminder</h5>
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-6"><?= $this->Form->control('customer_id', array('class' => 'form-control', "empty" => '-- Choose Policy --', "label" => "Policy", "multiple" => false, "options" => $customers, 'required' => true, 'style' => "height:46px")); ?></div>
            <div class="col-md-6"><?= $this->Form->control('policy_id', array('class' => 'form-control', "empty" => '-- Choose Policy Holder to see Policies --', "label" => "Policy", "multiple" => false, "options" => [], 'required' => true, 'style' => "height:46px")); ?></div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6"><?= $this->Form->control('due_date', array('class' => 'form-control', "type" => 'date', "label" => "Due Date", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?></div> 
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Add</button>
      </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>


<?php foreach($newborns as $newborn) : ?>
    <div class="modal fade" id="confirm_maternity_<?= $newborn->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <?= $this->Form->create(null, array("url" => "/newborns/adddependant")) ?>
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
            New Dependant
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
                <?= $this->Form->control('limitations', array('class' => 'form-control', "label" => "Exclusions *", "placeholder" => "Exclusions / Limitations")); ?>
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


<script type="text/javascript">
    $(document).ready(function(){
        $("#customer-id").change(function(){
            $("#policy-id").empty();
            $("#policy-id").append("<option value=''>-- Choose Policy Holder to see Policies --</option>")
            var token =  $('input[name="_csrfToken"]').val();
            var customer_id = $(this).val();
            $.ajax({
                 url : '/copassa/policies/list',
                 type : 'POST',
                 data : {customer_id : customer_id},
                 headers : {
                    'X-CSRF-Token': token 
                 },
                 dataType : 'json',
                 success : function(data, statut){
                      for (var i = data.length - 1; i >= 0; i--) {
                          $("#policy-id").append("<option value='"+data[i].id+"'>" + data[i].policy_number+")</option>")
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