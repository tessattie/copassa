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
        <li>Policies</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Policies
            <a class="btn btn-warning" style="float:right" href="<?= ROOT_DIREC ?>/policies/add">New</a>
        </div>
    <div class="panel-body articles-container">
        <div style="">
            <table class="table table-striped datatable">
                <thead> 
                    <th class="text-left">Number</th>
                    <th class="text-center">Holder</th>
                    <th class="text-center">Country</th>
                    <th class="text-center">Company</th>
                    <th class="text-center">Premium</th>

                    <th class="text-center">Mode</th>
                    <th></th>
                </thead>
            <tbody> 
        <?php foreach($policies as $policy) : ?>
            <tr>
                <td class="text-left"><a href="<?= ROOT_DIREC ?>/policies/view/<?= $policy->id ?>"><?= $policy->policy_number ?></a></td>
                <td class="text-center"><?= $policy->customer->name ?></td>
                <td class="text-center"><?= $policy->customer->country->name ?></td>
                <?php if(!empty($policy->company)) : ?>
                    <?php if(!empty($policy->option)) : ?>
                    <td class="text-center"><?= $policy->company->name . " / ".  $policy->option->name ?></td>
                    <?php else : ?>
                        <td class="text-center"><?= $policy->company->name ?></td>
                    <?php endif; ?>
                <?php else : ?>
                    <?php if(!empty($policy->option)) : ?>
                    <td class="text-center"><?= $policy->option->name ?></td>
                    <?php else : ?>
                        <td class="text-center"></td>
                    <?php endif; ?>
                <?php endif; ?>
                
                <td class="text-center"><?= number_format($policy->premium,2,".",",") ?></td>
                <td class="text-center"><?= $modes[$policy->mode] ?></td>
            
                <td class="text-right">
                    <a href="<?= ROOT_DIREC ?>/policies/edit/<?= $policy->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>
                    <?php if(empty($policy->dependants) && empty($policy->prenewals)) : ?>
                    <a href="<?= ROOT_DIREC ?>/policies/delete/<?= $policy->id ?>" onclick="return confirm('Are you sure you would like to delete the policy <?= $policy->policy_number ?>')" style="font-size:1.3em!important;margin-left:5px"><span class="fa fa-xl fa-trash color-red"></span></a>
                <?php endif; ?>
                </td>

            </tr>
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
</style>
