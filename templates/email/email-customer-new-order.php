<p><strong>
	<?php echo( __('Hello: ', 'sas-shop' ) ); ?></strong> [name] [lastname]<br />
</p>
<div>
<p><strong><?php echo( __('Products list', 'sas-shop' ) ); ?></strong></p>
	[productslist]
</div>


<div class="sas-shop-tab-wrap"><table class="sas-shop-tab">
  <tr>
    <th class="sas-shop-t"><?php echo( __('Subtotal', 'sas-shop' ) ); ?></th>
    <th class="sas-shop-t"><?php echo( __('VAT', 'sas-shop' ) ); ?></th>
    <th class="sas-shop-t"><?php echo( __('Total', 'sas-shop' ) ); ?></th>
  </tr>
  <tr>
    <td class="sas-shop-t">[subtotal] [currency]</td>
    <td class="sas-shop-t">[taxes] [currency]</td>
    <td class="sas-shop-t">[total] [currency]</td>
  </tr>
</table>
</div>

<p style="">
	<?php echo( __('Best regards ', 'sas-shop' ) ); ?><br>
	<?php echo( __('See you soon.', 'sas-shop' ) ); ?>
</p>
<div style="text-align:center; border-top:1px solid #eee;padding:5px 0 0 0;" id="email_footer">
	<small style="font-size:11px; color:#999; line-height:14px;">

	</small>
</div>