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
    <div class="col-md-12">
        <div class="panel panel-default articles">
        <div class="panel-heading">
            Payments <?= (!empty($policy_id)) ? " : POLICY ".$policy->policy_number." - ".$policy->customer->name : "" ?>
            <a href="<?= ROOT_DIREC ?>/payments/export" style="float:right;margin-top:-27px"><button type="button" class="btn btn-warning" style="margin-top:24px;height:46px">Export</button></a>
        </div>
    <div class="panel-body articles-container">
    <table class="table datable table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th class="text-left">Customer - Policy</th>
                <th class="text-center">Amount</th>
                
                <th class="text-center">Memo</th>
                <th class="text-center">Status</th>
                <th class="text-center">Confirmed</th>
                <th class="text-right">Date</th>
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($payments)) : ?>
                <?php foreach($payments as $p) : ?>
                    <tr>
                        <td><?= 4000+$p->id ?></td>
                        <td class="text-left"><?= $p->customer->name ?> - <strong><?= $p->policy->policy_number ?></strong></td>
                        <td class="text-center"><?= number_format($p->amount, 2, ".", ",")." ".$p->rate->name;  ?></td>
                        
                        
                        <td class="text-center"><?= $p->memo ?></td>
                        <?php if($p->status == 1) : ?>
                            <td class="text-center"><span class="label label-success">Active</span></td>
                        <?php else : ?>
                            <td class="text-center"><span class="label label-success">Canceled</span></td>
                        <?php endif; ?>

                        <?php if($p->confirmed == 1) : ?>
                            <td class="text-center"><span class="label label-success">YES</span></td>
                        <?php else : ?>
                            <td class="text-center"><span class="label label-danger">NO</span></td>
                        <?php endif; ?>
                        <td class="text-right"><?= date('d M Y', strtotime($p->created)); ?></td>
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
