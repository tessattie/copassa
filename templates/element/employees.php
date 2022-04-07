<div class="row">
        <div class="col-md-12">
            <div class="panel panel-default articles">
                <div class="panel-heading">
                    Employees
                    <button class="btn btn-info" style="float:right" data-toggle="modal" data-target="#new_employee">New Employee</button>
                </div>
                <div class="panel-body articles-container">       
                    <?php if (!empty($employees)) : ?>
                    <div class="table-responsive">
                    <table class="table table-stripped datatable">
                        <thead> 
                            <th>Full Name</th>
                            <th class="text-center">Group</th>
                            <th class="text-center">Membership / Policy #</th>
                            <th class="text-center">Deductible</th>
                            <th class="text-center">Premium</th>
                            <th class="text-center">Effective Date</th>
                            <th class="text-center">Status</th>
                            <th class="text-left"></th>
                        </thead>
                    <tbody> 
                    <?php $total =0; foreach($employees as $employee) : ?>
                        <?php   
                            $total_premium = 0;
                            if($employee->status == 1){
                                foreach($employee->families as $family){
                                    if($family->status == 1){
                                        $total_premium = $total_premium + $family->premium;
                                    }
                                } 
                            }
                            
                            $total = $total + $total_premium;
                        ?>
                    <tr>
                        <td><a href="<?= ROOT_DIREC ?>/employees/view/<?= $employee->id ?>"><?= $employee->first_name." ".$employee->last_name ?></a></td>
                        <td class="text-center"><a href="<?= ROOT_DIREC ?>/groupings/view/<?= $employee->grouping_id ?>"><?= $employee->grouping->grouping_number ?></a></td>
                        <td class="text-center"><?= $employee->membership_number ?></td>
                        <td class="text-center"><?= number_format($employee->deductible, 2, ".", ",") ?></td>
                        <td class="text-center"><?= number_format($total_premium, 2, ".", ",") ?></td>
                        <td class="text-center"><?= date('F d Y', strtotime($employee->effective_date)) ?></td>
                        <?php if($employee->status == 1) : ?>
                            <td class="text-center"><span class="label label-success">Active</span></td>
                        <?php else : ?>
                            <td class="text-center"><span class="label label-danger">Inactive</span></td>
                        <?php endif; ?>
                        <td class="text-right">
                            <a href="#" style="font-size:1.3em!important;margin-right:4px;color:green" data-toggle="modal" data-target="#view_families_<?= $employee->id ?>"><span class="fa fa-xl fa-eye color-yellow"></span></a>
                            <a href="<?= ROOT_DIREC ?>/employees/edit/<?= $employee->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>
                            <a href="<?= ROOT_DIREC ?>/employees/delete/<?= $employee->id ?>" onclick="return confirm('Are you sure you would like to delete the employee <?= $employee->grouping_number ?>')" style="font-size:1.3em!important;margin-left:5px"><span class="fa fa-xl fa-trash color-red"></span></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                    <tfoot> 
                        <tr> 
                            <th colspan="5">Total</th>
                            <th class="text-center"><?= number_format($total, 2, ".", ",") ?></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>