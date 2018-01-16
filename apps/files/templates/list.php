<div id="controls">
		<div class="actions creatable hidden">
			<div id="uploadprogresswrapper">
				<div id="uploadprogressbar">
					<em class="label outer" style="display:none"><span class="desktop"><?php p($l->t('Uploading...'));?></span><span class="mobile"><?php p($l->t('...'));?></span></em>
				</div>
				<input type="button" class="stop icon-close" style="display:none" value="" />
			</div>
		</div>
		<div id="file_action_panel"></div>
		<div class="notCreatable notPublic hidden">
			<?php p($l->t('You don’t have permission to upload or create files here'))?>
		</div>
	<?php /* Note: the template attributes are here only for the public page. These are normally loaded
			 through ajax instead (updateStorageStatistics).
	*/ ?>
	<input type="hidden" name="permissions" value="" id="permissions">
	<input type="hidden" id="free_space" value="<?php isset($_['freeSpace']) ? p($_['freeSpace']) : '' ?>">
	<?php if(isset($_['dirToken'])):?>
	<input type="hidden" id="publicUploadRequestToken" name="requesttoken" value="<?php p($_['requesttoken']) ?>" />
	<input type="hidden" id="dirToken" name="dirToken" value="<?php p($_['dirToken']) ?>" />
	<?php endif;?>
	<input type="hidden" class="max_human_file_size"
		   value="(max <?php isset($_['uploadMaxHumanFilesize']) ? p($_['uploadMaxHumanFilesize']) : ''; ?>)">
</div>

<div id="emptycontent" class="hidden">
	<div class="icon-folder"></div>
	<h2><?php p($l->t('No files in here')); ?></h2>
	<p class="uploadmessage hidden"><?php p($l->t('Upload some content or sync with your devices!')); ?></p>
</div>

<div class="nofilterresults emptycontent hidden">
	<div class="icon-search"></div>
	<h2><?php p($l->t('No entries found in this folder')); ?></h2>
	<p></p>
</div>

<table id="filestable" data-allow-public-upload="<?php p($_['publicUploadEnabled'])?>" data-preview-x="32" data-preview-y="32">
	<thead>
		<tr>
			<th id='headerName' class="hidden column-name">
				<div id="headerName-container">
					<input type="checkbox" id="select_all_files" class="select-all checkbox"/>
					<label for="select_all_files">
						<span class="hidden-visually"><?php p($l->t('Select all'))?></span>
					</label>
					<a class="name sort columntitle" data-sort="name"><span><?php p($l->t( 'Name' )); ?></span><span class="sort-indicator"></span></a>
					<span id="selectedActionsList" class="selectedActions">
						<a href="" class="download">
							<span class="icon icon-download"></span>
							<span><?php p($l->t('Download'))?></span>
						</a>
						<!-- clarin update !-->

						<a href="" class="download-zip">
							<span class="icon icon-download"></span>
							<span><?php p($l->t('Download as zip'))?></span>
						</a>

						<span class="conditional-actions">


							<a href="" class="ccl">
								<span class="icon icon-file"></span>
								<span><?php p($l->t('Convert to CCL'))?></span>
							</a>


							<a href="#" class="clarin-tasks">
								<span><?php p($l->t('Export to Clarin services'))?>
									<span class="icon icon-triangle-s "></span>
								</span>
							</a>
								<div id="clarin-export-services" class="expandable-menu menu" style="display: none">
									<ul>

										<li>
										<a href="" class="dspace">
											<span class="icon icon-external"></span>
											<span><?php p($l->t('Export to'))?> <b>dSpace</b></span>
										</a>
										</li>

										<li>
										<a href="" class="inforex-export one-zip-export">
											<span class="icon icon-external"></span>
											<span><?php p($l->t('Export to'))?> <b>Inforex</b></span>
										</a>
										</li>

										<li>
										<a href="" class="wosedon-export one-zip-export">
											<span class="icon icon-external"></span>
											<span><?php p($l->t('Export to'))?> <b>Wosedon</b></span>
										</a>
										</li>
										<li>
										<a href="" class="mewex-export one-zip-export">
											<span class="icon icon-external"></span>
											<span><?php p($l->t('Export to'))?> <b>Mewex</b></span>
										</a>
										</li>
									</ul>
								</div>
<!--							</a>-->
<!--						try to zip files-->
<!--						<a href="" class="zip">-->
<!--							<span class="icon icon-download"></span>-->
<!--							<span>--><?php //p($l->t('Zip files'))?><!--</span>-->
<!--						</a>-->
						</span>
					</span>
				</div>
			</th>
			<th id="headerSize" class="hidden column-size">
				<a class="size sort columntitle" data-sort="size"><span><?php p($l->t('Size')); ?></span><span class="sort-indicator"></span></a>
			</th>
			<th id="headerDate" class="hidden column-mtime">
				<a id="modified" class="columntitle" data-sort="mtime"><span><?php p($l->t( 'Modified' )); ?></span><span class="sort-indicator"></span></a>
					<span class="selectedActions"><a href="" class="delete-selected">
						<span><?php p($l->t('Delete'))?></span>
						<span class="icon icon-delete"></span>
					</a></span>
			</th>
		</tr>
	</thead>
	<tbody id="fileList">
	</tbody>
	<tfoot>
	</tfoot>
</table>
<input type="hidden" name="dir" id="dir" value="" />
<div class="hiddenuploadfield">
	<input type="file" id="file_upload_start" class="hiddenuploadfield" name="files[]" />
</div>
<div id="editor"></div><!-- FIXME Do not use this div in your app! It is deprecated and will be removed in the future! -->
<div id="uploadsize-message" title="<?php p($l->t('Upload too large'))?>">
	<p>
	<?php p($l->t('The files you are trying to upload exceed the maximum size for file uploads on this server.'));?>
	</p>
</div>
