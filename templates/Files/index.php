<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\File[]|\Cake\Collection\CollectionInterface $files
 */
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Ressources</li>
    </ol>
</div>

<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Ressources
            <?php if($user_connected['role_id'] != 2 || $auths[44]) : ?>
            <button class="btn btn-warning" style="float:right;margin-left:5px" data-toggle="modal" data-target="#new_folder"><span class="fa fa-folder"></span></button>
            <button class="btn btn-warning" style="float:right;margin-left:5px" data-toggle="modal" data-target="#new_file"><span class="fa fa-file"></span></button>
        <?php  endif; ?>
            <button class="btn btn-info" style="float:right" data-toggle="modal" data-target="#filter"><span class="fa fa-filter"></span></button>
        </div>
    <div class="panel-body articles-container">
        <div class="table-responsive">
            <table class="table table-stripped datatable">
                <thead> 
                    <th>Folder</th>
                    <th>Name</th>
                    <th class="text-center">Description</th>
                    <th class="text-center">Policy</th>
                    <th class="text-center">Claim</th>
                    <?php if($user_connected['role_id'] != 2 || $auths[44]) : ?>
                    <th></th>
                <?php   endif; ?>
                </thead>
            <tbody> 
            <?php foreach($files as $file) : ?>
                <tr>
                    <td><a href="<?= ROOT_DIREC ?>/files/index/<?= $file->folder_id ?>"> <input type="hidden" class="location" value="<?= $file->location ?>"><?= h($file->folder->name) ?></a></td>
                    <td><a href="#" class="download_file"> <input type="hidden" class="location" value="<?= $file->location ?>"><?= h($file->name) ?></a></td>
                    <td class="text-center"><?= h($file->description) ?></td>
                    <?php if(!empty($file->policy_id)) : ?>
                        <td class="text-center"><a href="<?= ROOT_DIREC ?>/policies/view/<?= $file->policy_id ?>"><?= h($file->policy->policy_number) ?></a></td>
                    <?php else : ?>
                        <td></td>
                    <?php endif; ?>
                    <?php if(!empty($file->claim_id)) : ?>
                        <td class="text-center"><a href="<?= ROOT_DIREC ?>/claims/view/<?= $file->claim_id ?>"><?= h($file->claim->title) ?></a></td>
                    <?php else : ?>
                        <td></td>
                    <?php endif; ?>
                    <?php if($user_connected['role_id'] != 2 || $auths[44]) : ?>
                    <td class="text-right">
                        <a href="<?= ROOT_DIREC ?>/files/edit/<?= $file->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>
                        <a href="<?= ROOT_DIREC ?>/files/delete/<?= $file->id ?>" onclick="return confirm('Are you sure you would like to delete the file <?= h($file->name) ?>')" style="font-size:1.3em!important;margin-left:5px"><span class="fa fa-xl fa-trash color-red"></span></a>
                    </td>
                <?php   endif; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table></div>
            <!--End .article-->
        </div>
        
    </div>
</div><!--End .articles-->

<?php 
    echo '<script> var ROOT_DIREC = "'.ROOT_DIREC.'";</script>'
?>

<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({

    } );

    $(".download_file").click(function(){
        var location = $(this).find(".location").val(); 
        var token =  $('input[name="_csrfToken"]').val();
            var company = $(this).val();
            $.ajax({
                 url : ROOT_DIREC+'/files/download',
                 type : 'POST',
                 data : {location : location},
                 headers : {
                    'X-CSRF-Token': token 
                 },
                 success : function(data, statut){
                      var win = window.open(data, '_blank');
                      if (win) {
                            win.focus();
                        } else {
                            alert('Please allow popups for this website');
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



<div class="modal fade" id="new_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New File</h5>
      </div>
      <?= $this->Form->create(null, array("url" => '/files/add', 'type' => 'file')) ?>
      <div class="modal-body">
            <div class="row">
                <div class="col-md-6"><?= $this->Form->control('folder_id', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $folders, "label" => "Folder", "multiple" => false, 'required' => true, 'style' => "height:46px")); ?></div> 
                <div class="col-md-6"><?= $this->Form->control('name', array('class' => 'form-control', "label" => "Name *", "placeholder" => "File Name")); ?></div>

            </div>

            <hr>
            <div class="row">
                <div class="col-md-12"><?= $this->Form->control('description', array('class' => 'form-control', "label" => "Description *", "placeholder" => "Description")); ?></div>
            </div>
            <hr>
            <div class="row" style="margin-top:10px">
                    <div class="col-md-12">
                      <div class="form-group">
                        <label for="exampleInputFile">File</label>
                        <input type="file" id="exampleInputFile" name="file">
                        <p class="help-block">Upload File here.</p>
                      </div>
                    </div>
                    </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Add</button>
      </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>


<div class="modal fade" id="new_folder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New Folder</h5>
      </div>
      <?= $this->Form->create(null, array("url" => '/folders/add')) ?>
      <div class="modal-body">
            <div class="row">
                <div class="col-md-12"><?= $this->Form->control('name', array('class' => 'form-control', "label" => "Name *", "placeholder" => "Folder Name")); ?></div>
            </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Add</button>
      </div>
      <?= $this->Form->end() ?>
    </div>
  </div>
</div>

<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <?= $this->Form->control('folder_id', array('class' => 'form-control', "empty" => '-- Choose --', 'options' => $folders, "label" => "Folder", "multiple" => false,  'style' => "height:46px", 'value' => $folder_id)); ?>
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