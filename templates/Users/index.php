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
        <li class="active">Users</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Users
            <a href="<?= ROOT_DIREC ?>/users/add" style="float:right"><button class="btn btn-warning">Add</button></a>
        </div>
    <div class="panel-body articles-container">
        <div class="table-responsive">
            <table class="table table-stripped datatable">
                <thead> 
                    <th>Name</th>
                    <th class="text-center">Username</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Access</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Created</th>
                    <th class="text-center"></th>
                </thead>
            <tbody> 
        <?php foreach($users as $user) : ?>
                <tr>
                    <td><?= $user->name ?></td>
                    <td class="text-center"><?= $user->username ?></td>
                    <td class="text-center"><?= $user->email ?></td>
                    <td class="text-center"><?= $user->role->name ?></td>
                    <?php if($user->status == 1) : ?>
                        <td class="text-center">  <span class="label label-success"> <?= $status[$user->status] ?></span></td>
                    <?php else : ?>
                        <td class="text-center">  <span class="label label-danger"> <?= $status[$user->status] ?></span></td>
                    <?php endif; ?>
                    <td class="text-center"><?= $user->created ?></td>
                    <td class="text-right"><a href="<?= ROOT_DIREC ?>/users/edit/<?= $user->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>
                    <a href="<?= ROOT_DIREC ?>/users/delete/<?= $user->id ?>" style="font-size:1.3em!important;margin-left:5px"><span class="fa fa-xl fa-trash color-red"></span></a>
                    </td>
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