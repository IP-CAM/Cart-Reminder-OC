<?php if ($cart[0]){ ?>
<div style="top: 0; left: 0; width: 100vw; height: 100vh; z-index: 99999; position: fixed; background-color: rgba(0,0,0,0.5);" id="cartreminder">

	<div style="width: 450px; height: 600px; background-color: black; border-radius: 10px; left:calc(50% - 225px); top: calc(50% - 300px); display: block; position: absolute;" id="CartReminderInner">
		<div style="width: 450px; height: 280px; background-color: white; display: block; position: relative; border-radius: 10px 10px 0px 0px;" id="upperinnercartreminder">
			<a style="width: 200px; height: 200px; background-image: url(catalog/view/theme/default/image/cart_reminder_button.png); left:calc(50% - 110px); top: 40px; position: absolute; background-size: contain;" id="cartimagereminder"></a>
			<a onclick="$('#cartreminder').animate({opacity: '0'}, 300); setTimeout(function(){$('#cartreminder').hide();},300)" id="crosscartreminder" style="font-size: 40px; color: black; cursor: pointer; right: 20px; top: 20px; position: absolute;">&#10006;</a>
		</div>
		<center><span id="cartreminderlabell" style="color: white; font-size: 20px; top: 30px; position: relative;"><?php echo $cartreminder_label_value; ?></span></center>
		<a href="<?php echo $urlredirect; ?>"style="position: absolute; bottom: 20px; left: calc(50% - 100px); height:40px; width:200px; display:block;" class="btn btn-primary"><?php echo $cartreminder_button_value; ?></a>
	</div>
	
</div>
<?php } ?>