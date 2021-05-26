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
        <li><a href="<?= ROOT_DIREC ?>/customers">
            Policies
        </a></li>
        <li class="active">Add</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            New Policy
            <ul class="pull-right panel-settings panel-button-tab-right">
                <li class="dropdown"><a href="<?= ROOT_DIREC ?>/customers">
                    <em class="fa fa-arrow-left"></em>
                </a>
                    
                </li>
            </ul>
        </div>
    <div class="panel-body articles-container">       
            <?= $this->Form->create($policy, array('enctype' => 'multipart/form-data')) ?>
                <div class="row">
                    <?php if(!empty($customer_id)) : ?>
                        <div class="col-md-3"><?= $this->Form->control('customer_id', array('class' => 'form-control', "label" => "Policy Holder *", "empty" => "-- Choose --", "options" => $customers, 'value' => $customer_id)); ?>
                        </div>
                    <?php else : ?>
                        <div class="col-md-2"><?= $this->Form->control('customer_id', array('class' => 'form-control', "label" => "Policy Holder *", "empty" => "-- Choose --", "options" => $customers)); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="col-md-3"><?= $this->Form->control('policy_number', array('class' => 'form-control', "label" => "Policy Number *", "placeholder" => "Policy Number")); ?>
                    </div>

                    <div class="col-md-3"><?= $this->Form->control('effective_date', array('class' => 'form-control', "type" => "date", "label" => "Effective Date *")); ?>
                    </div>
                    <div class="col-md-3"><?= $this->Form->control('paid_until', array('class' => 'form-control', "type" => "date", "label" => "Paid Until *")); ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-2"><?= $this->Form->control('company_id', array('class' => 'form-control', "label" => "Company*", "empty" => "-- Choose --", "options" => $companies)); ?>
                    </div>
                    <div class="col-md-2"><?= $this->Form->control('option_id', array('class' => 'form-control', "empty" => "-- Choose company to see options --")); ?>
                    </div>
                    <div class="col-md-2"><?= $this->Form->control('deductible', array('class' => 'form-control', "value" => 0, 'placeholder' => 'deductibles')); ?>
                    </div>
                    <div class="col-md-2"><?= $this->Form->control('mode', array('class' => 'form-control', 'options' => $modes, "label" => "Mode", "multiple" => false, 'required' => true, 'style' => "height:46px", 'value' => 12)); ?>
                    </div>
                    <div class="col-md-2"><?= $this->Form->control('premium', array('class' => 'form-control', "label" => "Premium *", 'required' => true, 'style' => "height:46px", 'placeholder' => "Premium")); ?>
                    </div>
                    <div class="col-md-2"><?= $this->Form->control('fee', array('class' => 'form-control', "label" => "Fee *", 'required' => true, 'style' => "height:46px", 'placeholder' => "Fee", 'value' => 0)); ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-2"><?= $this->Form->control('active', array('class' => 'form-control', 'options' => $premium_status, "label" => "Active", 'required' => true, 'style' => "height:46px", 'value' => 1)); ?>
                    </div>
                    <div class="col-md-2"><?= $this->Form->control('lapse', array('class' => 'form-control', 'options' => $premium_status, "label" => "Lapse", 'required' => true, 'style' => "height:46px", 'value' => 0)); ?>
                    </div>
                    <div class="col-md-2"><?= $this->Form->control('pending', array('class' => 'form-control', 'options' => $premium_status, "label" => "Pending", 'required' => true, 'style' => "height:46px", 'value' => 0)); ?>
                    </div>
                    <div class="col-md-2"><?= $this->Form->control('grace_period', array('class' => 'form-control', 'options' => $premium_status, "label" => "Grace Period", 'required' => true, 'style' => "height:46px", 'value' => 0)); ?>
                    </div>
                    <div class="col-md-2"><?= $this->Form->control('canceled', array('class' => 'form-control', 'options' => $premium_status, "label" => "Canceled", 'required' => true, 'style' => "height:46px", 'value' => 0)); ?>
                    </div>
                </div>
                <div class="row" style="margin-top:10px">
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputFile">Certificate</label>
                        <input type="file" id="exampleInputFile" name="certificate">
                        <p class="help-block">Upload Policy Certificate here.</p>
                      </div>
                    </div>
                </div> 
                <div class="row">
                    <div class="col-md-12"><?= $this->Form->button(__('Add'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
                </div>  


            <?= $this->Form->end() ?>
        </div>
        
    </div>
</div><!--End .articles-->

<script type="text/javascript">
    $(document).ready(function(){

        $("#company-id").change(function(){
            $("#option-id").empty();
            var token =  $('input[name="_csrfToken"]').val();
            var company = $(this).val();
            $.ajax({
                 url : '/copassa/companies/options',
                 type : 'POST',
                 data : {company_id : company},
                 headers : {
                    'X-CSRF-Token': token 
                 },
                 dataType : 'json',
                 success : function(data, statut){
                      for (var i = data.length - 1; i >= 0; i--) {
                          $("#option-id").append("<option value='"+data[i].id+"'>"+data[i].name+" - "+data[i].option_name+ "</option>")
                      }
                      $('#deductible').val(data[data.length - 1].deductible);
                 },
                 error : function(resultat, statut, erreur){
                  console.log(erreur)
                 }, 
                 complete : function(resultat, statut){
                    console.log(resultat)
                 }
            });
        })


        $("#option-id").change(function(){
            var token =  $('input[name="_csrfToken"]').val();
            var option = $(this).val();
            $.ajax({
                 url : '/copassa/companies/option',
                 type : 'POST',
                 data : {option_id : option},
                 headers : {
                    'X-CSRF-Token': token 
                 },
                 dataType : 'json',
                 success : function(data, statut){
                    $('#deductible').val(data.deductible);
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