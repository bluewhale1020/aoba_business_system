<?php
//debug($payers);
foreach ($payers as $payer): ?>
<li><a href="<?php echo $this->Url->build(['controller'=>'bills', 'action'=>'index',$payer->payer_id]); ?>"><i class="fa fa-circle-o"></i><?= $payer->payer_name ?></a></li>

<?php endforeach; ?>           
             

