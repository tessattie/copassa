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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $element->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $element->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Elements'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="elements form content">
            <?= $this->Form->create($element) ?>
            <fieldset>
                <legend><?= __('Edit Element') ?></legend>
                <?php
                    echo $this->Form->control('name');
                    echo $this->Form->control('title');
                    echo $this->Form->control('subtitle');
                    echo $this->Form->control('video');
                    echo $this->Form->control('photo');
                    echo $this->Form->control('text');
                    echo $this->Form->control('position');
                    echo $this->Form->control('category_id', ['options' => $categories]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
