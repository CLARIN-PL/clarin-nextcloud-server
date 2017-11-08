<?php
script('clarin', 'bootstrap.min');
script('clarin', 'exportDSpace');
style('clarin', 'bootstrap.min');
style('clarin', 'style');
?>

<div id="app">
	<?php print_unescaped($this->inc('navigation/index')); ?>
	<?php //print_unescaped($this->inc('settings/index')); ?>

	<div id="app-content" class="app-content">
		<div id="app-content-wrapper">
			<?php //print_unescaped($this->inc('content/index')); ?>

			<form class="form-horizontal" id="export-form">
				<div class="form-main-container">
					<div class="row">
						<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
							<div id="selected-files" class="right-container">
								<div class="form-header">
									<h3 style="color:#fff">Selected files</h3>
								</div>
								<div class="form-body">
									<table class="table table-responsive table-hover mytable"
										   id="filesTable">
										<thead>
										<tr>
											<th style="width: 10%"></th>
											<th style="width: 40%">Filename</th>
											<th style="width: 40%">Path</th>
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
						<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
							<div id="resource-basic-information" class="block">
								<div class="form-header">
									<h3>Create Public DSpace Item</h3>
								</div>

								<div class="form-body">
									<div class="row">
										<div class="col-lg-5 col-md-5 col-sm-12 col-xs-12">
											<div class="row row-all">
												<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
													<div class="form-group form-group-adjust required">
														<label class="label-adjust"
															   for="resourceName">Resource
															Name</label>
														<input type="text"
															   class="form-control"
															   id="resourceName"
															   name="resourceName"
															   value="Cloud Export Test #1">
													</div>

													<div class="form-group form-group-adjust form-group-select required">
														<label class="label-adjust">Resource
															Class</label>
														<input type="text"
															   id="resourceClass"
															   name="resourceClass"
															   list="resourceClass-datalist"
															   placeholder="e.g. Grammar"
															   value="unknown">
														<datalist
																id="resourceClass-datalist"></datalist>
													</div>
												</div>

												<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
													<div class="form-group form-group-adjust required">
														<label class="label-adjust"
															   for="metadataTag">Keywords</label>
														<input type="text"
															   class="form-control"
															   id="metadataTag"
															   name="metadataTag"
															   required="true"
															   value="Cloud, Test">
													</div>
													<div class="form-group form-group-adjust form-group-select required">
														<label class="label-adjust"
															   for="dateIssued">Date
															Issued:</label>
														<input type="text"
															   id="dateIssued"
															   name="dateIssued"
															   value="31/09/2020">
													</div>
												</div>

											</div>
										</div>

										<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
											<div class="form-group form-group-adjust-textarea required">
												<label class="label-adjust"
													   for="description">Description</label>
												<textarea class="form-control"
														  rows="5"
														  id="description"
														  name="description">Test of files import to public repository</textarea>
											</div>
										</div>

									</div> <!-- End of row -->
								</div>    <!-- End of form-body -->

							</div> <!-- End of resource-basic-information -->

							<div id="creation-circumstances" class="block">
								<div class="form-header">
									<h3></h3>
								</div>
								<div class="form-body">
									<div class="row">
										<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
											<div class="form-group required">
												<label for="organization">Organization</label>
												<input type="text"
													   class="form-control"
													   id="organization"
													   name="organization"
													   value="WroclawKoukaDaigaku">
											</div>
										</div>

										<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
											<div class="form-group form-first required">
												<label for="availability">Availability</label>
												<input type="text"
													   class="form-control"
													   id="availability"
													   name="availability"
													   value="public">
											</div>
										</div>

										<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
											<div class="form-group required">
												<label for="iprHolder">Rights
													Holder</label>
												<input type="text"
													   class="form-control"
													   id="iprHolder"
													   name="iprHolder"
													   value="PWR">
											</div>
										</div>

										<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
											<div class="form-group form-last required">
												<label for="licenseName">License
													Name</label>
												<input type="text"
													   class="form-control"
													   id="licenseName"
													   name="licenseName"
													   value="test">
											</div>
										</div>
									</div>

								</div>
							</div>


							<div id="resource-content" class="block">
								<div class="form-header">
									<h3></h3>
								</div>
								<div class="form-body">
									<div class="row row-margin-first">

										<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
											<div class="form-group required">
												<label for="modalityInfo">modalityInfo</label>
												<input type="text"
													   id="modalityInfo"
													   name="modalityInfo"
													   list="modalityInfo-datalist"
													   placeholder="e.g. written"
													   value="written">
												<datalist
														id="modalityInfo-datalist"></datalist>
											</div>
										</div>


										<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
											<div class="form-group required">
												<label for="SubjectLanguage">SubjectLanguage</label>
												<input type="text"
													   class="form-control"
													   id="SubjectLanguage"
													   name="SubjectLanguage"
													   value="pol">
											</div>

											<!-- Empty column? Check it! -->
											<!--<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"></div>-->
										</div>
									</div>
								</div>
							</div>

<!--							<div class="form-buttons">-->
								<div class="form-group form-group-last">
									<div class="col-xs-12">
										<button type="submit"
												class="btn btn-success"
												id="submit-dspace-form-btn">
											<span>Submit</span>
										</button>
									</div>

									<!--								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">-->
									<!--									<button type="submit" class="btn btn-default button-cancel">-->
									<!--										<span>Cancel</span>-->
									<!--									</button>-->
									<!--								</div>-->
<!--								</div>-->
							</div>
						</div>
					</div>
				</div>

			</form>
		</div>
	</div>
</div>

<script nonce="<?php p(\OC::$server->getContentSecurityPolicyNonceManager()->getNonce()) ?>"
		type="text/javascript">

	var dSpacePossibleFiles =<?php echo(json_encode($_['files'])); ?>;

</script>

<!--
	<tr>
		<td>
			<input id="select-1" type="checkbox" checked>
		</td>
		<td class="filename">
			<img src="--><?php //p($_['files'][0]['icon']); ?><!--" class="icon">
			Test1
		</td>
		<td> /Lorem/ipsum/Lorem/ipsum/Lorem/Lorem/ipsum/Lorem/ipsum/Lorem/Lorem/ipsum/Lorem/ipsum/Lorem/Lorem/ipsum/Lorem/ipsum/Lorem/Lorem/ipsum/Lorem/ipsum/Lorem/Lorem/ipsum/Lorem/ipsum/Lorem  </td>
		<td>
			<a>http://szefwszystkichszefuff.pl</a>
		</td>
	</tr>
	<tr>
		<td>
			<input id="select-2" type="checkbox" checked>
		</td>
		<td>Test2</td>
		<td> / </td>
		<td>
			<a>http://szefwszystkichszefuff.pl</a>
		</td>
	</tr>
	<tr>
		<td>
			<input id="select-3" type="checkbox" checked>
		</td>
		<td>Test3</td>
		<td> / </td>
		<td>
			<a>http://szefwszystkichszefuff.pl</a>
		</td>
	</tr>
-->
