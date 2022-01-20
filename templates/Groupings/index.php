<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Grouping[]|\Cake\Collection\CollectionInterface $groupings
 */
?>
<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Groups</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Groups
            <ul class="pull-right panel-settings panel-button-tab-right">
                <li class="dropdown"><a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                    <em class="fa fa-plus"></em>
                </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li>
                            <ul class="dropdown-settings">
                                <li><a href="<?= ROOT_DIREC ?>/groupings/add">
                                    <em class="fa fa-plus"></em> New Group
                                </a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    <div class="panel-body articles-container">
            <table class="table table-stripped datatable">
                <thead> 
                    <th>#</th>
                    <th>Company</th>
                    <th>Insurance</th>
                    <th class="text-left"></th>
                </thead>
            <tbody> 
            <?php foreach($groupings as $group) : ?>
                <tr>
                    <td><?= $group->grouping_number ?></td>
                    <td><?= $group->business->name ?></td>
                    <td><?= $group->company->name ?></td>
                    <td class="text-right">
                        <a href="<?= ROOT_DIREC ?>/groupings/edit/<?= $group->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>
                        <a href="<?= ROOT_DIREC ?>/groupings/delete/<?= $group->id ?>" onclick="return confirm('Are you sure you would like to delete the group <?= $group->grouping_number ?>')" style="font-size:1.3em!important;margin-left:5px"><span class="fa fa-xl fa-trash color-red"></span></a>
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
