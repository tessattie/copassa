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
        <li class="active">Company</li>
        <li class="active">Options</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Companies
            <ul class="pull-right panel-settings panel-button-tab-right">
                            <li class="dropdown"><a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                                <em class="fa fa-plus"></em>
                            </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <ul class="dropdown-settings">
                                            <li><a href="<?= ROOT_DIREC ?>/companies/add">
                                                <em class="fa fa-plus"></em> New Company
                                            </a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
        </div>
    <div class="panel-body articles-container">
            <table class="table table-bordered">
                <thead> 
                    <th>Name</th>
                    <th class="text-center">Type</th>
                    <th class="text-center">Option</th>
                </thead>
            <tbody> 
        <?php foreach($companies as $company) : ?>
            <?php if(count($company->options) > 1) : ?>
                <tr>
                    <td rowspan="<?= count($company->options) ?>"><?= h($company->name) ?></td>
                </tr>
                <?php foreach($company->options as $option) : ?>
                    <tr>
                        <td class="text-center"><?= h($company_types[$company->type]) ?></td>
                        <td class="text-center"><?= h($option->name) ?></td>
                    </tr>
                <?php endforeach; ?>
                
                <?php else : ?>
                    <tr>
                    <td><?= h($company->name ?></td>
                    <td class="text-center"><?= h($company_types[$company->type]) ?></td>
                
                <?php foreach($company->options as $option) : ?>
                        <td class="text-center"><?= h($option->name) ?></td>
                <?php endforeach; ?>
                </tr>
                <?php endif; ?>
        <?php endforeach; ?>
        </tbody>
        </table>
            <!--End .article-->
        </div>
        
    </div>
</div><!--End .articles-->

<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'excel', 'pdf', 'print'
        ]
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