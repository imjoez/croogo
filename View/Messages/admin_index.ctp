<div class="messages index">
    <h2><?php echo $title_for_layout; ?></h2>

    <div class="actions">
        <ul>
            <li><?php echo $this->Html->link(__('Unread'), array('action'=>'index', 'filter' => 'status:0;')); ?></li>
            <li><?php echo $this->Html->link(__('Read'), array('action'=>'index', 'filter' => 'status:1;')); ?></li>
        </ul>
    </div>

    <?php
    	if (isset($this->params['named'])) {
            foreach ($this->params['named'] AS $nn => $nv) {
                $this->Paginator->options['url'][] = $nn . ':' . $nv;
            }
        }
    ?>

    <?php echo $this->Form->create('Message', array('url' => array('controller' => 'messages', 'action' => 'process'))); ?>
    <table cellpadding="0" cellspacing="0">
    <?php
        $tableHeaders =  $this->Html->tableHeaders(array(
            '',
            $this->Paginator->sort('id'),
            $this->Paginator->sort('contact_id'),
            $this->Paginator->sort('name'),
            $this->Paginator->sort('email'),
            $this->Paginator->sort('title'),
            '',
            __('Actions'),
        ));
        echo $tableHeaders;

        $rows = array();
        foreach ($messages AS $message) {
            $actions  = $this->Html->link(__('Edit'), array('action' => 'edit', $message['Message']['id']));
            $actions .= ' ' . $this->Layout->adminRowActions($message['Message']['id']);
            $actions .= ' ' . $this->Html->link(__('Delete'), array(
                'action' => 'delete',
                $message['Message']['id'],
                'token' => $this->params['_Token']['key'],
            ), null, __('Are you sure?'));

            $rows[] = array(
                $this->Form->checkbox('Message.'.$message['Message']['id'].'.id'),
                $message['Message']['id'],
                $message['Contact']['title'],
                $message['Message']['name'],
                $message['Message']['email'],
                $message['Message']['title'],
                $this->Html->image('/img/icons/comment.png'),
                $actions,
            );
        }

        echo $this->Html->tableCells($rows);
        echo $tableHeaders;
    ?>
    </table>
    <div class="bulk-actions">
    <?php
        echo $this->Form->input('Message.action', array(
            'label' => false,
            'options' => array(
                'read' => __('Mark as read'),
                'unread' => __('Mark as unread'),
                'delete' => __('Delete'),
            ),
            'empty' => true,
        ));
        echo $this->Form->end(__('Submit'));
    ?>
    </div>
</div>

<div class="paging"><?php echo $this->Paginator->numbers(); ?></div>
<div class="counter"><?php echo $this->Paginator->counter(array('format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%'))); ?></div>
