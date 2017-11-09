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
													<td><input class=\"single-file-checkbox\" name=\"file-select-".$key."\" type=\"checkbox\" checked></td>
													<td>".$file['name']."</td>
													<td>".$file['path']."</td>
												</tr>");
										} ?>
										</tbody>
									</table>
									<label id="no-files-selected-msg" class="error error-external" hidden>No files seleted.</label>
								</div>
							</div>
						</div>
						<div class="col-lg-9 col-lg-pull-3 main-form-content">
							<div id="resource-basic-information" class="block">
								<div class="row">

									<form id="export-form" class="form-horizontal">
									<div class="row">
										<h4>Basic Information</h4>
										<div class="col-sm-7">
											<div class="form-group">
												<label class="control-label col-sm-5">Resource name*: </label>
												<div class="col-sm-7">
													<input name="name" class="form-control" placeholder="resource name" required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-5">Resource class*: </label>
												<div class="col-sm-7">
													<select name="resourceClass" class="form-control" required>
														<option value=""></option>
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
										<div class="col-sm-5">
											<div class="panel-group">
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
															<a data-toggle="collapse" href="#optional-panel-basic-info">Optional fields <span class="glyphicon glyphicon-plus"></span></a>
														</h4>
													</div>
													<div id="optional-panel-basic-info" class="panel-collapse collapse">
														<div class="panel-body">
															<div class="row">
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
																<div class="form-group">
																	<label class="control-label col-sm-5">Size: </label>
																	<div class="col-sm-7 form-inline">
																		<input name="size" min="0" step="1" type="number" class="form-control" placeholder="optional size">
																		<select name="sizeUnit"class="form-control">
																			<option value="">N/A</option>
																			<option value="terms">terms</option>
																			<option value="entries">entries</option>
																			<option value="turns">turns</option>
																			<option value="utterances">utterances</option>
																			<option value="articles">articles</option>
																			<option value="files">files</option>
																			<option value="items">items</option>
																			<option value="seconds">seconds</option>
																			<option value="elements">elements</option>
																			<option value="units">units</option>
																			<option value="minutes">minutes</option>
																			<option value="hours">hours</option>
																			<option value="texts">texts</option>
																			<option value="sentences">sentences</option>
																			<option value="pages">pages</option>
																			<option value="bytes">bytes</option>
																			<option value="tokens">tokens</option>
																			<option value="words">words</option>
																			<option value="keywords">keywords</option>
																			<option value="idiomaticExpressions">idiomaticExpressions</option>
																			<option value="neologisms">neologisms</option>
																			<option value="multiWordUnits">multiWordUnits</option>
																			<option value="expressions">expressions</option>
																			<option value="synsets">synsets</option>
																			<option value="classes">classes</option>
																			<option value="concepts">concepts</option>
																			<option value="lexicalTypes">lexicalTypes</option>
																			<option value="phoneticUnits">phoneticUnits</option>
																			<option value="syntacticUnits">syntacticUnits</option>
																			<option value="semanticUnits">semanticUnits</option>
																			<option value="predicates">predicates</option>
																			<option value="phonemes">phonemes</option>
																			<option value="diphones">diphones</option>
																			<option value="T-HPairs">T-HPairs</option>
																			<option value="syllables">syllables</option>
																			<option value="frames">frames</option>
																			<option value="images">images</option>
																			<option value="kb">kb</option>
																			<option value="mb">mb</option>
																			<option value="gb">gb</option>
																			<option value="rb">rb</option>
																			<option value="shots">shots</option>
																			<option value="unigrams">unigrams</option>
																			<option value="bigrams">bigrams</option>
																			<option value="trigrams">trigrams</option>
																			<option value="4-grams">4-grams</option>
																			<option value="5-grams">5-grams</option>
																			<option value="n-grams">n-grams</option>
																			<option value="rules">rules</option>
																			<option value="other">other</option>
																		</select>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<hr>
									<div class="row">
										<h4>Creation Circumstances</h4>
										<div class="col-sm-7">
											<div class="form-group">
												<label class="control-label col-sm-5">Organization*: </label>
												<div class="col-sm-7">
													<input name="organization" class="form-control" placeholder="organization..." required>
												</div>
											</div>
										</div>
										<div class="col-sm-5">
											<div class="panel-group">
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
															<a data-toggle="collapse" href="#optional-panel-creation-circumstances">Optional fields <span class="glyphicon glyphicon-plus"></span></a>
														</h4>
													</div>
													<div id="optional-panel-creation-circumstances" class="panel-collapse collapse">
														<div class="panel-body">
															<div class="row">
																<div class="form-group">
																	<label class="control-label col-sm-5">Project name: </label>
																	<div class="col-sm-7">
																		<input name="projectName" class="form-control" placeholder="optional project name...">
																	</div>
																</div>
																<div class="form-group">
																	<label class="control-label col-sm-5">Creator: </label>
																	<div class="col-sm-7">
																		<input name="creator" type="text" class="form-control" placeholder="optional creator name...">
																	</div>
																</div>
																<div class="form-group">
																	<label class="control-label col-sm-5">Country: </label>
																	<div class="col-sm-7">
																		<select name="country" class="form-control" value="">
																			<option></option>
																		</select>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<hr>
									<div class="row">
										<h4>Access information</h4>
										<div class="col-sm-7">
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
										<div class="col-sm-5">
											<div class="panel-group">
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
															<a data-toggle="collapse" href="#optional-panel-access-info">Optional fields <span class="glyphicon glyphicon-plus"></span></a>
														</h4>
													</div>
													<div id="optional-panel-access-info" class="panel-collapse collapse">
														<div class="panel-body">
															<div class="row">
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
													</div>
												</div>
											</div>
										</div>
									</div>
									<hr>
									<div class="row">
										<h4>Content</h4>
										<div class="col-sm-7">
											<div class="form-group">
												<label class="control-label col-sm-5">Language*: </label>
												<div class="col-sm-7">
													<select name="language" type="text" class="form-control"required>
														<option value=""></option>
													</select>
												</div>
											</div>
										</div>
										<div class="col-sm-5">
											<div class="panel-group">
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
															<a data-toggle="collapse" href="#optional-panel-content">Optional fields <span class="glyphicon glyphicon-plus"></span></a>
														</h4>
													</div>
													<div id="optional-panel-content" class="panel-collapse collapse">
														<div class="panel-body">
															<div class="row">
																<div class="form-group">
																	<label class="control-label col-sm-5">Modality*: </label>
																	<div class="col-sm-7">
																		<select name="modality" class="form-control" required>
																			<option value=""></option>
																		</select>
																	</div>
																</div>
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
													</div>
												</div>
											</div>
										</div>
									</div>
									<hr>
									<div class="row">
										<h4></h4>
										<div class="panel-group">
											<div class="panel panel-default">
												<div class="panel-heading">
													<h4 class="panel-title">
														<a data-toggle="collapse" href="#collapse-optional-pub-details">Optional publication details <span class="glyphicon glyphicon-plus"></span></a>
													</h4>
												</div>
												<div id="collapse-optional-pub-details" class="panel-collapse collapse">
													<div class="panel-body">
														<div class="row">
															<div class="col-sm-7">
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
															<div class="col-sm-5">
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
													</div>
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