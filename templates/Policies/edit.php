<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
$months = array(
  1 => "January", 
  2 => "February", 
  3 => "March", 
  4 => "April", 
  5 => "May", 
  6 => 'June', 
  7 => "July", 
  8 => "August", 
  9 => "September", 
  10 => "October", 
  11 => "November", 
  12 => "December"
);

?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/policies">
            Policies
        </a></li>
        <li class="active">Edit</li>
        <li><?= h($policy->policy_number) ?></li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Edit Policy : <?= h($policy->policy_number) ?>
            <a class="btn btn-info" style="float:right" href="<?= ROOT_DIREC ?>/policies"><em class="fa fa-arrow-left"></em></a>
        </div>
    <div class="panel-body articles-container">       
            <?= $this->Form->create($policy, array('type' => 'file')) ?>
            <h4 style="padding: 10px;text-align: center;background: #f3f3f3;margin-bottom: 23px;">Profile</h4>
                <div class="row">
                    <?php if(!empty($customer_id)) : ?>
                        <div class="col-md-3"><?= $this->Form->control('customer_id', array('class' => 'form-control', "label" => "Policy Holder *", "empty" => "-- Choose --", "options" => $customers, 'value' => $customer_id)); ?>
                        </div>
                    <?php else : ?>
                        <div class="col-md-3"><?= $this->Form->control('customer_id', array('class' => 'form-control', "label" => "Policy Holder *", "empty" => "-- Choose --", "options" => $customers)); ?>
                        </div>
                    <?php endif; ?>
                    
                    <div class="col-md-3"><?= $this->Form->control('policy_number', array('class' => 'form-control', "label" => "Policy Number *", "placeholder" => "Policy Number")); ?>
                    </div>
                    <div class="col-md-3"><?= $this->Form->control('passport_number', array('class' => 'form-control', 'placeholder' => 'Passport Number', "label" => "Passport Number")); ?>
                    </div>

                    <div class="col-md-3"><?= $this->Form->control('effective_date', array('class' => 'form-control', "type" => "date", "label" => "Effective Date *")); ?>
                    </div>
                </div>
                <h4 style="padding: 10px;text-align: center;background: #f3f3f3;margin-bottom: 33px;;margin-top:30px">Coverage</h4>
                <div class="row">
                    <div class="col-md-3"><?= $this->Form->control('company_id', array('class' => 'form-control', "label" => "Company*", "empty" => "-- Choose --", "options" => $companies)); ?>
                    </div>
                    <div class="col-md-3"><?= $this->Form->control('option_id', array('class' => 'form-control', "empty" => "-- Choose company to see options --")); ?>
                    </div>
                    <div class="col-md-2"><?= $this->Form->control('deductible', array('class' => 'form-control', "value" => 0, 'placeholder' => 'deductible', 'value' => $policy->deductible)); ?>
                    </div>
                    <div class="col-md-2"><?= $this->Form->control('usa_deductible', array('class' => 'form-control', "value" => 0, 'placeholder' => 'deductible', 'value' => $policy->usa_deductible)); ?>
                    </div>
                    <div class="col-md-2"><?= $this->Form->control('max_coverage', array('class' => 'form-control', "value" => 0, 'placeholder' => 'deductible', 'value' => $policy->max_coverage)); ?>
                    </div>
                </div>
                <h4 style="padding: 10px;text-align: center;background: #f3f3f3;margin-bottom: 33px;;margin-top:30px">Payments</h4>
                <div class="row">
                  <div class="col-md-3"><?= $this->Form->control('mode', array('class' => 'form-control', 'options' => $modes, "label" => "Mode", "multiple" => false, 'required' => true, 'style' => "height:46px", 'empty' => "-- Choose --")); ?>
                    </div>
                    <div class="col-md-3"><?= $this->Form->control('premium', array('class' => 'form-control', "label" => "Premium *", 'required' => true, 'style' => "height:46px", 'placeholder' => "Premium")); ?>
                    </div>
                    <div class="col-md-3"><?= $this->Form->control('fee', array('class' => 'form-control', "label" => "Fee *", 'required' => true, 'style' => "height:46px", 'placeholder' => "Fee")); ?>
                    </div>
                </div>

                <h4 style="padding: 10px;text-align: center;background: #f3f3f3;margin-bottom: 33px;;margin-top:30px">Exclusions</h4>
                <div class="row" style="margin-top:10px">
                    <div class="col-md-12"><?= $this->Form->control('exclusions', array("type" => "text", 'class' => 'form-control', "label" => "Exclusions", "placeholder" => "Exclusions")); ?>
                    </div>
                </div> 

                <div class="row">
                    <div class="col-md-12"><?= $this->Form->button(__('Update'), array('class'=>'btn btn-success', "style"=>"margin-top:25px;float:right")) ?></div>
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


        $("#option-id").change(function(){
            var token =  $('input[name="_csrfToken"]').val();
            var option = $(this).val();
            $.ajax({
                 url : ROOT_DIREC+'/companies/option',
                 type : 'POST',
                 data : {option_id : option},
                 headers : {
                    'X-CSRF-Token': token 
                 },
                 dataType : 'json',
                 success : function(data, statut){
                      console.log(data.deductible);
                      $('#deductible').val(data.deductible);
                      $('#usa-deductible').val(data.usa_deductible);
                      $('#max-coverage').val(data.max_coverage);
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