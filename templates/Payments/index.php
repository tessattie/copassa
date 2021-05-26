<?php
    /**
     * @var \App\View\AppView $this
     * @var \App\Model\Entity\Payment[]|\Cake\Collection\CollectionInterface $payments
     */
    $rates = array(1=>"HTG", 2=>"USD");
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/sales/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Payments</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
<div class="row">
    <div class="col-md-4">
        <div class="panel panel-default articles">
        <div class="panel-heading">
            Payments
        </div>
    <div class="panel-body articles-container">
            <table class="datatable">
                <thead>
                    <tr><th>Policy</th></tr>
                </thead>
                <tbody>
                    <?php foreach($policies as $pp) : ?>
                        <tr>
                            <th><a href="<?= ROOT_DIREC ?>/payments/index/<?= $pp->id ?>"><?= $pp->policy_number . " - " . $pp->customer->name ?></a></th>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    </div>
    <div class="col-md-8">
        <div class="panel panel-default articles">
        <div class="panel-heading">
            Payments <?= (!empty($policy_id)) ? " : POLICY ".$policy->policy_number." - ".$policy->customer->name : "" ?>
            <?php if(!empty($policy_id)) : ?>
            <ul class="pull-right panel-settings panel-button-tab-right">
                            <li class="dropdown"><a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
                                <em class="fa fa-plus"></em>
                            </a>

                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li>
                                        <ul class="dropdown-settings">
                                        
                                            <li><a href="<?= ROOT_DIREC ?>/payments/add/<?= $policy->id ?>">
                                                <em class="fa fa-plus"></em> New Payment
                                            </a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <?php endif; ?>
        </div>
    <div class="panel-body articles-container">
    <table class="table datable table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th class="text-center">Amount</th>
                <th class="text-center">Date</th>
                <th class="text-center">Created by</th>
                <th class="text-center">Rate</th>
                <th class="text-center">Memo</th>
                <th class="text-center">Status</th>
                <th class="text-center">Confirmed</th>
                <th class="text-right"></th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($payments)) : ?>
                <?php foreach($payments as $p) : ?>
                    <tr>
                        <td><?= 4000+$p->id ?></td>
                        <td class="text-center"><?= number_format($p->amount, 2, ".", ",")." ".$p->rate->name;  ?></td>
                        <td class="text-center"><?= date('d M Y', strtotime($p->created)); ?></td>
                        <td class="text-center"><?= $p->user->name ?></td>
                        <td class="text-center"><?= $p->daily_rate ?></td>
                        <td class="text-center"><?= $p->memo ?></td>
                        <?php if($p->status == 1) : ?>
                            <td class="text-center"><span class="label label-success">YES</span></td>
                        <?php else : ?>
                            <td class="text-center"><span class="label label-success">NO</span></td>
                        <?php endif; ?>

                        <?php if($p->confirmed == 1) : ?>
                            <td class="text-center"><span class="label label-success">YES</span></td>
                        <?php else : ?>
                            <td class="text-center"><span class="label label-danger">NO</span></td>
                        <?php endif; ?>
                        <td class="text-right">
                            <a href="<?= ROOT_DIREC ?>/payments/edit/<?= $p->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a> 
                            <a target="_blank" href="<?= ROOT_DIREC ?>/payments/receipt/<?= $p->id ?>" style="font-size:1.3em!important;color:green"> <span class="fa fa-xl fa-eye color-yellow"></span></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
            <!--End .article-->
        </div>
    </div>
    </div>
</div>
    
</div><!--End .articles-->



<script type="text/javascript">$(document).ready( function () {
    $('.datatable').DataTable({
        scrollY: "400px",
        scrollCollapse: true,
        paging: false,
        "language": {
            "search": "",
            "searchPlaceholder": "Search"
        }
    });
} );</script>

<style type="text/css">
    #DataTables_Table_0_filter, #DataTables_Table_0_filter label, #DataTables_Table_0_filter input{
        width:100%;
        margin-right:9px;
    }
    #DataTables_Table_0_filter input{
        border: 1px solid #ddd;
    padding: 10px;
    }
    a:hover{
        font-weight:bold;
    }
    .boldcustomer{
        font-weight:bold;
        background:#f2f2f2!important;
    }
</style>
