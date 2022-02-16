<?php foreach($employees as $employee) : ?>
    <div class="modal fade" id="view_families_<?= $employee->id ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Family Members for <?= $employee->first_name." ".$employee->last_name ?></h5>
      </div>
      <div class="modal-body">
        <table class="table table-stripped datatable">
                <thead> 
                    <th>Full Name</th>
                    <th class="text-center">Relationship</th>
                    <th class="text-center">DOB</th>
                    <th class="text-center">Gender</th>
                    <th class="text-center">Residence</th>
                    <th class="text-center">Premium</th>
                    <th class="text-center">Status</th>
                    <th></th>
                </thead>
            <tbody> 
            <?php $total = 0; foreach($employee->families as $family) : ?>
            <?php  
            if($family->status = 1){
                $total = $total + $family->premium;
            }
            ?>
                <tr>
                    <td><?= $family->first_name." ".$family->last_name ?></td>
                    <td class="text-center"><?= $relationships[$family->relationship] ?></td>
                    <td class="text-center"><?= date("F d Y", strtotime($family->dob)) ?></td>
                    <td class="text-center"><?= $genders[$family->gender] ?></td>
                    <td class="text-center"><?= $family->country ?></td>
                    <td class="text-center"><?= number_format($family->premium,2,".",",") ?></td>
                    <?php if($family->status == 1) : ?>
                        <td class="text-center"><span class="label label-success">Active</span></td>
                    <?php else : ?>
                        <td class="text-center"><span class="label label-danger">Inactive</span></td>
                    <?php endif; ?>
                    <td class="text-right">
                        <a href="<?= ROOT_DIREC ?>/families/edit/<?= $family->id ?>" style="font-size:1.3em!important;"><span class="fa fa-xl fa-pencil color-blue"></span></a>
                        <a href="<?= ROOT_DIREC ?>/families/delete/<?= $family->id ?>" onclick="return confirm('Are you sure you would like to delete the family member <?= $family->first_name." ".$family->last_name ?>')" style="font-size:1.3em!important;margin-left:5px"><span class="fa fa-xl fa-trash color-red"></span></a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr><th colspan="5">Total</th><th class="text-center"><?= number_format($total,2,".",",") ?></th><th></th><th></th></tr>
            </tfoot>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>