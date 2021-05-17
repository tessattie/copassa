<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Policy $policy
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Policy'), ['action' => 'edit', $policy->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Policy'), ['action' => 'delete', $policy->id], ['confirm' => __('Are you sure you want to delete # {0}?', $policy->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Policies'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Policy'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="policies view content">
            <h3><?= h($policy->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Company') ?></th>
                    <td><?= $policy->has('company') ? $this->Html->link($policy->company->name, ['controller' => 'Companies', 'action' => 'view', $policy->company->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Option') ?></th>
                    <td><?= $policy->has('option') ? $this->Html->link($policy->option->name, ['controller' => 'Options', 'action' => 'view', $policy->option->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Customer') ?></th>
                    <td><?= $policy->has('customer') ? $this->Html->link($policy->customer->name, ['controller' => 'Customers', 'action' => 'view', $policy->customer->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Policy Number') ?></th>
                    <td><?= h($policy->policy_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $policy->has('user') ? $this->Html->link($policy->user->name, ['controller' => 'Users', 'action' => 'view', $policy->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($policy->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Mode') ?></th>
                    <td><?= $this->Number->format($policy->mode) ?></td>
                </tr>
                <tr>
                    <th><?= __('Premium') ?></th>
                    <td><?= $this->Number->format($policy->premium) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fee') ?></th>
                    <td><?= $this->Number->format($policy->fee) ?></td>
                </tr>
                <tr>
                    <th><?= __('Active') ?></th>
                    <td><?= $this->Number->format($policy->active) ?></td>
                </tr>
                <tr>
                    <th><?= __('Lapse') ?></th>
                    <td><?= $this->Number->format($policy->lapse) ?></td>
                </tr>
                <tr>
                    <th><?= __('Pending') ?></th>
                    <td><?= $this->Number->format($policy->pending) ?></td>
                </tr>
                <tr>
                    <th><?= __('Grace Period') ?></th>
                    <td><?= $this->Number->format($policy->grace_period) ?></td>
                </tr>
                <tr>
                    <th><?= __('Canceled') ?></th>
                    <td><?= $this->Number->format($policy->canceled) ?></td>
                </tr>
                <tr>
                    <th><?= __('Effective Date') ?></th>
                    <td><?= h($policy->effective_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Paid Until') ?></th>
                    <td><?= h($policy->paid_until) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($policy->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($policy->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Payments') ?></h4>
                <?php if (!empty($policy->payments)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Customer Id') ?></th>
                            <th><?= __('Policy Id') ?></th>
                            <th><?= __('Amount') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Rate Id') ?></th>
                            <th><?= __('Daily Rate') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($policy->payments as $payments) : ?>
                        <tr>
                            <td><?= h($payments->id) ?></td>
                            <td><?= h($payments->customer_id) ?></td>
                            <td><?= h($payments->policy_id) ?></td>
                            <td><?= h($payments->amount) ?></td>
                            <td><?= h($payments->status) ?></td>
                            <td><?= h($payments->user_id) ?></td>
                            <td><?= h($payments->rate_id) ?></td>
                            <td><?= h($payments->daily_rate) ?></td>
                            <td><?= h($payments->created) ?></td>
                            <td><?= h($payments->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Payments', 'action' => 'view', $payments->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Payments', 'action' => 'edit', $payments->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Payments', 'action' => 'delete', $payments->id], ['confirm' => __('Are you sure you want to delete # {0}?', $payments->id)]) ?>
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
