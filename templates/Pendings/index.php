<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li>Pending New Business</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Pending New Business
            <?php if($user_connected['role_id'] != 2 || $auths[28]) : ?>
            <button class="btn btn-success" style="float:right" data-target="#newmaternity" data-toggle="modal">Add</button>
        <?php endif; ?>
        </div>
    <div class="panel-body articles-container">
        <div class="table-responsive">
            <table class="table table-striped datatable">
                <thead> 
                    <th class="text-left">Name</th>
                    <th class="text-center">Company</th>
                    <th class="text-center">Option</th>
                    <th class="text-center">Country</th>
                    <th class="text-center">Dependants</th>
                    <th class="text-center">Created</th>
                    <th class="text-center">Created By</th>
                    <th class="text-center">Last Contact Date</th>
                    <th class="text-center">Status</th>
                    <?php if($user_connected['role_id'] != 2 || $auths[28]) : ?>
                    <th></th>
                <?php endif; ?>
                </thead>
            <tbody> 
        <?php foreach($pendings as $pending) : ?>
          <?php if($pending->country_id == $filter_country || empty($filter_country)) : ?>
            <tr>
                <td class="text-left"><?= h($pending->name) ?></td>
                <td class="text-center"><?= h($pending->company->name) ?></td>
                <td class="text-center"><?= h($pending->option->name) ?></td>
                <td class="text-center"><?= h($pending->country->name) ?></td>
                <td class="text-center"><?= h($pending->dependants) ?></td>
                <td class="text-center"><?= h(date("M d Y", strtotime($pending->created))) ?></td>
                <td class="text-center"><?= h($pending->user->name) ?></td>  
                <td class="text-center"><?= h(date("M d Y", strtotime($pending->last_contact_date))) ?></td> 
                <?php if($pending->status == 1) : ?>   
                <td class="text-center"><span class="label label-success">Pending</span></td>  
                <?php elseif($pending->status == 2) : ?>    
                   <td class="text-center"><span class="label label-warning">Canceled</span></td> 
                <?php else : ?>
                    <td class="text-center"><span class="label label-info">Confirmed</span></td> 
                <?php endif; ?>
                <?php if($user_connected['role_id'] != 2 || $auths[28]) : ?>
                <td class="text-right">
                  <a href="<?= ROOT_DIREC ?>/pendings/edit/<?= $pending->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>
                  <a href="<?= ROOT_DIREC ?>/pendings/delete/<?= $pending->id ?>" onclick="return confirm('Are you sure you would like to delete the pending new business for <?= $pending->name ?>')" style="font-size:1.3em!important;margin-left:5px"><span class="fa fa-xl fa-trash color-red"></span></a>
                </td>
            <?php endif; ?>
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

<?php if($user_connected['role_id'] != 2 || $auths[28]) : ?>
<div class="modal fade" id="newmaternity" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <?= $this->Form->create(null, array('url' => '/pendings/add')) ?>
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Pending New Business</h5>
      </div>
      <div class="modal-body">
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
            <div class="col-md-6"><?= $this->Form->control('dependants', array('class' => 'form-control', "label" => "Number of Dependants", "placeholder" => "Number of Dependants", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?></div>
            <div class="col-md-6">
                <?= $this->Form->control('country_id', array('class' => 'form-control', "label" => "Country *", "empty" => "-- Choose --", "options" => $countries)); ?>
            </div> 
        </div>
        <hr>
        <div class="row">
            <div class="col-md-4"><?= $this->Form->control('last_contact_date', array('class' => 'form-control', "label" => "Last Contact Date", "type" => "Date", "value" => date('Y-m-d'), 'required' => true, 'style' => "height:46px")); ?></div>
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
<?php endif; ?>

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