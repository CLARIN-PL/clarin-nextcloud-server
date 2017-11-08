$(document).ready(function() {
	function DSpaceConnector(){
		// this.submitBtn = $('#submit-dspace-form-btn');
		this.form = $('#export-form');
		// this.submitBtn.on('click', this.submit.bind(this));
		this.dSpacePossibleFiles = dSpacePossibleFiles;
		this.init();
	}
	DSpaceConnector.prototype.init = function(){
		this.initForm();
		this.initPossibleFieldValues();
	};

	DSpaceConnector.prototype.initForm = function () {
		var self = this;
		var validator = $(self.form).validate({
			submitHandler: self.submit.bind(self)
		});
	};

	DSpaceConnector.prototype.initPossibleFieldValues = function(){
		this.fields = {};
		this.fields.resourceclass = {"resourceClass": [["Grammar"], ["ExperimentalData"], ["SurveyData"], ["TestData"], ["Toolchain"], ["ResourceBundle"], ["other"], ["unknown"], ["TeachingMaterial"], ["Thesaurus"], ["LemmaList"], ["WordList"], ["NamedEntitiesList"], ["FrequencyList"], ["MultilingualDictionary"], ["MonolinugalDictionary"], ["BilingualDictionary"], ["UnannotatedTextCorpus"], ["AnnotatedTextCorpus"], ["Treebank"], ["LanguageDocumentationCorpus"], ["MultimodalCorpus"], ["SpeechCorpus"], ["StandaloneTool"], ["MobileApplication"], ["WebService"], ["WebApplication"], ["WordNet"]]};
		this.fields.mimetype = {"MimeType": ["text/plain", "text/xml", "text/csv", "text/html", "text/doc", "text/pdf", "image/gif", "image/jpeg", "image/png", "image/svg+xml", "image/tiff", "audio/vnd.wave", "audio/mpeg", "audio/mp4", "audio/ogg", "audio/vorbis", "audio/webm", "video/mpeg", "video/mp4", "video/x-ms-wmv", "video/ogg", "video/quicktime", "video/webm", "application/pdf", "application/xhtml+xml", "application/json", "application/zip", "application/vnd.oasis.opendocument.text", "application/vnd.oasis.opendocument.spreadsheet", "application/vnd.oasis.opendocument.presentation", "application/vnd.oasis.opendocument.graphics", "application/vnd.ms-excel", "application/vnd.ms-powerpoint", "application/msword", "application/xml"]};
		this.fields.modalities = {"Modalities": ["spoken", "written", "signed", "multimodal", "musical notation", "gestures", "pointing gestures", "eye gaze", "facial expressions", "emotional state", "haptic", "song", "instrumental music", "transcribed", "other", "unknown"]};
		this.fields.countries = {"Countries": ["Andorra", "United Arab Emirates", "Afghanistan", "Antigua and Barbuda", "Anguilla", "Albania", "Armenia", "Netherlands Antilles", "Angola", "Antarctica", "Argentina", "American Samoa", "Austria", "Australia", "Aruba", "Aland Islands \ufeff\u00c5land Islands", "Azerbaijan", "Bosnia and Herzegovina", "Barbados", "Bangladesh", "Belgium", "Burkina Faso", "Bulgaria", "Bahrain", "Burundi", "Benin", "Saint Barth\u00e9lemy", "Bermuda", "Brunei Darussalam", "Bolivia", "Brazil", "Bahamas", "Bhutan", "Bouvet Island", "Botswana", "Belarus", "Belize", "Canada", "Cocos (Keeling) Islands", "Congo", "Central African Republic", "Congo", "Switzerland", "Cote d'Ivoire \ufeffC\u00f4te d'Ivoire", "Cook Islands", "Chile", "Cameroon", "China", "Colombia", "Costa Rica", "Cuba", "Cape Verde", "Christmas Island", "Cyprus", "Czech Republic", "Germany", "Djibouti", "Denmark", "Dominica", "Dominican Republic", "Algeria", "Ecuador", "Estonia", "Egypt", "Western Sahara", "Eritrea", "Spain", "Ethiopia", "Finland", "Fiji", "Falkland Islands (Malvinas)", "Micronesia", "Faroe Islands", "France", "Gabon", "United Kingdom", "Grenada", "Georgia", "French Guiana", "Guernsey", "Ghana", "Gibraltar", "Greenland", "Gambia", "Guinea", "Guadeloupe", "Equatorial Guinea", "Greece", "South Georgia and the South Sandwich Islands", "Guatemala", "Guam", "Guinea-Bissau", "Guyana", "Hong Kong", "Heard Island and McDonald Islands", "Honduras", "Croatia", "Haiti", "Hungary", "Indonesia", "Ireland", "Israel", "Isle of Man", "India", "British Indian Ocean Territory", "Iraq", "Iran", "Iceland", "Italy", "Jersey", "Jamaica", "Jordan", "Japan", "Kenya", "Kyrgyzstan", "Cambodia", "Kiribati", "Comoros", "Saint Kitts and Nevis", "Korea", "Korea", "Kuwait", "Cayman Islands", "Kazakhstan", "Lao People's Democratic Republic", "Lebanon", "Saint Lucia", "Liechtenstein", "Sri Lanka", "Liberia", "Lesotho", "Lithuania", "Luxembourg", "Latvia", "Libyan Arab Jamahiriya", "Morocco", "Monaco", "Moldova", "Montenegro", "Saint Martin (French part)", "Madagascar", "Marshall Islands", "Macedonia", "Mali", "Myanmar", "Mongolia", "Macao", "Northern Mariana Islands", "Martinique", "Mauritania", "Montserrat", "Malta", "Mauritius", "Maldives", "Malawi", "Mexico", "Malaysia", "Mozambique", "Namibia", "New Caledonia", "Niger", "Norfolk Island", "Nigeria", "Nicaragua", "Netherlands", "Norway", "Nepal", "Nauru", "Niue", "New Zealand", "Oman", "Panama", "Peru", "French Polynesia", "Papua New Guinea", "Philippines", "Pakistan", "Poland", "Saint Pierre and Miquelon", "Pitcairn", "Puerto Rico", "Palestinian Territory", "Portugal", "Palau", "Paraguay", "Qatar", "Reunion \ufeffR\u00e9union", "Romania", "Serbia", "Russian Federation", "Rwanda", "Saudi Arabia", "Solomon Islands", "Seychelles", "Sudan", "Sweden", "Singapore", "Saint Helena", "Slovenia", "Svalbard and Jan Mayen", "Slovakia", "Sierra Leone", "San Marino", "Senegal", "Somalia", "Suriname", "Sao Tome and Principe", "El Salvador", "Syrian Arab Republic", "Swaziland", "Turks and Caicos Islands", "Chad", "French Southern Territories", "Togo", "Thailand", "Tajikistan", "Tokelau", "Timor-Leste", "Turkmenistan", "Tunisia", "Tonga", "Turkey", "Trinidad and Tobago", "Tuvalu", "Taiwan", "Tanzania", "Ukraine", "Uganda", "United States Minor Outlying Islands", "United States", "Uruguay", "Uzbekistan", "Holy See (Vatican City State)", "Saint Vincent and the Grenadines", "Venezuela", "Virgin Islands", "Virgin Islands", "Viet Nam", "Vanuatu", "Wallis and Futuna", "Samoa", "Yemen", "Mayotte", "South Africa", "Zambia", "Zimbabwe"]};
	};

	DSpaceConnector.prototype.submit = function(){
		var self = this;
		var formData = self.form.serializeArray();
		console.log(formData);

		var selectedFiles = [];
		$('#filesTable tbody tr td input').map(function(idx, el){
			if($(el).is(":checked")){
				selectedFiles.push(self.dSpacePossibleFiles[idx]);
			}
		});
		if(selectedFiles.length === 0){
			// todo - no files selected
		} else{
			var zipSuccess = function(response){
				console.log('success');
				console.log(response);
			};
			var zipFail = function(error){
				console.log('error');
				console.log(response);
			};
			self.zipFiles(selectedFiles, zipSuccess, zipFail)
		}

	};

	DSpaceConnector.prototype.zipFiles = function(files, callbackSuccess, callbackFail){
		$.ajax({
			type: 'POST',
			url:  OC.generateUrl('/apps/clarin/zip'),
			data: jQuery.param({data: {files:JSON.stringify(files), name: 'testName-changethis!'}}),
			dataType: 'json',
			success: function(res) {
				callbackSuccess(res);
			},
			error: function(res){
				callbackFail(res);
			}
		});
	};

	var dSpaceConnector = new DSpaceConnector();
}, this);