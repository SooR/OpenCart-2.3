<?php if (count($cities) > 1) { ?>
	<div class="pull-left">
		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-city">
			<div class="btn-group">
				<button class="btn btn-link dropdown-toggle" data-toggle="dropdown">
					<span class="hidden-xs hidden-sm hidden-md">
                       <?php foreach ($cities as $city) { ?>
	                       <?php if ($city['code'] == $code) { ?>
		                       <?php echo $city['name']; ?>
	                       <?php } ?>
                       <?php } ?>
                    </span> <i class="fa fa-caret-down"></i></button>
				<ul class="dropdown-menu">
					<?php foreach ($cities as $city) { ?>
						<li><button class="currency-select btn btn-link btn-block" type="button" name="<?php echo $city['code']; ?>"><?php echo $city['name']; ?></button></li>
					<?php } ?>
				</ul>
			</div>
			<input type="hidden" name="code" value="" />
			<input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
		</form>
	</div>
<?php } ?>
