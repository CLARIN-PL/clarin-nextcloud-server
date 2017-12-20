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
														<select name="dc.type" class="form-control" required>
															<option value=""></option>
														</select>
													</div>
												</div>
<!--												<div class="form-group">-->
<!--													<label class="control-label col-sm-5">Resource class*: </label>-->
<!--													<div class="col-sm-7">-->
<!--														<select name="resourceClass" class="form-control" required>-->
<!--															<option value=""></option>-->
<!--														</select>-->
<!--													</div>-->
<!--												</div>-->
												<div class="form-group">
													<label class="control-label col-sm-5">Date issued*: </label>
													<div class="col-sm-7">
														<input name="dc.date.issued" class="form-control" type="date" value="<?php echo date('Y-m-d'); ?>" required>
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-5">Description: </label>
													<div class="col-sm-7">
														<textarea name="dc.description" type="text" class="form-control" placeholder="description" required></textarea>
													</div>
												</div>
											</form>
											<form class="form-horizontal form-multiple-options">
												<div class="form-group">
													<label class="control-label col-sm-5">Subject Keywords*: </label>
													<div class="col-sm-7 padding-top-column">
														<label id="keywords-error-label" style="display:none" class="error"></label>
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
															<a data-toggle="collapse" href="#optional-panel-basic-info">Optional fields <span class="glyphicon glyphicon-plus"></span></a>
														</h4>
													</div>
													<div id="optional-panel-basic-info" class="panel-collapse collapse">
														<div class="panel-body">
															<div class="row">
<!--																<form class="form-horizontal">-->
<!---->
<!--																</form>-->
																<form class="form-horizontal form-multiple-options">
																	<div class="form-group">
																		<label class="control-label col-sm-5">Contacts: </label>
																		<div class="col-sm-7">
																			<ul class="expandable-list" id="contact-list">
																			</ul>
																			<br>
																			<label>Person:</label>
																			<input name="contact-person" placeholder="Optional contact person" type="text" required>

																			<br>
																			<label>Address:</label>
																			<input name="contact-address" placeholder="Optional contact address" type="text" required>

																			<br>
																			<label>Email:</label>
																			<input name="contact-email" placeholder="Optional contact email" type="email" required>

																			<br>
																			<label>Organisation:</label>
																			<input name="contact-organisation" placeholder="Optional contact organisation" type="text" required>

																			<br>
																			<label>Telephone:</label>
																			<input name="contact-telephone" placeholder="Optional contact telephone" type="tel" required>

																			<br>
																			<label>Website:</label>
																			<input name="contact-website" placeholder="Optional contact website" type="text" required>

																			<button type="submit" class="btn btn-default addOptionButton">Add contact</button>

																		</div>
																	</div>
																</form>
																<form class="form-horizontal form-multiple-options">
																<div class="form-group">
																	<label class="control-label col-sm-5">Size: </label>
																	<div class="col-sm-7 form-inline">
																		<ul class="expandable-list" id="size-list">
																		</ul>

																		<input name="size" min="0" step="1" type="number" class="form-control" placeholder="optional size" required>
																		<select name="sizeUnit"class="form-control" required>
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

																		<button type="submit" class="btn btn-default addOptionButton">Add size</button>
																		<br>
																		<br>


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
													<label class="control-label col-sm-5 col-md-4">Project name: </label>
													<div class="col-sm-7  col-md-8">
														<input name="metashare.ResourceInfo#ResourceCreationInfo#FundingInfo#ProjectInfo.projectName" class="form-control" placeholder="optional project name...">
													</div>
												</div>
												<div class="form-group">
													<label class="control-label col-sm-5 col-md-4">Country: </label>
													<div class="col-sm-7 col-md-8">
														<select name="local.country" class="form-control" value="">
															<option></option>
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
															<a data-toggle="collapse" href="#optional-panel-creation-circumstances">Optional fields <span class="glyphicon glyphicon-plus"></span></a>
														</h4>
													</div>
													<div id="optional-panel-creation-circumstances" class="panel-collapse collapse">
														<div class="panel-body">
															<div class="row">
																<form class="form-horizontal form-multiple-options">
																<div class="form-group">
																	<label class="control-label col-sm-5 col-md-4">Creators: </label>
																	<div class="col-sm-7 col-md-8">
																		<ul class="expandable-list" id="creators-list">
																		</ul>
																		<br>
																		<label class="control-label">Surname:</label>
																		<input name="creator-surname" type="text" class="form-control" placeholder="optional creator name and surname..." required>
																		<br>
																		<label class="control-label">Name: </label>
																		<input name="creator" type="text" class="form-control" placeholder="optional creator name and surname..." required>
																		<button type="submit" class="btn btn-default addOptionButton">Add creator</button>
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
											<div class="form-group">
												<label class="control-label col-sm-5">License*: </label>
												<div class="col-sm-7">
													<!--todo make selectable + text -->
													<input title="A description of the licensing conditions under which the resource can be used."
															name="dc.rights" type="text" class="form-control" placeholder="license name..." required>
												</div>
											</div>
											</form>
										</div>
										<div class="col-sm-6">
											<form class="form-horizontal">
												<div class="form-group">
													<div class="form-group">
														<label class="control-label col-sm-5">License Label*: </label>
														<div class="col-sm-7">
															<input name="dc.rights.label" type="text" class="form-control" placeholder="license label..." required>
														</div>
													</div>
													<div class="form-group">
														<label class="control-label col-sm-5">License URL*: </label>
														<div class="col-sm-7">
															<input name="dc.rights.uri" type="text" class="form-control" placeholder="license url..." required>
														</div>
													</div>
													<div class="form-group">
														<label class="control-label col-sm-5">Demo URL: </label>
														<div class="col-sm-7">
															<input name="local.demo.uri" type="text" class="form-control" placeholder="demo link..." required>
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
													<select name="dc.language.iso" type="text" class="form-control"required>
														<option value=""></option>
													</select>
												</div>
											</div>
											<div class="form-group">
												<label class="control-label col-sm-5">Modality*: </label>
												<div class="col-sm-7">
													<select name="local.modality.info" class="form-control" required>
														<option value=""></option>
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
															<a data-toggle="collapse" href="#optional-panel-content">Optional fields <span class="glyphicon glyphicon-plus"></span></a>
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
																		<textarea name="local.publication.descriptions" type="text" class="form-control" placeholder="optional descriptions..."></textarea>
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