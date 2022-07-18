<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CountriesAgent[]|\Cake\Collection\CollectionInterface $countriesAgents
 */
?>
<div class="countriesAgents index content">
    <?= $this->Html->link(__('New Countries Agent'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Countries Agents') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('country_id') ?></th>
                    <th><?= $this->Paginator->sort('agent_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($countriesAgents as $countriesAgent): ?>
                <tr>
                    <td><?= $this->Number->format($countriesAgent->id) ?></td>
                    <td><?= $countriesAgent->has('country') ? $this->Html->link($countriesAgent->country->name, ['controller' => 'Countries', 'action' => 'view', $countriesAgent->country->id]) : '' ?></td>
                    <td><?= $countriesAgent->has('agent') ? $this->Html->link($countriesAgent->agent->name, ['controller' => 'Agents', 'action' => 'view', $countriesAgent->agent->id]) : '' ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $countriesAgent->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $countriesAgent->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $countriesAgent->id], ['confirm' => __('Are you sure you want to delete # {0}?', $countriesAgent->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
