<?php
	$errors = array();
	if (array_key_exists('Submit',$this->ATTRIBUTES)) {
		// Nothing to validate
		
		// Update notes and invoice number
		$Q_UpdateOrder = query("
			UPDATE shopsystem_supplier_order_sheets
			SET sos_invoice_number = '".escape($this->ATTRIBUTES['sos_invoice_number'])."',
				sos_notes = '".escape($this->ATTRIBUTES['sos_notes'])."'
			WHERE sos_id = {$this->ATTRIBUTES['sos_id']}
		");	
		
		// Update the back stamp codes and quantities
		while ($row = $Q_OrderSheetItems->fetchRow()) {
			$qty = $this->ATTRIBUTES['Qty'.$row['ItID']];
			if (is_numeric($qty) and $qty > 0) {
				// good
			} else {
				// bad.. use qty value of 1
				$qty = 1;	
			}
			
			// see if the back stamp code changed or not
			$updateDateSQL = '';
			if (strlen($this->ATTRIBUTES['BackStampCode'.$row['ItID']])) {
				if ($this->ATTRIBUTES['BackStampCode'.$row['ItID']] != $row['soit_bs_code']) {
					// .. if so, update the date changed
					$updateDateSQL = ', soit_date_changed = NOW()';	
				}
			}
			
			$backStampCode = "'".escape($this->ATTRIBUTES['BackStampCode'.$row['ItID']])."'";
			if (strlen($backStampCode) == 2) {
				$backStampCode = 'NULL';
			}
			
			$Q_UpdateItem = query("
				UPDATE shopsystem_supplier_order_sheets_items
				SET soit_bs_code = $backStampCode,
					soit_qty = $qty				
					$updateDateSQL
				WHERE ItID = {$row['ItID']}
			");	
		}
		
		// fix the total
		$this->fixTotal($this->ATTRIBUTES['sos_id']);		

		$this->param('sos_invoice_date');
		$this->param('sos_import');
		
		$separator = '/';
		$date = $this->atts['sos_invoice_date'];
		if (date_error($this->ATTRIBUTES['sos_invoice_date'],$separator) !== null) {
			array_push($errors,array(date_error($this->ATTRIBUTES['sos_invoice_date'],$separator)));
		} else {
			$day = ListGetAt($date,1,$separator);
			$month = ListGetAt($date,2,$separator);
			$year = ss_AdjustTwoDigitYear(ListGetAt($date,3,$separator));
			$dateOutput = ss_TimeStampToSQL(mktime(0,0,0,$month,$day,$year));
			//die($dateOutput);
		
			$Q_UpdateOrder = query("
				UPDATE shopsystem_supplier_order_sheets
				SET sos_invoice_date = $dateOutput
				WHERE sos_id = {$this->ATTRIBUTES['sos_id']}
			");	
		}
		
		
		if (!is_numeric($this->ATTRIBUTES['sos_import'])) {
			array_push($errors,array("Importe is invalid."));
		} else {
			$Q_UpdateOrder = query("
				UPDATE shopsystem_supplier_order_sheets
				SET sos_import = ".$this->ATTRIBUTES['sos_import']."
				WHERE sos_id = {$this->ATTRIBUTES['sos_id']}
			");	
		}
		
		if (count($errors) == 0) {
			locationRelative('index.php?act=shopsystem_supplier_order_sheets.View&BackURL='.ss_URLEncodedFormat($this->ATTRIBUTES['BackURL']).'&sos_id='.$this->ATTRIBUTES['sos_id']);
		}
	}

?>