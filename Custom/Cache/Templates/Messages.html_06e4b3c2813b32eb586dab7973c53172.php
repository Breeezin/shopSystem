<?php print($data['EditableContent']); ?>
<script language="Javascript">
function showMessage(what)
    {  
    showme=document.getElementById('more'+what);
    showme.style.display='none';
    showme=document.getElementById('less'+what);
    showme.style.display='block';
    showme=document.getElementById('prodFold'+what);
    showme.style.display='block';
    }
function hideMessage(what)
    {  
    showme=document.getElementById('more'+what);
    showme.style.display='block';
    showme=document.getElementById('less'+what);
    showme.style.display='none';
    showme=document.getElementById('prodFold'+what);
    showme.style.display='none';
    }
</script>
<?php
if( $data['IssueCount'] > 0 )
	if( $data['NewCount'] > 0 )
		if( $data['NewCount'] > 1 )
			echo "<h3>You have {$data['NewCount']} new messages</h3>";
		else
			echo "<h3>You have a new message</h3>";
?>
<br />
<?php if( array_key_exists( 'User', $_SESSION ) && array_key_exists( 'us_password', $_SESSION['User'] ) && !strlen( $_SESSION['User']['us_password'] ) ) { ?>
<h1>You have no password.<br /><a href='/Members/Service/Edit'>Click here to edit my profile to add a password</a></h1>
<br />
<? } else { // rest of file ?>
</p>
<?php if( array_key_exists( 'User', $_SESSION ) && array_key_exists( 'us_login_note', $_SESSION['User'] ) && strlen( $_SESSION['User']['us_login_note'] ) ) { ?>
<h3>Please NOTE</h3>
<p>
<?php echo $_SESSION['User']['us_login_note'];?>
</p>
<?php } 

if( $data['IssueCount'] > 0 )
	{
?>
<h3><a name='Issues'>Messages</a></h3>
<div class='container'>
<?php $tmpl_loop_rows = $data['Issues']->numRows(); $tmpl_loop_counter = 0; while ($row = $data['Issues']->fetchRow()) { $tmpl_loop_counter++; ?>
	<div class='row'>
		<div class='col-md-3'>
<?php
//	TODO, there is something wrong in here.  If an old not-assigned to issue is replied to by admin, it doesn't come up as open?
//  TODO

	echo "<strong>".formatDateTime($row['ci_created'], 'j-M-Y')."</strong><br />";
	$lastViewed = getField( "select UNIX_TIMESTAMP( us_members_viewed ) from users where us_id = ".ss_getUserID() );
	$lastResponse = getField( "select UNIX_TIMESTAMP( max( cir_created ) ) from client_issue_response where cir_ci_id = {$row['ci_id']}" );
	$lastEntry = getField( "select UNIX_TIMESTAMP( ce_created ) from client_issue_entry where ce_ci_id = {$row['ci_id']}" );
//	$lastAttachment = getField( "select UNIX_TIMESTAMP( cia_created ) from client_issue_attachment where cia_ci_id = {$row['ci_id']}" );
	if( !$lastResponse )						// no answer
		if( strlen( $row['ci_closed'] ) )		// closed by admin
			$isClosed = true;
		else									// waiting for answer
			$isClosed = false;
	else										// got answer
		if( $lastViewed < $lastResponse )		// not seen yet
			$isClosed = false;
		else
			if( $lastViewed > $lastResponse + 24 * 60 * 60 * 3 )		// seen it few days ago
				$isClosed = true;
			else								// seen it withing the last few days
				$isClosed = false;
?>
		</div>
		<div class='col-md-9'>
<?php
	if( $row['ci_transaction_number'] > 0 )
	{
		$when = getRow( "select or_recorded, or_country from shopsystem_orders where or_tr_id = {$row['ci_transaction_number']}" );
		echo "This message thread is about order number <strong>".$row['ci_transaction_number']."</strong> from ".formatDateTime($when['or_recorded'],'j-M-Y');
		if( $td = days_in_transit($when['or_recorded'], $or_recorded['or_country']) )
			echo ", $td ago";
		echo "<br />";
	}
	else
	{
		echo "This message is not about an order number<br />";

	}
?>
		</div>
	</div>
	<div class='row'>
		<div class='col-md-12'>
<?php
	// shown when closed
	echo "<div id='more{$row['ci_id']}'  style='display:".(!$isClosed?'none':'').";'>";
	echo "<a href='Javascript:showMessage({$row['ci_id']});void(0);'> Show this message thread</a>";
	echo "</div>";

	// shown when open
	echo "<div id='less{$row['ci_id']}'  style='display:".($isClosed?'none':'').";'>";;
	echo "<a href='Javascript:hideMessage({$row['ci_id']});void(0);'> Hide this message thread</a>";
?>
			<div class='container messageBox'>
<?php
	if( $en = query( "select * from client_issue_attachment where cia_ci_id = {$row['ci_id']}" ) )
		if( $en->numRows() > 0 )
		{
			echo "<div class='row'><div class='col-md-12'>You have attached the following photos.</div></div>";
			while( $er = $en->fetchRow( ) )
			{
				echo '<div class="row"><div class="col-md-2">'
					.formatDateTime($er['cia_created'], 'j-M-Y h:i')
					."</div><div class='col-md-5'>{$er['cia_name']}</div><div class='col-md-5'>"
					."<img src='index.php?act=ImageManager.get&Image={$er['cia_filename']}&Size=160x160'>"
					."</div></div>";
			}
		}

	if( $en = query( "select ce_created as created, ce_text as text, 'You' as who, 'blue' as colour, 0 as ts  from client_issue_entry
							join client_issue on ce_ci_id = ci_id left join users on ci_us_id = us_id where ce_ci_id = {$row['ci_id']}
							and (ce_invisible IS NULL or ce_invisible = false)
				union select cir_created as created, cir_text as text, us_first_name as who, 'black' as colour, UNIX_TIMESTAMP( cir_created ) as ts from client_issue_response
							left join users on cir_us_id = us_id where cir_ci_id = {$row['ci_id']} and cir_adminlevel & ".ADMIN_CUSTOMER_ISSUE." and (cir_deleted IS NULL or cir_deleted = false)  and (cir_invisible IS NULL or cir_invisible = false) order by 1" ) )
		while( $er = $en->fetchRow( ) )
		{
			if( $er['ts'] > $lastViewed )
				echo "<a name='New'>&nbsp;</a>";
			echo '<div class="row"><div class="col-md-2">'
				.'<font color='.$er['colour'].'>'.formatDateTime($er['created'], 'j-M-Y h:i').'</font></div>'
				.'<div class="col-md-1"><font color='.$er['colour'].'>'.$er['who'].'</font></div><div class="col-md-9">'
				.'<font color='.$er['colour'].'>'.nl2br($er['text'])."</font></div></div>";
		}
	if( strlen( $row['ci_closed'] ) )
		echo "<p>This issue is closed</p>";
?>
			<h5><a href='/Members/Service/Issue/Order/<?=$row['ci_transaction_number']?>'>Add a reply to this thread</a></h5><br />
		</div>
	</div>
<?php } ?>
</div>
<?php
	}
?>
<br />
<br />
<br />
<br />
<a href='/Members/Service/Issue'>Contact our support team</a>
<?php
query( "update users set us_members_viewed = now() where us_id = ".ss_getUserID() );
}
?>
