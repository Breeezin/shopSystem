<?php
	$this->display->layout = 'none';
	
	$data = array(
		'Allocated' => $customsReport,
		'Unallocated' => $unallocatedShipments,
		'vendor'	=>  $vendorRow,
	);
	
	$this->useTemplate('Customs2',$data);	

?>
