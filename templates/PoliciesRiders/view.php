<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\PoliciesRider $policiesRider
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Policies Rider'), ['action' => 'edit', $policiesRider->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Policies Rider'), ['action' => 'delete', $policiesRider->id], ['confirm' => __('Are you sure you want to delete # {0}?', $policiesRider->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Policies Riders'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Policies Rider'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="policiesRiders view content">
            <h3><?= h($policiesRider->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Policy') ?></th>
                    <td><?= $policiesRider->has('policy') ? $this->Html->link($policiesRider->policy->id, ['controller' => 'Policies', 'action' => 'view', $policiesRider->policy->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Rider') ?></th>
                    <td><?= $policiesRider->has('rider') ? $this->Html->link($policiesRider->rider->name, ['controller' => 'Riders', 'action' => 'view', $policiesRider->rider->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($policiesRider->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
