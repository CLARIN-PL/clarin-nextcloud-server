<?php
script('clarin', 'bootstrap.min');
script('clarin', 'exportDSpace');
script('clarin', 'jquery.validate.min');
script('clarin', 'additional-methods.min');
script('clarin', 'bootstrap-select.min');
style('clarin', 'bootstrap.min');
style('clarin', 'style');
style('clarin', 'bootstrap-select.min');
?>

<div id="app">
	<?php print_unescaped($this->inc('navigation/index')); ?>
	<div id="app-content" class="app-content">
		<div id="app-content-wrapper">
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
									<div id="main-export-div" class="form-horizontal">
									<div class="row">
										<h4>Basic Information</h4>
										<div class="col-sm-6">
											<form class="form-horizontal">
												<div class="form-group">
													<label class="control-label col-sm-5">Resource name*: </label>
													<div class="col-sm-7">
														<input name="dc.title" class="form-control" placeholder="resource name" required>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-5">Resource type*: </label>
													<div class="col-sm-7">
														<select name="dc.type" data-live-search="true" class="form-control selectpicker" required>
														</select>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-5">Date issued*: </label>
													<div class="col-sm-7">
														<input name="dc.date.issued" class="form-control" type="date" value="<?php echo date('Y-m-d'); ?>" required>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-5">Description*: </label>
													<div class="col-sm-7">
														<textarea name="dc.description" type="text" class="form-control" placeholder="description" required></textarea>
													</div>
												</div>
											</form>
											<form class="form-horizontal form-multiple-options">
												<div class="form-group">
													<label class="control-label col-sm-5">Subject Keywords*: </label>
													<div class="col-sm-7 padding-top-column">
														<label id="keywords-list-error-label" style="display:none" class="error">This field is required. Add at least one keyword using the button on the right.</label>
														<ul class="expandable-list" id="keywords-list">
														</ul>
														<div class="row">
															<div class="col-sm-9"><input name="dc.subject" type="text" class="form-control input-add" placeholder="keywords" required></div>
															<div class="col-sm-3"><button type="submit" class="btn btn-default addOptionButton">Add <span class="glyphicon glyphicon-plus glyphicon-add-option"></span></button></div>
														</div>
													</div>
												</div>
											</form>
										</div>
										<div class="col-sm-6">
											<div class="panel-group">
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
															<a data-toggle="collapse" href="#optional-panel-basic-info">Optional contact information<span class="glyphicon glyphicon-plus"></span></a>
														</h4>
													</div>
													<div id="optional-panel-basic-info" class="panel-collapse collapse">
														<div class="panel-body">
															<div class="row">
																<form class="form-horizontal form-multiple-options">
																	<div class="form-group">
																		<div class="col-sm-12">
																			<div class="col-sm-8 col-sm-offset-4 expandable-list-container">
																			<small><i class="info-expandable-list help-block">You have to input data and press "add contact" button to add contact person.</i></small>
																			<ul class="expandable-list" id="contact-list">
																			</ul>
																			</div>
																			<label class=" control-label col-sm-4">Person:</label>
																			<div class="col-sm-8">
																				<input name="contact-person" placeholder="Optional contact person" type="text" required>
																			</div>
																			<label  class=" control-label col-sm-4">Address:</label>
																			<div class="col-sm-8">
																			<input name="contact-address" placeholder="Optional contact address" type="text" required>
																			</div>
																			<br>
																			<label class=" control-label col-sm-4">Email:</label>
																			<div class="col-sm-8">
																			<input name="contact-email" placeholder="Optional contact email" type="email" required>
																			</div>
																			<br>
																			<label class=" control-label col-sm-4">Organisation:</label>
																			<div class="col-sm-8">
																			<input name="contact-organisation" placeholder="Optional contact organisation" type="text" required>
																			</div>
																			<br>
																			<label class=" control-label col-sm-4">Telephone:</label>
																			<div class="col-sm-8">
																			<input name="contact-telephone" placeholder="Optional contact telephone" type="tel" required>
																			</div>
																			<br>
																			<label class=" control-label col-sm-4">Website:</label>
																			<div class="col-sm-8">
																			<input name="contact-website" placeholder="Optional contact website" type="text" required>
																			</div>
																			<div class="col-sm-8 col-sm-offset-4">
																			<button type="submit" class="btn btn-default addOptionButton">Add contact</button>
																			</div>
																		</div>
																	</div>
																</form>

															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="panel-group">
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
															<a data-toggle="collapse" href="#optional-panel-size-info">Optional size information<span class="glyphicon glyphicon-plus"></span></a>
														</h4>
													</div>
													<div id="optional-panel-size-info" class="panel-collapse collapse">
														<div class="panel-body">
															<div class="row">
																<form class="form-horizontal form-multiple-options">
																	<div class="form-group">
																		<div class="col-sm-12">
																		</div>
																	</div>
																	<form class="form-horizontal form-multiple-options">
																		<div class="form-group">
																			<div class="col-sm-12 form-inline">
																				<div class="col-sm-8 col-sm-offset-4 expandable-list-container">
																				<small><i class="info-expandable-list help-block">You have to input data and press "add contact" button to add contact person.</i></small>
																				<ul class="expandable-list" id="size-list">
																				</ul>
																				</div>
																				<label class="col-sm-4">
																					Size:
																				</label>
																				<div class="col-sm-8">
																				<input name="size" min="0" step="1" type="number" class="form-control" placeholder="optional size" required>
																				</div>
																				<label class="col-sm-4">
																					Size unit:
																				</label>
																				<div class="col-sm-8">
																				<select name="sizeUnit" data-live-search="true" data-size="10" class="form-control selectpicker" required>
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
																				<div class="col-sm-8 col-sm-offset-4">
																				<button type="submit" class="btn btn-default addOptionButton">Add size</button>
																				</div>
																				<br>
																				<br>


																			</div>
																		</div>
																	</form>
																</form>
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
										<div class="col-sm-6">
											<form class="form-horizontal">
												<div class="form-group">
													<label class="control-label col-sm-5 col-md-4">Organization*: </label>
													<div class="col-sm-7 col-md-8">
														<input name="metashare.ResourceInfo#ContactInfo#PersonInfo#OrganizationInfo.organizationName" class="form-control" placeholder="organization..." required>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-5 col-md-4">Project name*: </label>
													<div class="col-sm-7  col-md-8">
														<input name="metashare.ResourceInfo#ResourceCreationInfo#FundingInfo#ProjectInfo.projectName" class="form-control" placeholder="optional project name...">
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-5 col-md-4">Country*: </label>
													<div class="col-sm-7 col-md-8">
														<select name="local.country" data-size="10" data-live-search="true" class="form-control selectpicker">
														</select>
													</div>
												</div>
											</form>
										</div>
										<div class="col-sm-6">
											<form class="form-horizontal form-multiple-options">
												<div class="form-group">
														<label class=" control-label col-sm-5">Creators*: </label>
														<div class="col-sm-7">
															<small><i class="info-expandable-list help-block">You have to input data and press "add creator" button to add creator.</i></small>
															<label id="creators-list-error-label" style="display:none" class="error">This field is required. Add at least one creator using the button "add creator" button.</label>
															<ul class="expandable-list" id="creators-list">
															</ul>
														</div>
														<br>
														<label class="col-sm-5 control-label">Surname:</label>
														<div class="col-sm-7">
														<input name="creator-surname" type="text" class="form-control" placeholder="optional creator name and surname..." required>
														</div>
														<br>
														<label class="col-sm-5 control-label">Name: </label>
														<div class="col-sm-7">
														<input name="creator" type="text" class="form-control" placeholder="optional creator name and surname..." required>
														</div>
														<div class="col-sm-7 col-sm-offset-5">
														<button type="submit" class="btn btn-default addOptionButton">Add creator</button>
														</div>
												</div>
											</form>

										</div>
										</div>
									</div>
									<hr>
									<div class="row">
										<h4>Access information</h4>
										<div class="col-sm-6">
											<form class="form-horizontal">
											<div class="form-group">
												<label class="control-label col-sm-5">Availability*: </label>
												<div class="col-sm-7">
													<input title="e.g. free; free for academic use; restricted use; request required; user licence required; registration required; unknown"
															name="dcterms.accessRights" type="text" class="form-control" placeholder="availability in simple words..." required>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-5">Rights holder*: </label>
												<div class="col-sm-7">
													<input name="dc.rights.holder" type="text" class="form-control" placeholder="rights holder..." required>
												</div>
											</div>
											</form>
										</div>
										<div class="col-sm-6">
											<form class="form-horizontal">
												<div class="form-group">
													<div class="form-group">
														<label class="control-label col-sm-5">Demo URL*: </label>
														<div class="col-sm-7">
															<input name="local.demo.uri" type="text" class="form-control" placeholder="demo link..." required>
														</div>
													</div>
													<div class="form-group">
														<label class="control-label col-sm-5">License*: </label>
														<div class="col-sm-7">
															<!--todo make selectable + text -->

															<select name="dc.rights"  data-live-search="true" class="form-control selectpicker" data-size="8" required></select>
														</div>
													</div>
												</div>
											</form>

										</div>
									</div>
									<hr>
									<div class="row">
										<h4>Content</h4>
										<div class="col-sm-6">
											<form class="form-horizontal">
											<div class="form-group">
												<label class="control-label col-sm-5">Language*: </label>
												<div class="col-sm-7">
													<select name="dc.language.iso" data-live-search="true" data-size="10" class="form-control selectpicker"required>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-5">Modality*: </label>
												<div class="col-sm-7">
													<select name="local.modality.info" data-live-search="true" data-size="10" class="form-control selectpicker" required>
													</select>
												</div>
											</div>
											</form>
										</div>
										<div class="col-sm-6">
											<div class="panel-group">
												<div class="panel panel-default">
													<div class="panel-heading">
														<h4 class="panel-title">
															<a data-toggle="collapse" href="#optional-panel-content">Optional content information <span class="glyphicon glyphicon-plus"></span></a>
														</h4>
													</div>
													<div id="optional-panel-content" class="panel-collapse collapse">
														<div class="panel-body">
															<div class="row">
																<form class="form-horizontal">
																<div class="form-group">
																	<label class="control-label col-sm-5">subject: </label>
																	<div class="col-sm-7">
																		<input name="local.subject" type="text" class="form-control" placeholder="optional subject...">
																	</div>
																</div>
																<div class="form-group">
																	<label class="control-label col-sm-5">Genre: </label>
																	<div class="col-sm-7">
																		<input name="local.genre" type="text" class="form-control" placeholder="optional genre...">
																	</div>
																</div>
																<div class="form-group">
																	<label class="control-label col-sm-5">Temporal Coverage: </label>
																	<div class="col-sm-7">
																		<input name="dc.coverage.temporal" type="text" class="form-control" placeholder="optional temporal coverage...">
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
															<div class="col-sm-6">
																<form class="form-horizontal">
																<div class="form-group">
																	<label class="control-label col-sm-5">Title: </label>
																	<div class="col-sm-7">
																		<input name="local.publication.title" type="text" class="form-control" placeholder="optional title...">
																	</div>
																</div>
																<div class="form-group">
																	<label class="control-label col-sm-5">Author: </label>
																	<div class="col-sm-7">
																		<input name="local.publication.author" type="text" class="form-control" placeholder="optional author...">
																	</div>
																</div>
																<div class="form-group">
																	<label class="control-label col-sm-5">Url: </label>
																	<div class="col-sm-7">
																		<input name="local.publication.url" type="text" class="form-control" placeholder="optional url...">
																	</div>
																</div>
																</form>
															</div>
															<div class="col-sm-6">
																<form class="form-horizontal">
																<div class="form-group">
																	<label class="control-label col-sm-5">Publication Place: </label>
																	<div class="col-sm-7">
																		<input name="local.publication.place" type="text" class="form-control" placeholder="optional publication place...">
																	</div>
																</div>
																<div class="form-group">
																	<label class="control-label col-sm-5">Publication date: </label>
																	<div class="col-sm-7">
																		<input name="local.publication.date" type="date" class="form-control" placeholder="optional publication date...">
																	</div>
																</div>
																<div class="form-group">
																	<label class="control-label col-sm-5">Descriptions: </label>
																	<div class="col-sm-7">
																		<textarea name="local.publication.descriptions" class="form-control" placeholder="optional descriptions..."></textarea>
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
									<div class="form-group">
										<div class="col-sm-offset-4 col-sm-4">
											<button type="submit" id="submit-dspace-form-btn" class="btn btn-default">Submit</button>
										</div>
									</div>
								</div>
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