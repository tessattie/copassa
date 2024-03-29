<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Family $family
 */
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/families">
            Family Members
        </a></li>
        <li>Edit</li>
        <li class="active"><?= h($family->first_name." ".$family->last_name) ?></li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Edit Family Member : <?= h($family->first_name." ".$family->last_name) ?>
            <a class="btn btn-info" style="float:right" href="<?= ROOT_DIREC ?>/families"><em class="fa fa-arrow-left"></em></a>
        </div>
    <div class="panel-body articles-container">       
            <?= $this->Form->create($family) ?>
               <div class="row">
                    <div class="col-md-4"><?= $this->Form->control('first_name', array('class' => 'form-control', "label" => "First Name *", "placeholder" => "First Name")); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('last_name', array('class' => 'form-control', "label" => "Last Name *", "placeholder" => "Last Name")); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('relationship', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $relationships, "label" => "Relationship", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?></div> 
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4"><?= $this->Form->control('business_id', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $businesses, "label" => "Company", "multiple" => false, 'required' => true, 'style' => "height:46px", 'value' => $family->employee->business_id)); ?></div> 
                    <div class="col-md-4"><?= $this->Form->control('grouping_id', array('class' => 'form-control', "empty" => '-- Choose Company to see Groups --', 'options' => $groups, "label" => "Group", "multiple" => false, 'required' => true, 'style' => "height:46px", 'value' => $family->employee->grouping_id)); ?></div> 
                    <div class="col-md-4"><?= $this->Form->control('employee_id', array('class' => 'form-control', "empty" => '-- Choose Group to see Employees --', "label" => "Employee", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?></div> 
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3"><?= $this->Form->control('premium', array('class' => 'form-control', "label" => "Premium *", "placeholder" => "Premium")); ?></div>
                    <div class="col-md-3"><?= $this->Form->control('dob', array('class' => 'form-control', "label" => "Date of Birth *")); ?></div>
                    <div class="col-md-3"><?= $this->Form->control('gender', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $genders, "label" => "Gender *", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?></div> 
                    <div class="col-md-3"><?= $this->Form->control('country', array('class' => 'form-control', "label" => "Country of Residence *", "placeholder" => "Country of Residence")); ?></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3"><?= $this->Form->control('status', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $status, "label" => "Status", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?></div> 
                </div>
                <div class="row">
                    <div class="col-md-12"><?= $this->Form->button(__('Add'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
                </div>  

            <?= $this->Form->end() ?>
        </div>
        
    </div>
</div><!--End .articles-->
<?php 
echo '<script> var ROOT_DIREC = "'.ROOT_DIREC.'";</script>'
?>
<script type="text/javascript">
$(document).ready(function(){

    $("#business-id").change(function(){
            $("#grouping-id").empty();
            $("#grouping-id").append("<option value=''>-- Choose Company to see Groups --</option>")
            var token =  $('input[name="_csrfToken"]').val();
            var business = $(this).val();
            $.ajax({
                 url : ROOT_DIREC+'/groupings/list',
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

        $("#grouping-id").change(function(){
            $("#employee-id").empty();
            $("#employee-id").append("<option value=''>-- Choose Group to see Employees --</option>")
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
})
</script>

<style type="text/css">
    @media only screen and (max-width: 600px) {
      .input label, #cell-phone, #home-phone, #other-phone, .col-md-4 label{
        margin-top: 15px;
      }
    }
</style>