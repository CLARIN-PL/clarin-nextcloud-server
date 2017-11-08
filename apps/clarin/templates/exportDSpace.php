<?php
script('clarin', 'bootstrap.min');
script('clarin', 'exportDSpace');
script('clarin', 'jquery.validate.min');
script('clarin', 'additional-methods.min');
style('clarin', 'bootstrap.min');
style('clarin', 'style');
?>

<div id="app">
	<?php print_unescaped($this->inc('navigation/index')); ?>
	<?php //print_unescaped($this->inc('settings/index')); ?>

	<div id="app-content" class="app-content">
		<div id="app-content-wrapper">
			<?php //print_unescaped($this->inc('content/index')); ?>

				<div class="form-main-container container-fluid">
					<div class="row">
						<div class="col-xs-12">

							<h3>Create Public DSpace Item</h3>

						</div>
					</div>
					<div class="row">
						<div class="col-lg-3 col-lg-push-9 col-right-content">
							<div class="row">
								<h4>Files selected for submission:</h4>
								<div class="col-xs-12">
									<table class="table table-responsive"
										   id="filesTable">
										<thead>
										<tr class="table-header-row">
											<th>
												<input id="all-files-select-checkbox" type="checkbox" checked>
											</th>
											<th>Filename</th>
											<th>Path</th>
										</tr>
										</thead>
										<tbody>
										<?php
										foreach($_['files'] as $key => $file){
											echo("<tr>
													<td><input name=\"file-select-".$key."\" type=\"checkbox\" checked></td>
													<td>".$file['name']."</td>
													<td>".$file['path']."</td>
												</tr>");
										} ?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="col-lg-9 col-lg-pull-3 main-form-content">
							<div id="resource-basic-information" class="block">
								<div class="row">

									<form id="export-form" class="form-horizontal">
									<div class="row">
										<h4>Basic Information</h4>
										<div class="col-sm-6">
											<div class="form-group">
												<label class="control-label col-sm-5">Resource name*: </label>
												<div class="col-sm-7">
													<input name="name" class="form-control" placeholder="resource name" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-5">Resource class*: </label>
												<div class="col-sm-7">
													<select name="resourceClass" class="form-control" value="" required>
														<option>1</option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-5">Date issued*: </label>
												<div class="col-sm-7">
													<input name="date" class="form-control" type="date" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-5" for="email">Keywords*: </label>
												<div class="col-sm-7">
													<input name="keywords" type="text" class="form-control" placeholder="keywords" required>
												</div>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label class="control-label col-sm-5">Description: </label>
												<div class="col-sm-7">
													<textarea name="description" type="text" class="form-control" placeholder="description"></textarea>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-5">Contact: </label>
												<div class="col-sm-7">
													<textarea name="contact" type="text" class="form-control" placeholder="Optional contact information... (Person, Address, Email, Organisation, Telephone, Website)"></textarea>
												</div>
											</div>
										</div>
									</div>
									<hr>
									<div class="row">
										<h4>Creation Circumstances</h4>
										<div class="col-sm-6">
											<div class="form-group">
												<label class="control-label col-sm-5">Organization*: </label>
												<div class="col-sm-7">
													<input name="organization" class="form-control" placeholder="organization..." required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-5">Project name: </label>
												<div class="col-sm-7">
													<input name="projectName" class="form-control" placeholder="optional project name...">
												</div>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label class="control-label col-sm-5">Creator: </label>
												<div class="col-sm-7">
													<input name="creator" type="text" class="form-control" placeholder="optional creator name...">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-5">Country: </label>
												<div class="col-sm-7">
													<input name="country" type="text" class="form-control" placeholder="optional country...">
												</div>
											</div>
										</div>
									</div>
									<hr>
									<div class="row">
										<h4>Access information</h4>
										<div class="col-sm-6">
											<div class="form-group">
												<label class="control-label col-sm-5">Availability*: </label>
												<div class="col-sm-7">
													<input name="availability" type="text" class="form-control" placeholder="availability..." required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-5">Rights holder*: </label>
												<div class="col-sm-7">
													<input name="rightsHolder" type="text" class="form-control" placeholder="rights holder..." required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-5">License*: </label>
												<div class="col-sm-7">
													<input name="license" type="text" class="form-control" placeholder="license name..." required>
												</div>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label class="control-label col-sm-5">License label: </label>
												<div class="col-sm-7">
													<input name="license" type="text" class="form-control" placeholder="optional license label...">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-5">Demo link: </label>
												<div class="col-sm-7">
													<input name="demoLink" type="text" class="form-control" placeholder="optional demo link...">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-5">License label: </label>
												<div class="col-sm-7">
													<input name="licenseLabel" type="text" class="form-control" placeholder="optional license label...">
												</div>
											</div>
										</div>
									</div>
									<hr>
									<div class="row">
										<h4>Content</h4>
										<div class="col-sm-6">
											<div class="form-group">
												<label class="control-label col-sm-5">Language*: </label>
												<div class="col-sm-7">
													<input name="lang" type="text" class="form-control" placeholder="subject language..." required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-5">Modality*: </label>
												<div class="col-sm-7">
													<input name="modality" type="text" class="form-control" placeholder="modality..." required>
												</div>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label class="control-label col-sm-5">subject: </label>
												<div class="col-sm-7">
													<input name="subject" type="text" class="form-control" placeholder="optional subject...">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-5">Genre: </label>
												<div class="col-sm-7">
													<input name="genre" type="text" class="form-control" placeholder="optional genre...">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-5">Temporal Coverage: </label>
												<div class="col-sm-7">
													<input name="temporalCoverage" type="text" class="form-control" placeholder="optional temporal coverage...">
												</div>
											</div>
										</div>
									</div>
									<hr>
									<div class="row">
										<h4>Optional publication details</h4>
										<div class="col-sm-6">
											<div class="form-group">
												<label class="control-label col-sm-5">Title: </label>
												<div class="col-sm-7">
													<input name="title" type="text" class="form-control" placeholder="optional title...">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-5">Author: </label>
												<div class="col-sm-7">
													<input name="author" type="text" class="form-control" placeholder="optional author...">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-5">Url: </label>
												<div class="col-sm-7">
													<input name="url" type="text" class="form-control" placeholder="optional url...">
												</div>
											</div>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<label class="control-label col-sm-5">Publication Place: </label>
												<div class="col-sm-7">
													<input name="publicationPlace" type="text" class="form-control" placeholder="optional publication place...">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-5">Publication date: </label>
												<div class="col-sm-7">
													<input name="publicationDate" type="text" class="form-control" placeholder="optional publication date...">
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-5">Descriptions: </label>
												<div class="col-sm-7">
													<input name="descriptions" type="text" class="form-control" placeholder="optional descriptions...">
												</div>
											</div>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-offset-4 col-sm-4">
											<button type="submit" id="submit-dspace-form-btn" class="btn btn-default">Submit</button>
										</div>
									</div>
								</form>
								</div>
						</div>
					</div>
				</div>
		</div>
	</div>
</div>

<script nonce="<?php p(\OC::$server->getContentSecurityPolicyNonceManager()->getNonce()) ?>"
		type="text/javascript">

	var dSpacePossibleFiles =<?php echo(json_encode($_['files'])); ?>;

</script>