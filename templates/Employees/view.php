<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Employee $employee
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Employee'), ['action' => 'edit', $employee->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Employee'), ['action' => 'delete', $employee->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employee->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Employees'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Employee'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="employees view content">
            <h3><?= h($employee->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Business') ?></th>
                    <td><?= $employee->has('business') ? $this->Html->link($employee->business->name, ['controller' => 'Businesses', 'action' => 'view', $employee->business->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('First Name') ?></th>
                    <td><?= h($employee->first_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Last Name') ?></th>
                    <td><?= h($employee->last_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Membership Number') ?></th>
                    <td><?= h($employee->membership_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Grouping') ?></th>
                    <td><?= $employee->has('grouping') ? $this->Html->link($employee->grouping->id, ['controller' => 'Groupings', 'action' => 'view', $employee->grouping->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($employee->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Deductible') ?></th>
                    <td><?= $this->Number->format($employee->deductible) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($employee->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($employee->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Families') ?></h4>
                <?php if (!empty($employee->families)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('First Name') ?></th>
                            <th><?= __('Last Name') ?></th>
                            <th><?= __('Relationship') ?></th>
                            <th><?= __('Employee Id') ?></th>
                            <th><?= __('Premium') ?></th>
                            <th><?= __('Dob') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($employee->families as $families) : ?>
                        <tr>
                            <td><?= h($families->id) ?></td>
                            <td><?= h($families->first_name) ?></td>
                            <td><?= h($families->last_name) ?></td>
                            <td><?= h($families->relationship) ?></td>
                            <td><?= h($families->employee_id) ?></td>
                            <td><?= h($families->premium) ?></td>
                            <td><?= h($families->dob) ?></td>
                            <td><?= h($families->created) ?></td>
                            <td><?= h($families->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Families', 'action' => 'view', $families->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Families', 'action' => 'edit', $families->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Families', 'action' => 'delete', $families->id], ['confirm' => __('Are you sure you want to delete # {0}?', $families->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
