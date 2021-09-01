<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Company $company
 */
?>

<div class="row" style="margin-bottom:15px">
    <ol class="breadcrumb">
        <li><a href="<?= ROOT_DIREC ?>/policies/dashboard">
            <em class="fa fa-home"></em>
        </a></li>
        <li><a href="<?= ROOT_DIREC ?>/companies">Companies</a></li>
        <li><?= $company->name ?></li>
    </ol>
</div>
<?= $this->Flash->render() ?>
<div class="container-fluid"> 
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default articles">
                <div class="panel-heading">
                    Company <?= $company->name ?>
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
                 <table class="table table-striped">
                    <tr>
                        <th><?= __('Name') ?></th>
                        <td class="text-right"><?= h($company->name) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Type') ?></th>
                        <td class="text-right"><?= $company_types[$company->type] ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Address') ?></th>
                        <td class="text-right"><?= h($company->address) ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Email') ?></th>
                        <td class="text-right"><?= $company->email ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Phone') ?></th>
                        <td class="text-right"><?= $company->phone ?></td>
                    </tr>
                    <tr>
                        <th><?= __('Policies') ?></th>
                        <td class="text-right"><?= count($company->policies) ?></td>
                    </tr>
                </table>
            </div>
                
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default articles">
                        <div class="panel-heading">
                            Policies
                        </div>

                        <div class="panel-body articles-container">
                            <table class="table table-bordered" style="width:2000px">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th class="text-center">Customer</th>
                                        <th class="text-center">Option</th>
                                        <th class="text-center">Premium</th>
                                        <th class="text-center">Fee</th>
                                        <th class="text-center">Deductible</th>
                                        <th class="text-center">Mode</th>
                                        <th class="text-center">Effective date</th>
                                        <th class="text-center">Paid until</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($company->policies as $policy) : ?>
                                        <?php 
                                        //Today's date.
                                        $pu = new \DateTime($policy->paid_until);

                                        //Subtract a day using DateInterval
                                        $yesterday = $pu->sub(new \DateInterval('P1D'));

                                        //Get the date in a YYYY-MM-DD format.
                                        $paiduntil = $yesterday->format('Y-m-d');

                                        ?>
                                    <tr>
                                        <td class="text-center"><a href="<?= ROOT_DIREC ?>/policies/view/<?= $policy->id ?>"><?= $policy->policy_number ?></a></td>
                                        <td class="text-center"><a href="<?= ROOT_DIREC ?>/customers/view/<?= $policy->customer_id ?>"><?= $policy->customer->name ?></a></td>
                                        <td class="text-center"><?= $policy->option->name ?></td>
                                        <td class="text-center"><?= number_format($policy->premium,2,".",",") ?> USD</td>
                                        <td class="text-center"><?= number_format($policy->fee,0,".",",") ?> USD</td>
                                        <td class="text-center"><?= number_format($policy->deductible,0,".",",") ?> USD</td>
                                        <td class="text-center"><?= $modes[$policy->mode] ?></td>
                                        <td class="text-center"><?= date("M d Y", strtotime($policy->effective_date)) ?></td>
                                        <td class="text-center"><?= date("M d Y", strtotime($policy->paid_until)) ?></td>
                                        <td class="text-center"><a href="<?= ROOT_DIREC ?>/policies/edit/<?= $policy->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>