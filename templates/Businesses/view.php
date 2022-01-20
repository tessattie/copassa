<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Business $business
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Business'), ['action' => 'edit', $business->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Business'), ['action' => 'delete', $business->id], ['confirm' => __('Are you sure you want to delete # {0}?', $business->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Businesses'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Business'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="businesses view content">
            <h3><?= h($business->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($business->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Business Number') ?></th>
                    <td><?= h($business->business_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($business->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($business->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($business->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Employees') ?></h4>
                <?php if (!empty($business->employees)) : ?>
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
                        <?php foreach ($business->employees as $employees) : ?>
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
            <div class="related">
                <h4><?= __('Related Groupings') ?></h4>
                <?php if (!empty($business->groupings)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Business Id') ?></th>
                            <th><?= __('Grouping Number') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($business->groupings as $groupings) : ?>
                        <tr>
                            <td><?= h($groupings->id) ?></td>
                            <td><?= h($groupings->business_id) ?></td>
                            <td><?= h($groupings->grouping_number) ?></td>
                            <td><?= h($groupings->company_id) ?></td>
                            <td><?= h($groupings->created) ?></td>
                            <td><?= h($groupings->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Groupings', 'action' => 'view', $groupings->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Groupings', 'action' => 'edit', $groupings->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Groupings', 'action' => 'delete', $groupings->id], ['confirm' => __('Are you sure you want to delete # {0}?', $groupings->id)]) ?>
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
