<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Prenewal $prenewal
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Prenewal'), ['action' => 'edit', $prenewal->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Prenewal'), ['action' => 'delete', $prenewal->id], ['confirm' => __('Are you sure you want to delete # {0}?', $prenewal->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Prenewals'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Prenewal'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="prenewals view content">
            <h3><?= h($prenewal->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Policy') ?></th>
                    <td><?= $prenewal->has('policy') ? $this->Html->link($prenewal->policy->policy_number, ['controller' => 'Policies', 'action' => 'view', $prenewal->policy->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($prenewal->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Premium') ?></th>
                    <td><?= $this->Number->format($prenewal->premium) ?></td>
                </tr>
                <tr>
                    <th><?= __('Fee') ?></th>
                    <td><?= $this->Number->format($prenewal->fee) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td><?= $this->Number->format($prenewal->status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Policy Status') ?></th>
                    <td><?= $this->Number->format($prenewal->policy_status) ?></td>
                </tr>
                <tr>
                    <th><?= __('Renewal Date') ?></th>
                    <td><?= h($prenewal->renewal_date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($prenewal->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($prenewal->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
