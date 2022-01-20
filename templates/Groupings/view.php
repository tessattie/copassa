<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Grouping $grouping
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Grouping'), ['action' => 'edit', $grouping->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Grouping'), ['action' => 'delete', $grouping->id], ['confirm' => __('Are you sure you want to delete # {0}?', $grouping->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Groupings'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Grouping'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="groupings view content">
            <h3><?= h($grouping->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Business') ?></th>
                    <td><?= $grouping->has('business') ? $this->Html->link($grouping->business->name, ['controller' => 'Businesses', 'action' => 'view', $grouping->business->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Grouping Number') ?></th>
                    <td><?= h($grouping->grouping_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $grouping->has('company') ? $this->Html->link($grouping->company->name, ['controller' => 'Companies', 'action' => 'view', $grouping->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($grouping->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($grouping->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($grouping->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Employees') ?></h4>
                <?php if (!empty($grouping->employees)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Business Id') ?></th>
                            <th><?= __('First Name') ?></th>
                            <th><?= __('Last Name') ?></th>
                            <th><?= __('Membership Number') ?></th>
                            <th><?= __('Deductible') ?></th>
                            <th><?= __('Grouping Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($grouping->employees as $employees) : ?>
                        <tr>
                            <td><?= h($employees->id) ?></td>
                            <td><?= h($employees->business_id) ?></td>
                            <td><?= h($employees->first_name) ?></td>
                            <td><?= h($employees->last_name) ?></td>
                            <td><?= h($employees->membership_number) ?></td>
                            <td><?= h($employees->deductible) ?></td>
                            <td><?= h($employees->grouping_id) ?></td>
                            <td><?= h($employees->created) ?></td>
                            <td><?= h($employees->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Employees', 'action' => 'view', $employees->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Employees', 'action' => 'edit', $employees->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Employees', 'action' => 'delete', $employees->id], ['confirm' => __('Are you sure you want to delete # {0}?', $employees->id)]) ?>
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
