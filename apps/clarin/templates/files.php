<?php
	script('clarin','bootstrap.min');
	script('clarin', 'files');
	style('clarin', 'bootstrap.min');
	style('clarin', 'style');
?>

<!--
<link href="https://fonts.googleapis.com/css?family=Roboto|Saira+Semi+Condensed:400,700&amp;subset=latin-ext" rel="stylesheet">
-->

<div id="app">
	<?php //print_unescaped($this->inc('navigation/index')); ?>
	<?php //print_unescaped($this->inc('settings/index')); ?>

	<div id="app-content" class="app-content">
		<div id="app-content-wrapper">
			<?php //print_unescaped($this->inc('content/index')); ?>

			<form class="form-horizontal" id="export-form">
				<div class="form-main-container">
					<div class="row">
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
													<label class="label-adjust" for="resourceName">Resource Name</label>
													<input type="text" class="form-control" id="resourceName" value="Cloud Export Test #1">
												</div>

												<div class="form-group form-group-adjust form-group-select required">
													<label class="label-adjust">Resource Class</label>
													<input type="text" id="resourceClass" list="resourceClass-datalist" placeholder="e.g. Grammar" value="unknown">
													<datalist id="resourceClass-datalist"></datalist>
													<!-- SVG Icon -->
													<!--<svg height="10" width="10">
														<path d="M0 0 L10 0 L5 10 Z" />
														Sorry, your browser does not support inline SVG.
													</svg>
													<svg height="7" width="15">
														<polygon points="0,0 15,0 7,7" style="fill:lime;stroke:purple;stroke-width:1" />
														Sorry, your browser does not support inline SVG.
													</svg>-->
												</div>
											</div>

											<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
												<div class="form-group form-group-adjust required">
													<label class="label-adjust" for="metadataTag">Keywords</label>
													<input type="text" class="form-control" id="metadataTag" required="true" value="Cloud, Test">
												</div>
												<div class="form-group form-group-adjust form-group-select required">
													<label class="label-adjust" for="dateIssued">Date Issued:</label>
													<input type="text" id="dateIssued" value="31/09/2020">
												</div>
											</div>

										</div>
									</div>

									<div class="col-lg-7 col-md-7 col-sm-12 col-xs-12">
										<div class="form-group form-group-adjust-textarea required">
											<label class="label-adjust" for="description">Description</label>
											<textarea class="form-control" rows="5" id="description">Test of files import to public repository</textarea>
										</div>
									</div>

							</div> <!-- End of row -->

<!--							<div class="row optional">-->
<!--								<h3 href="#basic-optional" class="header" data-toggle="collapse">-->
<!--									Optional-->
<!--									<svg height="10" width="10">-->
<!--										<path d="M0 0 L10 0 L5 10 Z" />-->
<!--										Sorry, your browser does not support inline SVG.-->
<!--									</svg>-->
<!--									<!---->
<!--										SVG Test (font awesome etc doesnt work)-->
<!--										<i class="fa fa-repeat" aria-hidden="true"></i>-->
<!--									-->
<!--								</h3>-->
<!--								<!--<div id="basic-optional" class="collapse optional-content">-->
<!--								<div id="basic-optional" class="collapse in optional-content">-->
<!--									<div class="row">-->
<!--										<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">-->
<!--											<div class="form-group form-group-adjust">-->
<!--												<label for="issue.date">Date issued</label>-->
<!--												<input type="text" class="form-control" id="issue.date">-->
<!--											</div>-->
<!---->
<!--											<div class="form-group form-group-adjust optional-form-group-adjust">-->
<!--												<label for="sizeInfo">Size</label>-->
<!--												<input type="text" class="form-control" id="sizeInfo">-->
<!--												<div class="select-wrapper">-->
<!--													<select id="sizeInfo">-->
<!--														<option value="test1">test1</option>-->
<!--														<option value="test2">test2</option>-->
<!--														<option value="test3">test3</option>-->
<!--														<option value="test4">test4</option>-->
<!--														<option value="test5">test5</option>-->
<!--													</select>-->
<!--												</div>-->
<!--											</div>-->
<!---->
<!--										</div>-->
<!---->
<!--										<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">-->
<!--											<div class="form-group form-group-contact">-->
<!--												<label class="contact-label" for="Contact">Contact</label>-->
<!--												<!--<textarea class="form-control" rows="3" id="Contact"></textarea>-->
<!--												<div class="row row-margin-first">-->
<!---->
<!--													<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">-->
<!--														<div class="form-group">-->
<!--															<label for="optional.person">Person</label>-->
<!--															<input type="text" class="form-control" id="optional.person">-->
<!--														</div>-->
<!--													</div>-->
<!---->
<!--													<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">-->
<!--														<div class="form-group">-->
<!--															<label for="optional.address">Address</label>-->
<!--															<input type="text" class="form-control" id="optional.address">-->
<!--														</div>-->
<!--													</div>-->
<!---->
<!--													<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">-->
<!--														<div class="form-group">-->
<!--															<label for="optional.email">Email</label>-->
<!--															<input type="text" class="form-control" id="optional.email">-->
<!--														</div>-->
<!--													</div>-->
<!---->
<!--												</div>-->
<!--												<div class="row row-margin-last">-->
<!---->
<!--													<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">-->
<!--														<div class="form-group">-->
<!--															<label for="optional.organisation">Organisation</label>-->
<!--															<input type="text" class="form-control" id="optional.organisation">-->
<!--														</div>-->
<!--													</div>-->
<!---->
<!--													<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">-->
<!--														<div class="form-group">-->
<!--															<label for="optional.telephone">Telephone</label>-->
<!--															<input type="text" class="form-control" id="optional.telephone">-->
<!--														</div>-->
<!--													</div>-->
<!---->
<!--													<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">-->
<!--														<div class="form-group">-->
<!--															<label for="optional.website">Website</label>-->
<!--															<input type="text" class="form-control" id="optional.website">-->
<!--														</div>-->
<!--													</div>-->
<!---->
<!--												</div>-->
<!---->
<!--											</div>-->
<!--										</div>-->
<!---->
<!--									</div> <!-- End of row -->
<!---->
<!--								</div>-->
<!--							</div>-->

						</div>	<!-- End of form-body -->

					</div> <!-- End of resource-basic-information -->

					<div id="creation-circumstances" class="block">
						<div class="form-header">
							<h3></h3>
						</div>
						<div class="form-body">
							<div class="row">
<!--									<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">-->
<!--										<div class="form-group required">-->
<!--											<label for="projectName">Project Name</label>-->
<!--											<input type="text" class="form-control" id="projectName">-->
<!--										</div>-->
<!--									</div>-->

									<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
										<div class="form-group required">
											<label for="organization">Organization</label>
											<input type="text" class="form-control" id="organization" value="WroclawKoukaDaigaku">
										</div>
									</div>

								<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
									<div class="form-group form-first required">
										<label for="availability">Availability</label>
										<input type="text" class="form-control" id="availability" value="public">
									</div>
								</div>

								<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
									<div class="form-group required">
										<label for="iprHolder">Rights Holder</label>
										<input type="text" class="form-control" id="iprHolder" value="PWR">
									</div>
								</div>

								<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
									<div class="form-group form-last required">
										<label for="licenseName">License Name</label>
										<input type="text" class="form-control" id="licenseName" value="test">
									</div>
								</div>
<!--								<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">-->
<!--										<div class="form-group form-group-select">-->
<!--											<label for="Country">Country</label>-->
<!--											<input type="text" id="Country" list="countries-datalist">-->
<!--											<datalist id="countries-datalist"></datalist>-->
<!--										</div>-->
<!--									</div>-->
<!---->
<!--									<div class="col-lg-3 col-md-6 col-sm-12 col-xs-12">-->
<!--										<div class="form-group">-->
<!--											<label for="creator">Creator</label>-->
<!--											<input type="text" class="form-control" id="creator">-->
<!--										</div>-->
<!--									</div>-->

								</div>

						</div>
					</div>



					<div id="resource-content" class="block">
						<div class="form-header">
							<h3></h3>
						</div>
						<div class="form-body">
								<div class="row row-margin-first">
<!---->
<!--									<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">-->
<!--										<div class="form-group required">-->
<!--											<label for="genre">genre</label>-->
<!--											<input type="text" class="form-control" id="genre">-->
<!--										</div>-->
<!--									</div>-->
<!---->
<!--									<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">-->
<!--										<div class="form-group required">-->
<!--											<label for="temporalCoverage">temporalCoverage</label>-->
<!--											<input type="text" class="form-control" id="temporalCoverage">-->
<!--										</div>-->
<!--									</div>-->
<!---->
<!--									<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">-->
<!--										<div class="form-group required">-->
<!--											<label for="subject">subject</label>-->
<!--											<input type="text" class="form-control" id="subject">-->
<!--										</div>-->
<!--									</div>-->

									<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
										<div class="form-group required">
											<label for="modalityInfo">modalityInfo</label>
											<input type="text" id="modalityInfo" list="modalityInfo-datalist" placeholder="e.g. written" value="written">
											<datalist id="modalityInfo-datalist"></datalist>
										</div>
									</div>



									<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
										<div class="form-group required">
											<label for="SubjectLanguage">SubjectLanguage</label>
											<input type="text" class="form-control" id="SubjectLanguage" value="pol">
										</div>

									<!-- Empty column? Check it! -->
									<!--<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12"></div>-->
								</div>
						</div>
					</div>
					</div>

						<div class="form-buttons">
							<div class="form-group form-group-last">
								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
									<button type="submit" class="btn btn-default button-submit">
										<span>Submit</span>
									</button>
								</div>

<!--								<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">-->
<!--									<button type="submit" class="btn btn-default button-cancel">-->
<!--										<span>Cancel</span>-->
<!--									</button>-->
<!--								</div>-->
							</div>
						</div>
					</div>
						<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">

						<div id="selected-files" class="right-container">
						<div class="form-header">
							<h3 style="color:#fff">Selected files</h3>
						</div>
						<div class="form-body">
							<table class="table table-responsive table-hover mytable" id="filesTable">
								<thead>
									<tr>
										<th style="width: 10%"></th>
										<th style="width: 25%">Filename</th>
										<th style="width: 25%">Path</th>
										<th style="width: 40%">URL</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>
					</div>
						</div>



					</div>
				</div>

			</form>
		</div>
	</div>
</div>

<script nonce="<?php p(\OC::$server->getContentSecurityPolicyNonceManager()->getNonce())?>" type="text/javascript">
	console.log('Script is working');
//
	$(function() {
//		$('.form-group input').focus(function() {
//			$(this).css('border-bottom', '2px solid black');
//		});
//		$('.form-group input').blur(function() {
//			$(this).css('border-bottom', '2px solid #C4C0B4');
//		});

		$('#resourceClass').change(function() {
			/* Odczytywanie wartości opcji z selecta */
			console.log($('#resourceClass').val());
			// alert($('#resourceClass').val());
		});

		document.getElementById("export-form").addEventListener("submit", myFunction);

		function myFunction(event) {
			event.preventDefault();
			console.log($('#export-form').serialize());
		}
	});

	var files=<?php echo(json_encode($_['files'])); ?>;


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
