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
        <li class="active">Countries</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Countries
            <a class="btn btn-warning" style="float:right" href="<?= ROOT_DIREC ?>/countries/add">New</a>
        </div>
    <div class="panel-body articles-container">
        <div class="table-responsive">
            <table class="table table-stripped datatable">
                <thead> 
                    <th>Name</th>
                    <th class="text-center">Policy Holders</th>
                    <th class="text-center"></th>
                </thead>
            <tbody> 
            <?php foreach($countries as $country) : ?>
                <tr>
                    <td><?= $country->name ?></td>
                    <td class="text-center"><span class="label label-info"><?= count($country->customers) ?></span></td>
                    <td class="text-right">
                        <a href="<?= ROOT_DIREC ?>/countries/edit/<?= $country->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>
                        <?php if(count($country->customers) == 0) : ?>
                        <a href="<?= ROOT_DIREC ?>/countries/delete/<?= $country->id ?>" onclick="return confirm('Are you sure you would like to delete the country <?= $country->name ?>')" style="font-size:1.3em!important;margin-left:5px"><span class="fa fa-xl fa-trash color-red"></span></a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
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