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
        <li class="active">Insurance Companies</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="panel panel-default articles">
        <div class="panel-heading">
            Insurance Companies
            <a class="btn btn-warning" style="float:right" href="<?= ROOT_DIREC ?>/companies/add">New</a>
        </div>
    <div class="panel-body articles-container">
            <table class="table table-stripped datatable">
                <thead> 
                    <th>Name</th>
                    <th class="text-center">Type</th>
                    <th class="text-center">Address</th>
                    <th class="text-center">Phone</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Options</th>
                    <th class="text-center">Policies</th>
                    <th class="text-center"></th>
                </thead>
            <tbody> 
            <?php foreach($companies as $company) : ?>
                <?php if($company->country_id == $filter_country || empty($filter_country)) : ?>
                <tr>
                    <td><a href="<?= ROOT_DIREC ?>/companies/view/<?= $company->id ?>"><?= $company->name ?></a></td>
                    <td class="text-center"><?= $company_types[$company->type] ?></td>
                    <td class="text-center"><?= $company->address ?></td>
                    <td class="text-center"><?= $company->phone ?></td>
                    <td class="text-center"><?= $company->email ?></td>
                    <td class="text-center"><span class="label label-warning"><?= count($company->options) ?></span></td>
                    <td class="text-center"><span class="label label-info"><?= count($company->policies) ?></span></td>
                    <td class="text-right">
                        <a href="<?= ROOT_DIREC ?>/companies/edit/<?= $company->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>
                        <?php if(count($company->options) == 0 && count($company->policies) == 0) : ?>
                        <a href="<?= ROOT_DIREC ?>/companies/delete/<?= $company->id ?>" onclick="return confirm('Are you sure you would like to delete the company <?= $company->name ?>')" style="font-size:1.3em!important;margin-left:5px"><span class="fa fa-xl fa-trash color-red"></span></a>
                        <?php endif; ?>
                    </td>
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