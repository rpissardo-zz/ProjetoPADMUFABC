<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Log'), ['action' => 'edit', $log->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Log'), ['action' => 'delete', $log->id], ['confirm' => __('Are you sure you want to delete # {0}?', $log->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Log'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Log'), ['action' => 'add']) ?> </li>
        <li><?= $this->Html->link(__('List Buses'), ['controller' => 'Buses', 'action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Bus'), ['controller' => 'Buses', 'action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="log view large-9 medium-8 columns content">
    <h3><?= h($log->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th><?= __('Bus') ?></th>
            <td><?= $log->has('bus') ? $this->Html->link($log->bus->id, ['controller' => 'Buses', 'action' => 'view', $log->bus->id]) : '' ?></td>
        </tr>
        <tr>
            <th><?= __('Lat') ?></th>
            <td><?= h($log->lat) ?></td>
        </tr>
        <tr>
            <th><?= __('Lon') ?></th>
            <td><?= h($log->lon) ?></td>
        </tr>
        <tr>
            <th><?= __('Id') ?></th>
            <td><?= $this->Number->format($log->id) ?></td>
        </tr>
        <tr>
            <th><?= __('Created') ?></th>
            <td><?= h($log->created) ?></td>
        </tr>
    </table>
</div>
