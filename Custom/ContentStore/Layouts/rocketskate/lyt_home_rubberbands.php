<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{[WindowTitle]}</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="sty_main.css" rel="stylesheet" type="text/css" />
</head>

<body id="body">

<div id="container">
  <div id="header">
	  <ul id="primary">
		<li><a href="Chinese%20Site/Home" class="current">主页</a></li>
		<li><a href="Shop_System"  >雪茄店</a></li>
	</ul>
      <a href="Home"><img src="Images/acmerockets-logo.gif" alt="Acme Express : Chilean Product Shop" width="147" height="78" border="0" /></a></div>
	<div id="main">
	  <div id="contents" align="left">
	  <div style="clear:both; height:2px;"></div>
	  <div id="topbar">
	    <ul id="topbar-ul">
	      <li><a href="#" id="vieworder" >您认为,</a> </li>
          <li><span>网站搜索&nbsp;&nbsp;<input name="AST_SEARCH_KEYWORDS" type="text" class="form-Special" value="keyword" size="12" onFocus="this.value='';" onBlur="if (this.value.length==0) this.value='search site';">
		  &nbsp;&nbsp;<input name="imageField" type="image" class="noBorder" src="Images/search-go.gif" alt="Go">
	    </ul>
	    </div>
	  <div id="left-top"><h1><span class="headeronblack">古巴雪茄</span> 店</h1>
        <p>{tmpl_embed_asset assetid="797"} </p>
     
	  </div>		
		
<div id="right-top">

</div>

<div style="clear:both; height:5px;"></div>

      </div>
	</div>
	
	<div id="middle">
<table width="798" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td  id="home-llama-list">
	<h2 class="onblack">你选择雪茄品牌</h2>
	<p><?php
                    				$result = new Request('Asset.Display',array(
                    					'as_id'	=>	'514',
                    					'Service'	=>	'TopLevelCategoryList',
                    					'Template'	=>	'TopLevelCategoryListHome',
                    				));
                    				print $result->display;
                    			?> </td>
    <td valign="top" class="padding"><h2 class="onblack">最新消息</h2><p>{tmpl_embed_asset assetid="649"}</p></td>
  </tr>
</table>
<div id="contenttableback2" >
<table width="798" border="0" cellspacing="0" cellpadding="0" id="contenttableback" >
  <tr>
    <td id="home-llama-shop">
      <div style="width:535px;"><h1 style="margin-left:8px;">Acme Express 售 </h1>
      <a name="recommended"></a><br>
<?php
									$result = new Request('Asset.Display',array(
                    					'as_id'	=>	'514',
                    					'Service'	=>	'Engine',
                    					'pr_qoc_id'	=>	1,
                    					'PricesType'	=>	'TableHTML',
                    				    'Specials'	=>	1,
                    					'RowsPerPage'	=>	3,
                    					'OrderBy'	=>	'Random',
                    					'NoOverrideRows'	=>	1,
                    				));

                    				print $result->display;
                    			?>	    		
                    						
								<?php
									$result = new Request('Asset.Display',array(
                    					'as_id'	=>	'514',
                    					'Service'	=>	'Engine',
                    					'pr_qoc_id'	=>	1,
                    					'PricesType'	=>	'TableHTML',
                    					'NotSpecials'	=>	1,
                    					'RowsPerPage'	=>	5,
                    					'OrderBy'	=>	'Random',
                    					'NoOverrideRows'	=>	1,
                    				));
                    				print $result->display;
                    			?>	   </div>  </td>
   
  </tr>
</table>
<div id="bottom"></div>
</div>
</div>
<div id="footer"><p>我国网上购物系统支持以下网络浏览器:  <a href="http://www.microsoft.com/windows/ie/downloads/critical/ie6sp1/default.mspx" target="_blank" class="GoldText">Internet Explorer 6</a> and <a href="http://www.mozilla.org/" target="_blank" class="GoldText">Mozilla Firefox 1.0</a></p>
  <p><span class="footerText">{tmpl_embed_asset assetid=&quot;531&quot;}&nbsp;|&nbsp;<a href="http://www.acmerockets.com/Links" class="footerText">Links</a></span><span class="footerText">&nbsp;|&nbsp;</span>&copy; {[CurrentYear]} AcmeRockets.com</p>
</div>
	
</div>
</body>
</html>
