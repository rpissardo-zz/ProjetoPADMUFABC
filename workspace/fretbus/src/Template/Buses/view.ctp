<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Bus'), ['action' => 'edit', $bus->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Bus'), ['action' => 'delete', $bus->id], ['confirm' => __('Are you sure you want to delete # {0}?', $bus->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Buses'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Bus'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="buses view large-9 medium-8 columns content">
    <h3><?= h($bus->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Code') ?></th>
            <td><?= h($bus->code) ?></td>
        </tr>
        <tr>
            <th><?= __('Company') ?></th>
            <td><?= h($bus->company) ?></td>
        </tr>
        <tr>
            <th><?= __('Photo') ?></th>
            <td><?= h($bus->photo) ?></td>
        </tr>
        <tr>
            <th><?= __('Dir') ?></th>
            <td><?= h($bus->dir) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($bus->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($bus->created) ?></td>
        </tr>
    </table>
</div>
