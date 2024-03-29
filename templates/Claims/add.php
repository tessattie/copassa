<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Claim $claim
 */

?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/claims">
            Claims
        </a></li>
        <li class="active">Add</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            New Claim
           <a class="btn btn-info" style="float:right" href="<?= ROOT_DIREC ?>/claims"><em class="fa fa-arrow-left"></em></a>
        </div>
    <div class="panel-body articles-container">       
            <?= $this->Form->create($claim) ?>
                <div class="row">
                    <div class="col-md-4"><?= $this->Form->control('customer_id', array('class' => 'form-control', "label" => "Policy Holder *", "empty" => "-- Choose --", 'options' => $customers)); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('policy_id', array('class' => 'form-control', "label" => "Policy Number *", "empty" => "-- Choose Policy Holder to see Policies --", 'options' => $policies)); ?></div>
                    <div class="col-md-4"><?= $this->Form->control('dependant_id', array('class' => 'form-control', "label" => "Dependant", "empty" => "-- Choose Policy Number to see Dependants --")); ?></div>
                </div>
                <hr>
                  <div class="row">
                <div class="col-md-6"><?= $this->Form->control('title', array('class' => 'form-control', "label" => "Diagnosis *", "placeholder" => "Diagnosis")); ?></div>
                   <div class="col-md-6"><?= $this->Form->control('description', array('class' => 'form-control', "label" => "Description *", "placeholder" => "Description / Diagnosis")); ?></div> 
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
        $("#customer-id").change(function(){
            $("#policy-id").empty();
            $("#policy-id").append("<option value=''>-- Choose Policy Holder to see Policies --</option>")
            $("#dependant-id").empty();
            $("#dependant-id").append("<option value=''>-- Choose Policy Number to see Dependants --</option>")
            var token =  $('input[name="_csrfToken"]').val();
            var customer_id = $(this).val();
            $.ajax({
                 url : ROOT_DIREC+'/policies/list',
                 type : 'POST',
                 data : {customer_id : customer_id},
                 headers : {
                    'X-CSRF-Token': token 
                 },
                 dataType : 'json',
                 success : function(data, statut){
                      for (var i = data.length - 1; i >= 0; i--) {
                          $("#policy-id").append("<option value='"+data[i].id+"'>" + data[i].policy_number+"</option>")
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

        $("#policy-id").change(function(){
            $("#dependant-id").empty();
            $("#dependant-id").append("<option value=''>-- Choose Policy Number to see Dependants --</option>")
            var token =  $('input[name="_csrfToken"]').val();
            var policy_id = $(this).val();
            $.ajax({
                 url : ROOT_DIREC+'/dependants/list',
                 type : 'POST',
                 data : {policy_id : policy_id},
                 headers : {
                    'X-CSRF-Token': token 
                 },
                 dataType : 'json',
                 success : function(data, statut){
                      for (var i = data.length - 1; i >= 0; i--) {
                          $("#dependant-id").append("<option value='"+data[i].id+"'>" + data[i].name+"</option>")
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