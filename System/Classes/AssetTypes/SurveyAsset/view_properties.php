<?php
	$assetID = $asset->getID();
	$Q_Count = getRow("SELECT Count(*) AS Count FROM Survey_$assetID");
	
	
?>
<table cellpadding="0" cellspacing="2" width="100%">
	<tr>
		<td class="propertiesLabel">Total Records :</td>
		<td><?=$Q_Count['Count']?></td>
	</tr>	
</table>
