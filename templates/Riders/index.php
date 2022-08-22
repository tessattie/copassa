<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Riders</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Riders
            <?php if($user_connected['role_id'] != 2 || ($authorizations[50])) : ?>
            <a href="<?= ROOT_DIREC ?>/riders/add" style="float:right"><button class="btn btn-warning">Add</button></a>
            <?php endif; ?>
        </div>
    <div class="panel-body articles-container">
        <div class="table-responsive">
            <table class="table table-stripped datatable">
                <thead> 
                    <th>Name</th>
                    <?php if($user_connected['role_id'] != 2 || ($authorizations[50])) : ?>
                    <th class="text-center"></th>
                    <?php endif; ?>
                </thead>
            <tbody> 
        <?php foreach($riders as $rider) : ?>
            <tr>
                <td><?= h($rider->name) ?></td>
                <?php if($user_connected['role_id'] != 2 || ($authorizations[50])) : ?>
                <td class="text-right"><a href="<?= ROOT_DIREC ?>/riders/edit/<?= $rider->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>
                <a href="<?= ROOT_DIREC ?>/riders/delete/<?= $rider->id ?>" style="font-size:1.3em!important;margin-left:5px"><span class="fa fa-xl fa-trash color-red"></span></a>
                </td>
                <?php endif; ?>
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