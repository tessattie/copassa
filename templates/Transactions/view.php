<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Transaction $transaction
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Transaction'), ['action' => 'edit', $transaction->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Transaction'), ['action' => 'delete', $transaction->id], ['confirm' => __('Are you sure you want to delete # {0}?', $transaction->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Transactions'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Transaction'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="transactions view content">
            <h3><?= h($transaction->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Employee') ?></th>
                    <td><?= $transaction->has('employee') ? $this->Html->link($transaction->employee->name, ['controller' => 'Employees', 'action' => 'view', $transaction->employee->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Business') ?></th>
                    <td><?= $transaction->has('business') ? $this->Html->link($transaction->business->name, ['controller' => 'Businesses', 'action' => 'view', $transaction->business->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $transaction->has('user') ? $this->Html->link($transaction->user->name, ['controller' => 'Users', 'action' => 'view', $transaction->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Renewal') ?></th>
                    <td><?= $transaction->has('renewal') ? $this->Html->link($transaction->renewal->id, ['controller' => 'Renewals', 'action' => 'view', $transaction->renewal->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($transaction->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= $this->Number->format($transaction->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Credit') ?></th>
                    <td><?= $this->Number->format($transaction->credit) ?></td>
                </tr>
                <tr>
                    <th><?= __('Debit') ?></th>
                    <td><?= $this->Number->format($transaction->debit) ?></td>
                </tr>
                <tr>
                    <th><?= __('Group Id') ?></th>
                    <td><?= $this->Number->format($transaction->group_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($transaction->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($transaction->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
