<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Folder[]|\Cake\Collection\CollectionInterface $folders
 */
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Folders</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Folders
            <?php if($user_connected['role_id'] != 2 || $auths[44]) : ?>
            <button class="btn btn-warning" style="float:right" data-toggle="modal" data-target="#new_folder">New</button>
            <?php endif; ?>
        </div>
    <div class="panel-body articles-container">
        <div class="table-responsive">
            <table class="table table-stripped datatable">
                <thead> 
                    <th>Name</th>
                    <?php if($user_connected['role_id'] != 2 || $auths[44]) : ?>
                    <th></th>
                <?php endif; ?>
                </thead>
            <tbody> 
            <?php foreach($folders as $folder) : ?>
                <tr>
                    <td><?= h($folder->name) ?></td>
                    <?php if($user_connected['role_id'] != 2 || $auths[44]) : ?>
                    <td class="text-right">

                        <a href="<?= ROOT_DIREC ?>/folders/edit/<?= $folder->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>
                        <?php if(empty($folder->files) && $folder->is_claims != 2 && $folder->is_policies != 2) : ?>
                        <a href="<?= ROOT_DIREC ?>/folders/delete/<?= $folder->id ?>" onclick="return confirm('Are you sure you would like to delete the folder <?= h($folder->name) ?>')" style="font-size:1.3em!important;margin-left:5px"><span class="fa fa-xl fa-trash color-red"></span></a>
                        <?php endif; ?>
                    </td>
                <?php  endif; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table></div>
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