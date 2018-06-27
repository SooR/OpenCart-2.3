<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-category" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-category" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-data" data-toggle="tab"><?php echo $tab_data; ?></a></li>
            <li><a href="#tab-design" data-toggle="tab"><?php echo $tab_design; ?></a></li>
            <li><a href="#tab-city" data-toggle="tab"><?php echo $tab_city; ?></a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <ul class="nav nav-tabs" id="language">
                <?php foreach ($languages as $language) { ?>
                <li><a href="#language<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
                <?php } ?>
              </ul>
              <div class="tab-content">
                <?php foreach ($languages as $language) { ?>
                <div class="tab-pane" id="language<?php echo $language['language_id']; ?>">
                  <div class="form-group required">
                    <label class="col-sm-2 control-label" for="input-name<?php echo $language['language_id']; ?>"><?php echo $entry_name; ?></label>
                    <div class="col-sm-10">
                      <input type="text" name="category_description[<?php echo $language['language_id']; ?>][name]" value="<?php echo isset($category_description[$language['language_id']]) ? $category_description[$language['language_id']]['name'] : ''; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name<?php echo $language['language_id']; ?>" class="form-control" />
                      <?php if (isset($error_name[$language['language_id']])) { ?>
                      <div class="text-danger"><?php echo $error_name[$language['language_id']]; ?></div>
                      <?php } ?>
                    </div>
                  </div>
                </div>
                <?php } ?>
              </div>
            </div>
            <div class="tab-pane" id="tab-data">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-parent"><?php echo $entry_parent; ?></label>
                <div class="col-sm-10">
                  <select name="parent_id" class="form-control">
                    <option value="0" selected="selected"><?php echo $text_none; ?></option>
                    <?php foreach ($categories as $category) { ?>
                    <?php if ($category['category_id'] == $parent_id) { ?>
                    <option value="<?php echo $category['category_id']; ?>" selected="selected"><?php echo $category['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $category['category_id']; ?>"><?php echo $category['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-filter"><span data-toggle="tooltip" title="<?php echo $help_filter; ?>"><?php echo $entry_filter; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="filter" value="" placeholder="<?php echo $entry_filter; ?>" id="input-filter" class="form-control" />
                  <div id="category-filter" class="well well-sm" style="height: 150px; overflow: auto;">
                    <?php foreach ($category_filters as $category_filter) { ?>
                    <div id="category-filter<?php echo $category_filter['filter_id']; ?>"><i class="fa fa-minus-circle"></i> <?php echo $category_filter['name']; ?>
                      <input type="hidden" name="category_filter[]" value="<?php echo $category_filter['filter_id']; ?>" />
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_store; ?></label>
                <div class="col-sm-10">
                  <div class="well well-sm" style="height: 150px; overflow: auto;">
                    <div class="checkbox">
                      <label>
                        <?php if (in_array(0, $category_store)) { ?>
                        <input type="checkbox" name="category_store[]" value="0" checked="checked" />
                        <?php echo $text_default; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="category_store[]" value="0" />
                        <?php echo $text_default; ?>
                        <?php } ?>
                      </label>
                    </div>
                    <?php foreach ($stores as $store) { ?>
                    <div class="checkbox">
                      <label>
                        <?php if (in_array($store['store_id'], $category_store)) { ?>
                        <input type="checkbox" name="category_store[]" value="<?php echo $store['store_id']; ?>" checked="checked" />
                        <?php echo $store['name']; ?>
                        <?php } else { ?>
                        <input type="checkbox" name="category_store[]" value="<?php echo $store['store_id']; ?>" />
                        <?php echo $store['name']; ?>
                        <?php } ?>
                      </label>
                    </div>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-keyword"><span data-toggle="tooltip" title="<?php echo $help_keyword; ?>"><?php echo $entry_keyword; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="keyword" value="<?php echo $keyword; ?>" placeholder="<?php echo $entry_keyword; ?>" id="input-keyword" class="form-control" />
                  <?php if ($error_keyword) { ?>
                  <div class="text-danger"><?php echo $error_keyword; ?></div>
                  <?php } ?>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo $entry_image; ?></label>
                <div class="col-sm-10"><a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                  <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-top"><span data-toggle="tooltip" title="<?php echo $help_top; ?>"><?php echo $entry_top; ?></span></label>
                <div class="col-sm-10">
                  <div class="checkbox">
                    <label>
                      <?php if ($top) { ?>
                      <input type="checkbox" name="top" value="1" checked="checked" id="input-top" />
                      <?php } else { ?>
                      <input type="checkbox" name="top" value="1" id="input-top" />
                      <?php } ?>
                      &nbsp; </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-column"><span data-toggle="tooltip" title="<?php echo $help_column; ?>"><?php echo $entry_column; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="column" value="<?php echo $column; ?>" placeholder="<?php echo $entry_column; ?>" id="input-column" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-sort-order"><?php echo $entry_sort_order; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="sort_order" value="<?php echo $sort_order; ?>" placeholder="<?php echo $entry_sort_order; ?>" id="input-sort-order" class="form-control" />
                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
                <div class="col-sm-10">
                  <select name="status" id="input-status" class="form-control">
                    <?php if ($status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="tab-design">
              <div class="table-responsive">
                <table class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-left"><?php echo $entry_store; ?></td>
                      <td class="text-left"><?php echo $entry_layout; ?></td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="text-left"><?php echo $text_default; ?></td>
                      <td class="text-left"><select name="category_layout[0]" class="form-control">
                          <option value=""></option>
                          <?php foreach ($layouts as $layout) { ?>
                          <?php if (isset($category_layout[0]) && $category_layout[0] == $layout['layout_id']) { ?>
                          <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select></td>
                    </tr>
                    <?php foreach ($stores as $store) { ?>
                    <tr>
                      <td class="text-left"><?php echo $store['name']; ?></td>
                      <td class="text-left"><select name="category_layout[<?php echo $store['store_id']; ?>]" class="form-control">
                          <option value=""></option>
                          <?php foreach ($layouts as $layout) { ?>
                          <?php if (isset($category_layout[$store['store_id']]) && $category_layout[$store['store_id']] == $layout['layout_id']) { ?>
                          <option value="<?php echo $layout['layout_id']; ?>" selected="selected"><?php echo $layout['name']; ?></option>
                          <?php } else { ?>
                          <option value="<?php echo $layout['layout_id']; ?>"><?php echo $layout['name']; ?></option>
                          <?php } ?>
                          <?php } ?>
                        </select></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
            <div class="tab-pane" id="tab-city">
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-filter"><?php echo $entry_city; ?></label>
                    <div class="col-sm-10">
                        <input type="text" name="city" value="" placeholder="<?php echo $entry_city; ?>" id="input-city" class="form-control" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2 control-label" for="input-filter"><?php echo $text_city; ?></label>
                    <div class="col-sm-10">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <?php foreach ($city_descriptions as $city_description){ ?>
                            <div id="city_id-<?php echo $city_description[$current_lang]['city_id']; ?>" class="panel panel-default cities">
                                <div class="panel-heading" role="tab" id="heading<?php echo $city_description[$current_lang]['city_id']; ?>">
                                    <h4 class="panel-title">
                                        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $city_description[$current_lang]['city_id']; ?>" aria-expanded="false" aria-controls="collapse<?php echo $city_description[$current_lang]['city_id']; ?>">
	                                        <?php echo $city_description[$current_lang]['name']; ?>
                                        </a>
                                        <div class="pull-right">
                                            <i class="fa fa-minus-circle"></i>
                                        </div>
                                    </h4>
                                </div>
                                <div id="collapse<?php echo $city_description[$current_lang]['city_id']; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $city_description[$current_lang]['city_id']; ?>">
                                    <div class="panel-body">
                                        <div class="tab-pane">
                                            <ul class="nav nav-tabs" id="language_city-<?php echo $city_description[$current_lang]['city_id']; ?>">
						                        <?php foreach ($languages as $language) { ?>
                                                    <li><a href="#language_city-<?php echo $city_description[$language['language_id']]['city_id']; ?>-<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>
						                        <?php } ?>
                                            </ul>
                                            <div class="tab-content">
						                        <?php foreach ($languages as $language) { ?>
                                                <div class="tab-pane" id="language_city-<?php echo $city_description[$language['language_id']]['city_id']; ?>-<?php echo $language['language_id']; ?>">
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label" for="input-title-<?php echo $city_description[$language['language_id']]['city_id']; ?>-<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="city_description[<?php echo $city_description[$language['language_id']]['city_id']; ?>][<?php echo $language['language_id']; ?>][title]" placeholder="<?php echo $entry_meta_title; ?>" id="input-title-<?php echo $city_description[$language['language_id']]['city_id']; ?>-<?php echo $language['language_id']; ?>" value="<?php echo isset($city_description[$language['language_id']]['title']) ? $city_description[$language['language_id']]['title'] : ''; ?>" class="form-control" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label" for="input-meta_description-<?php echo $city_description[$language['language_id']]['city_id']; ?>-<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="city_description[<?php echo $city_description[$language['language_id']]['city_id']; ?>][<?php echo $language['language_id']; ?>][meta_description]" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta_description-<?php echo $city_description[$language['language_id']]['city_id']; ?>-<?php echo $language['language_id']; ?>" value="<?php echo isset($city_description[$language['language_id']]['meta_description']) ? $city_description[$language['language_id']]['meta_description'] : ''; ?>" class="form-control" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label" for="input-meta_h1-<?php echo $city_description[$language['language_id']]['city_id']; ?>-<?php echo $language['language_id']; ?>"><?php echo $entry_meta_h1; ?></label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="city_description[<?php echo $city_description[$language['language_id']]['city_id']; ?>][<?php echo $language['language_id']; ?>][meta_h1]" placeholder="<?php echo $entry_meta_h1; ?>" id="input-meta_h1-<?php echo $city_description[$language['language_id']]['city_id']; ?>-<?php echo $language['language_id']; ?>" value="<?php echo isset($city_description[$language['language_id']]['meta_h1']) ? $city_description[$language['language_id']]['meta_h1'] : ''; ?>" class="form-control" />
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label" for="input-description-<?php echo $city_description[$language['language_id']]['city_id']; ?>-<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>
                                                        <div class="col-sm-10">
                                                            <textarea name="city_description[<?php echo $city_description[$language['language_id']]['city_id']; ?>][<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_description; ?>" id="input-description-<?php echo $city_description[$language['language_id']]['city_id']; ?>-<?php echo $language['language_id']; ?>" data-lang="<?php echo $lang; ?>" class="form-control summernote"><?php echo isset($city_description[$language['language_id']]['description']) ? $city_description[$language['language_id']]['description'] : ''; ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label" for="input-meta_keyword-<?php echo $city_description[$language['language_id']]['city_id']; ?>-<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>
                                                        <div class="col-sm-10">
                                                            <input type="text" name="city_description[<?php echo $city_description[$language['language_id']]['city_id']; ?>][<?php echo $language['language_id']; ?>][meta_keyword]" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta_keyword-<?php echo $city_description[$language['language_id']]['city_id']; ?>-<?php echo $language['language_id']; ?>" value="<?php echo isset($city_description[$language['language_id']]['meta_keyword']) ? $city_description[$language['language_id']]['meta_keyword'] : ''; ?>" class="form-control" />
                                                        </div>
                                                    </div>
                                                        <div class="form-group">
                                                            <label class="col-sm-2 control-label" for="input-canonical-<?php echo $city_description[$language['language_id']]['city_id']; ?>-<?php echo $language['language_id']; ?>"><?php echo $entry_canonical; ?></label>
                                                            <div class="col-sm-10">
                                                                <input type="text" name="city_description[<?php echo $city_description[$language['language_id']]['city_id']; ?>][<?php echo $language['language_id']; ?>][canonical]" placeholder="<?php echo $entry_canonical; ?>" id="input-canonical-<?php echo $city_description[$language['language_id']]['city_id']; ?>-<?php echo $language['language_id']; ?>" value="<?php echo isset($city_description[$language['language_id']]['canonical']) ? $city_description[$language['language_id']]['canonical'] : ''; ?>" class="form-control" />
                                                            </div>
                                                        </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-2 control-label"><?php echo $entry_index; ?></label>
                                                        <div class="col-sm-10">
                                                            <div class="col-sm-10">
                                                                <label class="radio-inline">
			                                                        <?php if (isset($city_description[$language['language_id']]['robots']) && $city_description[$language['language_id']]['robots']) { ?>
                                                                        <input type="radio" name="city_description[<?php echo $city_description[$language['language_id']]['city_id']; ?>][<?php echo $language['language_id']; ?>][robots]" value="1" checked="checked" />
				                                                        <?php echo $text_yes; ?>
			                                                        <?php } else if(!isset($city_description[$language['language_id']]['robots'])) { ?>
                                                                        <input type="radio" name="city_description[<?php echo $city_description[$language['language_id']]['city_id']; ?>][<?php echo $language['language_id']; ?>][robots]" value="1" checked="checked" />
				                                                        <?php echo $text_yes; ?>
			                                                        <?php } else { ?>
                                                                        <input type="radio" name="city_description[<?php echo $city_description[$language['language_id']]['city_id']; ?>][<?php echo $language['language_id']; ?>][robots]" value="1" />
				                                                        <?php echo $text_yes; ?>
			                                                        <?php } ?>
                                                                </label>
                                                                <label class="radio-inline">
	                                                                <?php if (isset($city_description[$language['language_id']]['robots']) && !$city_description[$language['language_id']]['robots']) { ?>
                                                                        <input type="radio" name="city_description[<?php echo $city_description[$language['language_id']]['city_id']; ?>][<?php echo $language['language_id']; ?>][robots]" value="0" checked="checked" />
				                                                        <?php echo $text_no; ?>
			                                                        <?php } else { ?>
                                                                        <input type="radio" name="city_description[<?php echo $city_description[$language['language_id']]['city_id']; ?>][<?php echo $language['language_id']; ?>][robots]" value="0" />
				                                                        <?php echo $text_no; ?>
			                                                        <?php } ?>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <script type="text/javascript"><!--
	  <?php foreach ($city_descriptions as $city_description){ ?>
      $('#language_city-<?php echo $city_description[$current_lang]['city_id']; ?> a:first').tab('show');
	  <?php } ?>
   
	  <?php if ($ckeditor) { ?>
	  <?php foreach ($city_descriptions as $city_description){ ?>
      <?php foreach ($languages as $language) { ?>
      ckeditorInit('input-description-<?php echo $city_description[$current_lang]['city_id']; ?>-<?php echo $language['language_id']; ?>', getURLVar('token'));
      <?php } ?>
	  <?php } ?>
	  <?php } ?>
  //--></script>
  <script type="text/javascript"><!--
$('input[name=\'path\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/category/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				json.unshift({
					category_id: 0,
					name: '<?php echo $text_none; ?>'
				});

				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['category_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'path\']').val(item['label']);
		$('input[name=\'parent_id\']').val(item['value']);
	}
});
//--></script>
  <script type="text/javascript"><!--
$('input[name=\'filter\']').autocomplete({
	'source': function(request, response) {
        console.log("1");
		$.ajax({
			url: 'index.php?route=catalog/filter/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['filter_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter\']').val('');

		$('#category-filter' + item['value']).remove();

		$('#category-filter').append('<div id="category-filter' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="category_filter[]" value="' + item['value'] + '" /></div>');
	}
});

$('#category-filter').delegate('.fa-minus-circle', 'click', function() {
	$(this).parent().remove();
});
//--></script>
    
    <script type="text/javascript"><!--
        $('input[name=\'city\']').autocomplete({
            'source': function(request, response) {
                $.ajax({
                    url: 'index.php?route=localisation/city/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
                    dataType: 'json',
                    success: function(json) {
                        response($.map(json, function(item) {
                            return {
                                label: item['name'],
                                value: item['city_id']
                            }
                        }));
                    }
                });
            },
            'select': function(item) {
                $('input[name=\'city\']').val('');
                
                if($('#city_id-' + item['value']).length == 1){
                    alert("<?php echo $error_city; ?>");
                } else {
                    html  = '<div id="city_id-' + item['value'] + '" class="panel panel-default cities">';
                    html += '<div class="panel-heading" role="tab" id="heading' + item['value'] + '">';
                    html += '<h4 class="panel-title">';
                    html += '<a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse' + item['value'] + '" aria-expanded="false" aria-controls="collapse' + item['value'] + '">';
                    html += item['label'];
                    html += '</a>';
                    html += '<div class="pull-right">';
                    html += '<i class="fa fa-minus-circle"></i>';
                    html += '</div>';
                    html += '</h4>';
                    html += '</div>';
                    html += '<div id="collapse' + item['value'] + '" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading' + item['value'] + '">';
                    html += '<div class="panel-body">';
                    html += '<div class="tab-pane">';
                    html += '<ul class="nav nav-tabs" id="language_city-' + item['value'] + '">';
                    <?php foreach ($languages as $language) { ?>
                    html += '<li><a href="#language_city-' + item['value'] + '-<?php echo $language['language_id']; ?>" data-toggle="tab"><img src="language/<?php echo $language['code']; ?>/<?php echo $language['code']; ?>.png" title="<?php echo $language['name']; ?>" /> <?php echo $language['name']; ?></a></li>';
	                <?php } ?>
                    html += '</ul>';
                    html += '<div class="tab-content">';
                    <?php foreach ($languages as $language) { ?>
                    html += '<div class="tab-pane" id="language_city-' + item['value'] + '-<?php echo $language['language_id']; ?>">';
                    html += '<div class="form-group">';
                    html += '<label class="col-sm-2 control-label" for="input-title-' + item['value'] + '-<?php echo $language['language_id']; ?>"><?php echo $entry_meta_title; ?></label>';
                    html += '<div class="col-sm-10">';
                    html += '<input type="text" name="city_description[' + item['value'] + '][<?php echo $language['language_id']; ?>][title]" placeholder="<?php echo $entry_meta_title; ?>" id="input-title-' + item['value'] + '-<?php echo $language['language_id']; ?>" value="" class="form-control" />';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="form-group">';
                    html += '<label class="col-sm-2 control-label" for="input-meta_description-' + item['value'] + '-<?php echo $language['language_id']; ?>"><?php echo $entry_meta_description; ?></label>';
                    html += '<div class="col-sm-10">';
                    html += '<input type="text" name="city_description[' + item['value'] + '][<?php echo $language['language_id']; ?>][meta_description]" placeholder="<?php echo $entry_meta_description; ?>" id="input-meta_description-' + item['value'] + '-<?php echo $language['language_id']; ?>" value="" class="form-control" />';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="form-group">';
                    html += '<label class="col-sm-2 control-label" for="input-meta_h1-' + item['value'] + '-<?php echo $language['language_id']; ?>"><?php echo $entry_meta_h1; ?></label>';
                    html += '<div class="col-sm-10">';
                    html += '<input type="text" name="city_description[' + item['value'] + '][<?php echo $language['language_id']; ?>][meta_h1]" placeholder="<?php echo $entry_meta_h1; ?>" id="input-meta_h1-' + item['value'] + '-<?php echo $language['language_id']; ?>" value="" class="form-control" />';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="form-group">';
                    html += '<label class="col-sm-2 control-label" for="input-description->' + item['value'] + '-<?php echo $language['language_id']; ?>"><?php echo $entry_description; ?></label>';
                    html += '<div class="col-sm-10">';
                    html += '<textarea name="city_description[' + item['value'] + '][<?php echo $language['language_id']; ?>][description]" placeholder="<?php echo $entry_description; ?>" id="input-description-' + item['value'] + '-<?php echo $language['language_id']; ?>" data-lang="<?php echo $lang; ?>" class="form-control summernote"></textarea>';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="form-group">';
                    html += '<label class="col-sm-2 control-label" for="input-meta_keyword-' + item['value'] + '-<?php echo $language['language_id']; ?>"><?php echo $entry_meta_keyword; ?></label>';
                    html += '<div class="col-sm-10">';
                    html += '<input type="text" name="city_description[' + item['value'] + '][<?php echo $language['language_id']; ?>][meta_keyword]" placeholder="<?php echo $entry_meta_keyword; ?>" id="input-meta_keyword-' + item['value'] + '-<?php echo $language['language_id']; ?>" value="" class="form-control" />';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="form-group">';
                    html += '<label class="col-sm-2 control-label" for="input-canonical-' + item['value'] + '-<?php echo $language['language_id']; ?>"><?php echo $entry_canonical; ?></label>';
                    html += '<div class="col-sm-10">';
                    html += '<input type="text" name="city_description[' + item['value'] + '][<?php echo $language['language_id']; ?>][canonical]" placeholder="<?php echo $entry_canonical; ?>" id="input-canonical-' + item['value'] + '-<?php echo $language['language_id']; ?>" value="" class="form-control" />';
                    html += '</div>';
                    html += '</div>';
                    html += '<div class="form-group">';
                    html += '<label class="col-sm-2 control-label"><?php echo $entry_index; ?></label>';
                    html += '<div class="col-sm-10">';
                    html += '<div class="col-sm-10">';
                    html += '<label class="radio-inline">';
                    html += '<input type="radio" name="city_description[' + item['value'] + '][<?php echo $language['language_id']; ?>][robots]" value="1" checked="checked" />';
		            html += '<?php echo $text_yes; ?>';
                    html += '</label>';
                    html += '<label class="radio-inline">';
                    html += '<input type="radio" name="city_description[' + item['value'] + '][<?php echo $language['language_id']; ?>][robots]" value="0" />';
                    html += '<?php echo $text_no; ?>';
                    html += '</label>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
		            <?php } ?>
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
                    html += '</div>';
        
                    $('#accordion').append(html);
                
                    <?php if ($ckeditor) { ?>
                    <?php foreach ($languages as $language) { ?>
                    ckeditorInit('input-description-' + item['value'] + '-<?php echo $language['language_id']; ?>', getURLVar('token'));
                    <?php } ?>
                    <?php } ?>
        
                    $('#language_city-' + item['value'] + ' a:first').tab('show');
                }
            }
        });

        $('#accordion').delegate('.fa-minus-circle', 'click', function() {
            $(this).parents('.cities').remove();
        });
        
        //--></script>
    
  <script type="text/javascript"><!--
$('#language a:first').tab('show');
//--></script></div>
<?php echo $footer; ?>
