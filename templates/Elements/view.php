<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Element $element
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Element'), ['action' => 'edit', $element->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Element'), ['action' => 'delete', $element->id], ['confirm' => __('Are you sure you want to delete # {0}?', $element->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Elements'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Element'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="elements view content">
            <h3><?= h($element->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($element->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Title') ?></th>
                    <td><?= h($element->title) ?></td>
                </tr>
                <tr>
                    <th><?= __('Subtitle') ?></th>
                    <td><?= h($element->subtitle) ?></td>
                </tr>
                <tr>
                    <th><?= __('Video') ?></th>
                    <td><?= h($element->video) ?></td>
                </tr>
                <tr>
                    <th><?= __('Photo') ?></th>
                    <td><?= h($element->photo) ?></td>
                </tr>
                <tr>
                    <th><?= __('Text') ?></th>
                    <td><?= h($element->text) ?></td>
                </tr>
                <tr>
                    <th><?= __('Category') ?></th>
                    <td><?= $element->has('category') ? $this->Html->link($element->category->name, ['controller' => 'Categories', 'action' => 'view', $element->category->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($element->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Position') ?></th>
                    <td><?= $this->Number->format($element->position) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
