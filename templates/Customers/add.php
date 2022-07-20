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
            Policy Holders
        </a></li>
        <li class="active">Add</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            New Policy Holder
            <a class="btn btn-info" style="float:right" href="<?= ROOT_DIREC ?>/customers"><em class="fa fa-arrow-left"></em></a>
        </div>
    <div class="panel-body articles-container">       
            <?= $this->Form->create($customer) ?>
                <div class="row">
                    <div class="col-md-4"><?= $this->Form->control('name', array('class' => 'form-control', "label" => "Name *", "placeholder" => "Name")); ?>
                    </div>
                    <div class="col-md-4"><?= $this->Form->control('email', array('class' => 'form-control', "label" => "E-mail *", "placeholder" => "E-mail")); ?>
                    </div>
                    <div class="col-md-4"><?= $this->Form->control('dob', array('class' => 'form-control', "type" => "date", "label" => "Date of Birth *")); ?>
                    </div>                  
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-4">
                        <label>Home Phone</label>
                        <div class="row">
                            <div class="col-md-4" >
                                <?= $this->Form->control('home_area_code', array('class' => 'form-control', "label" => false, "value" => "1", 'options' => $area_codes)); ?>
                            </div>
                            <div class="col-md-8">
                               <?= $this->Form->control('home_phone', array('class' => 'form-control', "label" => false, "placeholder" => "Phone")); ?> 
                            </div>
                        </div>
                        
                    </div>
                    <div class="col-md-4">
                        <label>Cell Phone</label>
                        <div class="row">
                            <div class="col-md-4" >
                                <?= $this->Form->control('cell_area_code', array('class' => 'form-control', "label" => false, "value" => "1", 'options' => $area_codes)); ?>
                            </div>
                            <div class="col-md-8">
                               <?= $this->Form->control('cell_phone', array('class' => 'form-control', "label" => false, "placeholder" => "Phone")); ?> 
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>Other Phone</label>
                        <div class="row">
                            <div class="col-md-4">
                                <?= $this->Form->control('other_area_code', array('class' => 'form-control', "label" => false, "value" => "1", 'options' => $area_codes)); ?>
                            </div>
                            <div class="col-md-8">
                               <?= $this->Form->control('other_phone', array('class' => 'form-control', "label" => false, "placeholder" => "Phone")); ?> 
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <?= $this->Form->control('address', array('class' => 'form-control', "label" => "Address *", "placeholder" => "Address")); ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-3"><?= $this->Form->control('country_id', array('class' => 'form-control', 'empty' => '-- Choose country --', 'options' => $countries, "label" => "Country", "multiple" => false, 'required' => true, 'style' => "height:46px", 'value' => '')); ?>
                    </div> 
                    <div class="col-md-3"><?= $this->Form->control('agent_id', array('class' => 'form-control', 'options' => [], "label" => "Agent", "empty" => '-- Choose country to see agents --', 'required' => false, 'style' => "height:46px")); ?>
                    </div>                    
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
        $("#country-id").change(function(){
            $("#agent-id").empty();
            $("#agent-id").append("<option value=''>-- Choose country to see agents --</option>")
            var token =  $('input[name="_csrfToken"]').val();
            var country = $(this).val();
            $.ajax({
                 url : ROOT_DIREC+'/agents/list',
                 type : 'POST',
                 data : {country_id : country},
                 headers : {
                    'X-CSRF-Token': token 
                 },
                 dataType : 'json',
                 success : function(data, statut){
                    console.log(data)
                      for (var i = 0; i < data.length; i++) {
                          $("#agent-id").append("<option value='"+data[i].id+"'>"+data[i].name+ "</option>")
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