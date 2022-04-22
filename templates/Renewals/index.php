<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Renewal[]|\Cake\Collection\CollectionInterface $renewals
 */
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Renewals</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Renewals
            <button class="btn btn-warning float-right" data-toggle="modal" data-target="#newrenewal" style="float:right">New Renewal</button>
        </div>
    <div class="panel-body articles-container">
            <table class="table table-stripped datatable">
                <thead> 
                    <th>#</th>
                    <th class="text-center">Company</th>
                    <th class="text-center">Created</th>
                    <th class="text-center">Renewal Year</th>
                    <th class="text-left"></th>
                </thead>
            <tbody> 
            <?php foreach($renewals as $renewal) : ?>
                <tr>
                    <td><a href="<?= ROOT_DIREC ?>/renewals/view/<?= $renewal->id ?>"><?= $renewal->renewal_number ?></a></td>
                    <td class="text-center"><a href="<?= ROOT_DIREC ?>/businesses/view/<?= $renewal->business_id ?>"><?= $renewal->business->name ?></a></td>
                    <td class="text-center"><?= date('F d Y', strtotime($renewal->created)) ?></td>
                    <td class="text-center"><?= $renewal->year  ?></td>
                    <td class="text-right">
                        <a href="<?= ROOT_DIREC ?>/renewals/view/<?= $renewal->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-eye color-blue"></span></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
            <!--End .article-->
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
</style>


<div class="modal fade" id="newrenewal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Renewal</h5>
      </div>
      <?= $this->Form->create(null, array("url" => '/renewals/add')) ?>
      <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
                <?= $this->Form->control('business_id', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $businesses, "label" => "Company", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?>
            </div>
            <div class="col-md-6">
                <?= $this->Form->control('renewal_number', array('class' => 'form-control', "label" => "Renewal  Number *", "placeholder" => "Renewal Number")); ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <?= $this->Form->control('year', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $years, "label" => "Renewal Year", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success">Save</button>
      </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>


<script type="text/javascript">
    // $(document).ready(function(){
    //     $("#business-id").change(function(){
    //         alert($(this).val())
    //         var token =  $('input[name="_csrfToken"]').val();
    //         var business = $(this).val();
    //         $.ajax({
    //              url : '/copassa/businesses/getbusiness',
    //              type : 'POST',
    //              data : {business_id : business},
    //              headers : {
    //                 'X-CSRF-Token': token 
    //              },
    //              dataType : 'json',
    //              success : function(data, statut){
    //                   console.log(data)
    //              },
    //              error : function(resultat, statut, erreur){
    //               console.log(erreur)
    //              }, 
    //              complete : function(resultat, statut){
    //                 console.log(resultat)
    //              }
    //         });
    //     })
    // })
</script>