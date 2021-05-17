<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Option $option
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Option'), ['action' => 'edit', $option->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Option'), ['action' => 'delete', $option->id], ['confirm' => __('Are you sure you want to delete # {0}?', $option->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Options'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Option'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="options view content">
            <h3><?= h($option->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($option->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $option->has('company') ? $this->Html->link($option->company->name, ['controller' => 'Companies', 'action' => 'view', $option->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $option->has('user') ? $this->Html->link($option->user->name, ['controller' => 'Users', 'action' => 'view', $option->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($option->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($option->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($option->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Policies') ?></h4>
                <?php if (!empty($option->policies)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Company Id') ?></th>
                            <th><?= __('Option Id') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Policy Number') ?></th>
                            <th><?= __('Mode') ?></th>
                            <th><?= __('Effective Date') ?></th>
                            <th><?= __('Paid Until') ?></th>
                            <th><?= __('Premium') ?></th>
                            <th><?= __('Fee') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Active') ?></th>
                            <th><?= __('Lapse') ?></th>
                            <th><?= __('Pending') ?></th>
                            <th><?= __('Grace Period') ?></th>
                            <th><?= __('Canceled') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($option->policies as $policies) : ?>
                        <tr>
                            <td><?= h($policies->id) ?></td>
                            <td><?= h($policies->company_id) ?></td>
                            <td><?= h($policies->option_id) ?></td>
                            <td><?= h($policies->customer_id) ?></td>
                            <td><?= h($policies->policy_number) ?></td>
                            <td><?= h($policies->mode) ?></td>
                            <td><?= h($policies->effective_date) ?></td>
                            <td><?= h($policies->paid_until) ?></td>
                            <td><?= h($policies->premium) ?></td>
                            <td><?= h($policies->fee) ?></td>
                            <td><?= h($policies->user_id) ?></td>
                            <td><?= h($policies->active) ?></td>
                            <td><?= h($policies->lapse) ?></td>
                            <td><?= h($policies->pending) ?></td>
                            <td><?= h($policies->grace_period) ?></td>
                            <td><?= h($policies->canceled) ?></td>
                            <td><?= h($policies->created) ?></td>
                            <td><?= h($policies->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Policies', 'action' => 'view', $policies->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Policies', 'action' => 'edit', $policies->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Policies', 'action' => 'delete', $policies->id], ['confirm' => __('Are you sure you want to delete # {0}?', $policies->id)]) ?>
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
