<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\CountriesAgent $countriesAgent
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Countries Agent'), ['action' => 'edit', $countriesAgent->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Countries Agent'), ['action' => 'delete', $countriesAgent->id], ['confirm' => __('Are you sure you want to delete # {0}?', $countriesAgent->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Countries Agents'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Countries Agent'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="countriesAgents view content">
            <h3><?= h($countriesAgent->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Country') ?></th>
                    <td><?= $countriesAgent->has('country') ? $this->Html->link($countriesAgent->country->name, ['controller' => 'Countries', 'action' => 'view', $countriesAgent->country->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Agent') ?></th>
                    <td><?= $countriesAgent->has('agent') ? $this->Html->link($countriesAgent->agent->name, ['controller' => 'Agents', 'action' => 'view', $countriesAgent->agent->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($countriesAgent->id) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
