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
        <li><a href="<?= ROOT_DIREC ?>/pendings">
            Pending New Business
        </a></li>
        <li>Edit</li>
        <li><?= h($pending->name) ?></li>
    </ol>
</div>

<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Edit Pending New Business : <?= h($pending->name) ?>
        </div>
    <div class="panel-body articles-container">       
            <?= $this->Form->create($pending) ?>
                <div class="row">
            <div class="col-md-12"><?= $this->Form->control('name', array('class' => 'form-control', "label" => "Full Name", 'required' => true, 'style' => "height:46px", 'placeholder' => "Full Name")); ?></div>
               </div>
               <hr> 
            <div class="row">
            <div class="col-md-6"><?= $this->Form->control('company_id', array('class' => 'form-control', "label" => "Company*", "empty" => "-- Choose --", "options" => $companies)); ?>
                    </div>
                    <div class="col-md-6"><?= $this->Form->control('option_id', array('class' => 'form-control', "empty" => "-- Choose company to see options --")); ?>
                    </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-4"><?= $this->Form->control('dependants', array('class' => 'form-control', "label" => "Number of Dependants", "placeholder" => "Number of Dependants", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?></div>
            <div class="col-md-4">
                <?= $this->Form->control('country_id', array('class' => 'form-control', "label" => "Country *", "empty" => "-- Choose --", "options" => $countries)); ?>
            </div> 
            <div class="col-md-4">
                <?= $this->Form->control('status', array('class' => 'form-control', "label" => "Status *", "empty" => "-- Choose --", "options" => array(1=> "Pending", 2 => "Canceled", 3 => "Confirmed"))); ?>
            </div> 
        </div>

        <hr>
        <div class="row">
            <div class="col-md-4"><?= $this->Form->control('last_contact_date', array('class' => 'form-control', "label" => "Last Contact Date", "type" => "Date", "value" => $pending->last_contact_date, 'required' => true, 'style' => "height:46px")); ?></div>
        </div>

                <div class="row">

                    <div class="col-md-12"><?= $this->Form->button(__('Update'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
                </div>  


            <?= $this->Form->end() ?>
        </div>
    </div>

    <?php 
echo '<script> var ROOT_DIREC = "'.ROOT_DIREC.'";</script>'
?>

<script type="text/javascript">
    $(document).ready(function(){
        $("#company-id").change(function(){
            $("#option-id").empty();
            var token =  $('input[name="_csrfToken"]').val();
            var company = $(this).val();
            $.ajax({
                 url : ROOT_DIREC+'/companies/options',
                 type : 'POST',
                 data : {company_id : company},
                 headers : {
                    'X-CSRF-Token': token 
                 },
                 dataType : 'json',
                 success : function(data, statut){
                      console.log(data[0]);
                      for (var i = data.length - 1; i >= 0; i--) {
                          $("#option-id").append("<option value='"+data[i].id+"'>"+data[i].name+" - "+data[i].option_name+ "</option>")
                      }
                      $('#deductible').val(data[data.length - 1].deductible);
                      $('#usa-deductible').val(data[data.length - 1].usa_deductible);
                      $('#max-coverage').val(data[data.length - 1].usa_deductible);
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