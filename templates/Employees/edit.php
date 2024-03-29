<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Employee $employee
 */
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/employees">
            Employees
        </a></li>
        <li>Edit</li>
        <li class="active"><?= h($employee->first_name." ".$employee->last_name) ?></li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Edit Employee : <?= h($employee->first_name." ".$employee->last_name) ?>
            <a class="btn btn-info" style="float:right" href="<?= ROOT_DIREC ?>/employees"><em class="fa fa-arrow-left"></em></a>
        </div>
    <div class="panel-body articles-container">       
            <?= $this->Form->create($employee) ?>
                <div class="row">
                    <div class="col-md-4"><?= $this->Form->control('first_name', array('class' => 'form-control', "label" => "First Name *", "placeholder" => "First Name")); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('last_name', array('class' => 'form-control', "label" => "Last Name *", "placeholder" => "Last Name")); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('membership_number', array('class' => 'form-control', "label" => "Membership / Policy Number *", "placeholder" => "Membership Number")); ?></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4"><?= $this->Form->control('business_id', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $businesses, "label" => "Company", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?></div> 
                    <div class="col-md-4"><?= $this->Form->control('grouping_id', array('class' => 'form-control', "empty" => '-- Choose --', "label" => "Group", 'options' => $groupings, "multiple" => false, 'required' => true, 'style' => "height:46px", 'value' => $employee->grouping_id)); ?></div> 
                    <div class="col-md-4"><?= $this->Form->control('deductible', array('class' => 'form-control', "label" => "Deductible *", "placeholder" => "Deductible")); ?></div>
                </div>
                <hr>
                 <div class="row">
                  <div class="col-md-4"><?= $this->Form->control('effective_date', array('class' => 'form-control', "label" => "Effective Date *")); ?></div>
                  <div class="col-md-4"><?= $this->Form->control('status', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $status, "label" => "Status", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?></div> 
                </div>
                <div class="row">
                    <div class="col-md-12"><?= $this->Form->button(__('Update'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
                </div>  


            <?= $this->Form->end() ?>
        </div>
        
    </div>
</div><!--End .articles-->

<script type="text/javascript">
    $(document).ready(function(){

        $("#business-id").change(function(){
            $("#grouping-id").empty();
            $("#grouping-id").append("<option value=''>-- Choose Compny to see Groups --</option>")
            var token =  $('input[name="_csrfToken"]').val();
            var business = $(this).val();
            $.ajax({
                 url : '/groupings/list',
                 type : 'POST',
                 data : {business_id : business},
                 headers : {
                    'X-CSRF-Token': token 
                 },
                 dataType : 'json',
                 success : function(data, statut){
                      for (var i = data.length - 1; i >= 0; i--) {
                          $("#grouping-id").append("<option value='"+data[i].id+"'>"+data[i].grouping_number+ "</option>")
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


<style type="text/css">
    @media only screen and (max-width: 600px) {
      .input label, #cell-phone, #home-phone, #other-phone, .col-md-4 label{
        margin-top: 15px;
      }

      
    }
</style>