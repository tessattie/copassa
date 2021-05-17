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
            <ul class="pull-right panel-settings panel-button-tab-right">
                <li class="dropdown"><a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                    <em class="fa fa-plus"></em>
                </a>
                    <ul class="dropdown-menu dropdown-menu-right">
                        <li>
                            <ul class="dropdown-settings">
                                <li><a href="<?= ROOT_DIREC ?>/policies/add">
                                    <em class="fa fa-plus"></em> New Policy
                                </a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    <div class="panel-body articles-container">
        <div style="">
            <table class="table table-striped datatable">
                <thead> 
                    <th class="text-center">Number</th>
                    <th class="text-center">Holder</th>
                    <th class="text-center">Company</th>
                    <th class="text-center">Premium</th>
                    <th class="text-center">Mode</th>
                    <th class="text-center">Effective</th>
                    <th class="text-center">Paid until</th>
                    <th class="text-center">A</th>
                    <th class="text-center">L</th>
                    <th class="text-center">P</th>
                    <th class="text-center">GP</th>
                    <th class="text-center">C</th>
                    <th>    </th>
                </thead>
            <tbody> 
        <?php foreach($policies as $policy) : ?>
            <tr>
                <td class="text-center"><?= $policy->policy_number ?></td>
                <td class="text-center"><?= $policy->customer->name ?></td>
                <td class="text-center"><?= $policy->company->name . " / ".  $policy->option->name ?></td>
                <td class="text-center"><?= number_format($policy->premium,2,".",",") ?></td>
                <td class="text-center"><?= $modes[$policy->mode] ?></td>
                <td class="text-center"><?= date("M d Y", strtotime($policy->effective_date)) ?></td>
                <td class="text-center"><?= date("M d Y", strtotime($policy->paid_until)) ?></td>
                <?php if($policy->active == 1) : ?>
                    <td class="text-center"><span class="label label-success">Yes</span></td>
                <?php else : ?>
                    <td class="text-center"><span class="label label-danger">No</span></td>
                <?php endif; ?>

                <?php if($policy->lapse == 1) : ?>
                    <td class="text-center"><span class="label label-success">Yes</span></td>
                <?php else : ?>
                    <td class="text-center"><span class="label label-danger">No</span></td>
                <?php endif; ?>

                <?php if($policy->pending == 1) : ?>
                    <td class="text-center"><span class="label label-success">Yes</span></td>
                <?php else : ?>
                    <td class="text-center"><span class="label label-danger">No</span></td>
                <?php endif; ?>

                <?php if($policy->grace_period == 1) : ?>
                    <td class="text-center"><span class="label label-success">Yes</span></td>
                <?php else : ?>
                    <td class="text-center"><span class="label label-danger">No</span></td>
                <?php endif; ?>
                <?php if($policy->canceled == 1) : ?>
                    <td class="text-center"><span class="label label-success">Yes</span></td>
                <?php else : ?>
                    <td class="text-center"><span class="label label-danger">No</span></td>
                <?php endif; ?>

                <td class="text-right"><a href="<?= ROOT_DIREC ?>/policies/edit/<?= $policy->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>
                <a href="<?= ROOT_DIREC ?>/policies/delete/<?= $policy->id ?>" onclick="return confirm('Are you sure you would like to delete the policy <?= $policy->policy_number ?>')" style="font-size:1.3em!important;margin-left:5px"><span class="fa fa-xl fa-trash color-red"></span></a>
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
