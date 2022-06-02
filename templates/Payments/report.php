<?php
    /**
     * @var \App\View\AppView $this
     * @var \App\Model\Entity\Payment[]|\Cake\Collection\CollectionInterface $payments
     */
    $rates = array(1=>"HTG", 2=>"USD");
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li class="active">Reports</li>
        <li class="active">Payments</li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default articles">
        <div class="panel-heading">Payments
            <a target="_blank" href="<?= ROOT_DIREC ?>/payments/export" style="float:right;margin-bottom:7px"><button type="button" class="btn btn-warning" style="height:46px"><span class="fa fa-download"></span></button></a>
        </div>
    <div class="panel-body articles-container">
        <div class="table-responsive">
    <table class="table datatable table-striped">
        <thead>
            <tr>
                <th>#</th>
                
                <th class="text-center">Policy Holder</th>
                <th class="text-center">Policy Number</th>
                <th class="text-center">Company</th>
                
                <th class="text-center">Amount</th>
                <th class="text-center">Payment Date</th>
                <th class="text-center">Due Date</th>
                <th class="text-right">Memo</th>
                
            </tr>
        </thead>
        <tbody>
            <?php if(!empty($payments)) : ?>
                <?php foreach($payments as $p) : ?>
                    <?php if($p->policy->customer->country_id == $filter_country || empty($filter_country)) : ?>
                    <tr>
                        <td><?= 4000+$p->id ?></td>
                        
                        <td class="text-center"><?= $p->policy->customer->name ?></td>
                        <td class="text-center"><strong><?= $p->policy->policy_number ?></strong></td>
                        <td class="text-center"><?= $p->policy->company->name ?></td>
                        
                        <td class="text-center"><?= number_format($p->premium, 2, ".", ",")  ?></td>
                        <td class="text-center"><?= date('M d Y', strtotime($p->payment_date)); ?></td>
                        <td class="text-center"><?= date("M d Y", strtotime($p->renewal_date)) ?></td>
                        <td class="text-right"><?= $p->memo ?></td>
                    </tr>
                <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table></div>
            <!--End .article-->
        </div>
    </div>
    </div>
</div>
    
</div><!--End .articles-->

<script type="text/javascript">
    $(document).ready( function () {
        $('.datatable').DataTable({
        });
    });
</script>

<style type="text/css">

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
