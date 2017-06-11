<?php
defined('BASEPATH') OR exit('What Are You Looking For ?');
?>
<div class="panel panel-warning"> 
	<div class="panel-heading"> 
		<h3 class="panel-title">Pesan Singkat</h3> 
	</div> 
	<div class="panel-body"> <?php echo $message;?> </div> 
	<div class="panel-footer">
		<button type="button" id="next" class="btn btn-default btn-clean" data-dismiss="modal"><?php echo $but2;?></button>
	</div> 
</div>