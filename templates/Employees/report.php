<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Reports</li>
        <li class="active">Coorporate Groups</li>
    </ol>
</div>
<?= $this->Flash->render() ?>

<div class="modal fade" id="filters" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <?= $this->Form->create() ?>
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
            Filter
        </h5>
      </div>
      <div class="modal-body">
        <div class="row">
                    <div class="col-md-12">
                        <?= $this->Form->control('business_id', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $businesses, "label" => "Corporate Group", "multiple" => false, 'style' => "height:46px")); ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-md-12">
                        <?= $this->Form->control('grouping_id', array('class' => 'form-control', 'options' => $groupings, "empty" => '-- Choose --',"label" => "Group", "multiple" => false, 'style' => "height:46px", 'value' => $grouping_id)); ?>
                    </div>
                </div>
            </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-success">Filter</button>
      </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>

<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Corporate Groups
            <a target="_blank" href="<?= ROOT_DIREC ?>/employees/export/<?= $business_id ?>/<?= $grouping_id ?>" style="float:right;" class="btn btn-danger"><span class="fa fa-file-pdf-o"></span></a>

            <a href="<?= ROOT_DIREC ?>/employees/exportexcel/<?= $business_id ?>/<?= $grouping_id ?>" style="float:right;margin-right:10px;background:#26580F;border:1px solid #26580F" class="btn btn-success"><span class="fa fa-file-excel-o"></span></a>

            <button type="button" data-toggle="modal" data-target="#filters" class="btn btn-info" style="float:right;margin-right:10px"><span class="fa fa-filter"></span></button>
        </div>
    <div class="panel-body articles-container">
        <div class="table-responsive">
            <table class="table table-stripped datatable">
                <thead> 
                    <th>#</th>
                    <th class="text-center">Last Name</th>
                    <th class="text-center">First Name</th>
                    <th class="text-center">DOB</th>
                    <th class="text-center">Age</th>
                    
                    <th class="text-center">Gender</th>
                    <th class="text-center">Residence</th>
                    <th class="text-center">Relationship</th>
                    <th class="text-right">Premium</th>
                </thead>
            <tbody> 
            <?php $i=1; $real_total = 0; foreach($employees as $employee) : ?>
            <?php if($i % 2 == 0) : ?>
                <?php $style= 'style="background:#f2f2f2!important"'; ?>
            <?php else : ?>
                <?php $style="" ?>
            <?php endif; ?>
            <?php $i++; ?>
                <?php  foreach($employee->families as $family) : ?>
                    <?php 
                    $age = "N/A";
                    $dob = "N/A";
                        if(!empty($family->dob)){
                            $dob = $family->dob->year."-".$family->dob->month."-".$family->dob->day;
                            $today = date("Y-m-d");
                            $diff = date_diff(date_create($dob), date_create($today));
                            $age = $diff->format('%y');
                        }
                    ?>
                <tr <?= $style ?>>
                    <td><?= $employee->membership_number ?></td>
                    <td class="text-center"><?= $family->last_name ?></td>
                    <td class="text-center"><?= $family->first_name ?></td>
                    <?php if($dob != "N/A") : ?>
                    <td class="text-center"><?= date('M d Y', strtotime($dob)) ?></td>
                <?php  else : ?>
                    <td class="text-center">N/A</td>
                <?php   endif; ?>
                    <td class="text-center"><?= $age ?></td>
                    <td class="text-center"><?= $genders[$family->gender] ?></td>
                    <td class="text-center"><?= $family->country ?></td>
                    <td class="text-center"><?= $relationships[$family->relationship ] ?></td>
                    <td class="text-right"><?= number_format($family->premium, 2, ".", ",") ?></td>
                </tr>
                
            <?php endforeach; ?>
            
            <?php endforeach; ?>
            </tbody>
        </table></div>
            <!--End .article-->
        </div>
        
    </div>
</div><!--End .articles-->

<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({
        'paging': false,
        'ordering' : false
    });
} );</script>

<?php 
echo '<script> var ROOT_DIREC = "'.ROOT_DIREC.'";</script>'
?>
<script type="text/javascript">
    $(document).ready(function(){

        $("#business-id").change(function(){
            $("#grouping-id").empty();
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
                    $("#grouping-id").append("<option value=''>-- Choose --</option>")
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
