<table class="table table-sm table-striped table-hover settings-table">
	<thead>
		<tr>
			<th>Name</th>
			<th>Value</th>
			<th>Actions</th>
		</tr>
	</thead>
	<tbody>
 		<?php foreach ($settings as $setting): ?>
		<tr>
			<td><code><?php echo $setting->name ?></code></td>
			<td>
				<?php
				$value = htmlentities($setting->value);
				if (strlen($value) < 50)
					echo $value;
				else
					echo substr($value, 0, 50)."...";
				?>
			</td>
			<td>
				<button class="btn btn-sm btn-primary editSetting" data-toggle="modal" data-target="#editSetting" id="<?php echo $setting->name ?>"><i class="fa fa-pencil"></i> Edit</button>
			</td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
<!-- Modal -->
<div class="modal fade" id="editSetting" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit: <code id="settingName"></code></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      	<div class='text-center' id="loading" style="display: none"><i class='fa fa-spin fa-spinner'></i></div>
        <div id="content">
	        <form id="settingForm">
	        </form>
        </div>
      </div>
      <div class="modal-footer">
      	<span id="modalMsg"></span>
        <button type="button" class="btn btn-sm btn-primary" id="saveSetting">Save changes</button>
        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>