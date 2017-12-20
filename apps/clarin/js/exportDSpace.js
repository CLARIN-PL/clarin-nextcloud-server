$(document).ready(function() {
	function DSpaceConnector(){
		this.form = $('#export-form');
		this.noFilesSelectedError = $('#no-files-selected-msg');
		this.dSpacePossibleFiles = dSpacePossibleFiles;
		this.init();
	}
	DSpaceConnector.prototype.init = function(){
		this.initForm();
		this.initCheckboxBtns();
		this.initPossibleFieldValues();
		this.initExpandableLists();
	};
	DSpaceConnector.prototype.initCheckboxBtns = function(){
		var self = this;
		var masterBtn = $('#all-files-select-checkbox');
		var slaveBtns = $('.single-file-checkbox');

		masterBtn.change(function(){
			var isChecked = !!$(this).attr('checked');
			slaveBtns.prop('checked', isChecked);
			self.showNoFilesSelectedErrorMsg(!isChecked);
		});

		slaveBtns.change(function(){
			// get number of checked buttons
			var checked = 0;
			$.each(slaveBtns, function(i, it){
				if($(it).prop('checked'))
					checked++;
			});
			masterBtn.prop('checked', slaveBtns.length === checked);
			self.showNoFilesSelectedErrorMsg(checked === 0);
		});
	};

	DSpaceConnector.prototype.initForm = function () {
		var self = this;
		self.regularForms = $('#app-content-wrapper').find('form:not(.form-multiple-options)');
		self.regularForms.validate();

		self.submitButton = $('#submit-dspace-form-btn');
		self.submitButton.on('click', function(){
			self.submit();
		})
	};

	DSpaceConnector.prototype.initPossibleFieldValues = function(){
		this.fields = {};
		this.fields.resourceClass = [{"label":"Grammar","val":"Grammar"},{"label":"ExperimentalData","val":"ExperimentalData"},{"label":"SurveyData","val":"SurveyData"},{"label":"TestData","val":"TestData"},{"label":"Toolchain","val":"Toolchain"},{"label":"ResourceBundle","val":"ResourceBundle"},{"label":"other","val":"other"},{"label":"unknown","val":"unknown"},{"label":"TeachingMaterial","val":"TeachingMaterial"},{"label":"Thesaurus","val":"Thesaurus"},{"label":"LemmaList","val":"LemmaList"},{"label":"WordList","val":"WordList"},{"label":"NamedEntitiesList","val":"NamedEntitiesList"},{"label":"FrequencyList","val":"FrequencyList"},{"label":"MultilingualDictionary","val":"MultilingualDictionary"},{"label":"MonolinugalDictionary","val":"MonolinugalDictionary"},{"label":"BilingualDictionary","val":"BilingualDictionary"},{"label":"UnannotatedTextCorpus","val":"UnannotatedTextCorpus"},{"label":"AnnotatedTextCorpus","val":"AnnotatedTextCorpus"},{"label":"Treebank","val":"Treebank"},{"label":"LanguageDocumentationCorpus","val":"LanguageDocumentationCorpus"},{"label":"MultimodalCorpus","val":"MultimodalCorpus"},{"label":"SpeechCorpus","val":"SpeechCorpus"},{"label":"StandaloneTool","val":"StandaloneTool"},{"label":"MobileApplication","val":"MobileApplication"},{"label":"WebService","val":"WebService"},{"label":"WebApplication","val":"WebApplication"},{"label":"WordNet","val":"WordNet"}];
		// this.fields.mimetype = ["text/plain", "text/xml", "text/csv", "text/html", "text/doc", "text/pdf", "image/gif", "image/jpeg", "image/png", "image/svg+xml", "image/tiff", "audio/vnd.wave", "audio/mpeg", "audio/mp4", "audio/ogg", "audio/vorbis", "audio/webm", "video/mpeg", "video/mp4", "video/x-ms-wmv", "video/ogg", "video/quicktime", "video/webm", "application/pdf", "application/xhtml+xml", "application/json", "application/zip", "application/vnd.oasis.opendocument.text", "application/vnd.oasis.opendocument.spreadsheet", "application/vnd.oasis.opendocument.presentation", "application/vnd.oasis.opendocument.graphics", "application/vnd.ms-excel", "application/vnd.ms-powerpoint", "application/msword", "application/xml"];
		this.fields['local.modality.info'] = [{"label":"spoken","val":"spoken"},{"label":"written","val":"written"},{"label":"signed","val":"signed"},{"label":"multimodal","val":"multimodal"},{"label":"musical notation","val":"musical notation"},{"label":"gestures","val":"gestures"},{"label":"pointing gestures","val":"pointing gestures"},{"label":"eye gaze","val":"eye gaze"},{"label":"facial expressions","val":"facial expressions"},{"label":"emotional state","val":"emotional state"},{"label":"haptic","val":"haptic"},{"label":"song","val":"song"},{"label":"instrumental music","val":"instrumental music"},{"label":"transcribed","val":"transcribed"},{"label":"other","val":"other"},{"label":"unknown","val":"unknown"}]
		this.fields['local.country'] = [{"label":"Andorra","val":"AD"},{"label":"United Arab Emirates","val":"AE"},{"label":"Afghanistan","val":"AF"},{"label":"Antigua and Barbuda","val":"AG"},{"label":"Anguilla","val":"AI"},{"label":"Albania","val":"AL"},{"label":"Armenia","val":"AM"},{"label":"Netherlands Antilles","val":"AN"},{"label":"Angola","val":"AO"},{"label":"Antarctica","val":"AQ"},{"label":"Argentina","val":"AR"},{"label":"American Samoa","val":"AS"},{"label":"Austria","val":"AT"},{"label":"Australia","val":"AU"},{"label":"Aruba","val":"AW"},{"label":"Aland Islands ﻿Åland Islands","val":"AX"},{"label":"Azerbaijan","val":"AZ"},{"label":"Bosnia and Herzegovina","val":"BA"},{"label":"Barbados","val":"BB"},{"label":"Bangladesh","val":"BD"},{"label":"Belgium","val":"BE"},{"label":"Burkina Faso","val":"BF"},{"label":"Bulgaria","val":"BG"},{"label":"Bahrain","val":"BH"},{"label":"Burundi","val":"BI"},{"label":"Benin","val":"BJ"},{"label":"Saint Barthélemy","val":"BL"},{"label":"Bermuda","val":"BM"},{"label":"Brunei Darussalam","val":"BN"},{"label":"Bolivia","val":"BO"},{"label":"Brazil","val":"BR"},{"label":"Bahamas","val":"BS"},{"label":"Bhutan","val":"BT"},{"label":"Bouvet Island","val":"BV"},{"label":"Botswana","val":"BW"},{"label":"Belarus","val":"BY"},{"label":"Belize","val":"BZ"},{"label":"Canada","val":"CA"},{"label":"Cocos (Keeling) Islands","val":"CC"},{"label":"Congo","val":"CD"},{"label":"Central African Republic","val":"CF"},{"label":"Congo","val":"CG"},{"label":"Switzerland","val":"CH"},{"label":"Cote d'Ivoire ﻿Côte d'Ivoire","val":"CI"},{"label":"Cook Islands","val":"CK"},{"label":"Chile","val":"CL"},{"label":"Cameroon","val":"CM"},{"label":"China","val":"CN"},{"label":"Colombia","val":"CO"},{"label":"Costa Rica","val":"CR"},{"label":"Cuba","val":"CU"},{"label":"Cape Verde","val":"CV"},{"label":"Christmas Island","val":"CX"},{"label":"Cyprus","val":"CY"},{"label":"Czech Republic","val":"CZ"},{"label":"Germany","val":"DE"},{"label":"Djibouti","val":"DJ"},{"label":"Denmark","val":"DK"},{"label":"Dominica","val":"DM"},{"label":"Dominican Republic","val":"DO"},{"label":"Algeria","val":"DZ"},{"label":"Ecuador","val":"EC"},{"label":"Estonia","val":"EE"},{"label":"Egypt","val":"EG"},{"label":"Western Sahara","val":"EH"},{"label":"Eritrea","val":"ER"},{"label":"Spain","val":"ES"},{"label":"Ethiopia","val":"ET"},{"label":"Finland","val":"FI"},{"label":"Fiji","val":"FJ"},{"label":"Falkland Islands (Malvinas)","val":"FK"},{"label":"Micronesia","val":"FM"},{"label":"Faroe Islands","val":"FO"},{"label":"France","val":"FR"},{"label":"Gabon","val":"GA"},{"label":"United Kingdom","val":"GB"},{"label":"Grenada","val":"GD"},{"label":"Georgia","val":"GE"},{"label":"French Guiana","val":"GF"},{"label":"Guernsey","val":"GG"},{"label":"Ghana","val":"GH"},{"label":"Gibraltar","val":"GI"},{"label":"Greenland","val":"GL"},{"label":"Gambia","val":"GM"},{"label":"Guinea","val":"GN"},{"label":"Guadeloupe","val":"GP"},{"label":"Equatorial Guinea","val":"GQ"},{"label":"Greece","val":"GR"},{"label":"South Georgia and the South Sandwich Islands","val":"GS"},{"label":"Guatemala","val":"GT"},{"label":"Guam","val":"GU"},{"label":"Guinea-Bissau","val":"GW"},{"label":"Guyana","val":"GY"},{"label":"Hong Kong","val":"HK"},{"label":"Heard Island and McDonald Islands","val":"HM"},{"label":"Honduras","val":"HN"},{"label":"Croatia","val":"HR"},{"label":"Haiti","val":"HT"},{"label":"Hungary","val":"HU"},{"label":"Indonesia","val":"ID"},{"label":"Ireland","val":"IE"},{"label":"Israel","val":"IL"},{"label":"Isle of Man","val":"IM"},{"label":"India","val":"IN"},{"label":"British Indian Ocean Territory","val":"IO"},{"label":"Iraq","val":"IQ"},{"label":"Iran","val":"IR"},{"label":"Iceland","val":"IS"},{"label":"Italy","val":"IT"},{"label":"Jersey","val":"JE"},{"label":"Jamaica","val":"JM"},{"label":"Jordan","val":"JO"},{"label":"Japan","val":"JP"},{"label":"Kenya","val":"KE"},{"label":"Kyrgyzstan","val":"KG"},{"label":"Cambodia","val":"KH"},{"label":"Kiribati","val":"KI"},{"label":"Comoros","val":"KM"},{"label":"Saint Kitts and Nevis","val":"KN"},{"label":"Korea","val":"KP"},{"label":"Korea","val":"KR"},{"label":"Kuwait","val":"KW"},{"label":"Cayman Islands","val":"KY"},{"label":"Kazakhstan","val":"KZ"},{"label":"Lao People's Democratic Republic","val":"LA"},{"label":"Lebanon","val":"LB"},{"label":"Saint Lucia","val":"LC"},{"label":"Liechtenstein","val":"LI"},{"label":"Sri Lanka","val":"LK"},{"label":"Liberia","val":"LR"},{"label":"Lesotho","val":"LS"},{"label":"Lithuania","val":"LT"},{"label":"Luxembourg","val":"LU"},{"label":"Latvia","val":"LV"},{"label":"Libyan Arab Jamahiriya","val":"LY"},{"label":"Morocco","val":"MA"},{"label":"Monaco","val":"MC"},{"label":"Moldova","val":"MD"},{"label":"Montenegro","val":"ME"},{"label":"Saint Martin (French part)","val":"MF"},{"label":"Madagascar","val":"MG"},{"label":"Marshall Islands","val":"MH"},{"label":"Macedonia","val":"MK"},{"label":"Mali","val":"ML"},{"label":"Myanmar","val":"MM"},{"label":"Mongolia","val":"MN"},{"label":"Macao","val":"MO"},{"label":"Northern Mariana Islands","val":"MP"},{"label":"Martinique","val":"MQ"},{"label":"Mauritania","val":"MR"},{"label":"Montserrat","val":"MS"},{"label":"Malta","val":"MT"},{"label":"Mauritius","val":"MU"},{"label":"Maldives","val":"MV"},{"label":"Malawi","val":"MW"},{"label":"Mexico","val":"MX"},{"label":"Malaysia","val":"MY"},{"label":"Mozambique","val":"MZ"},{"label":"Namibia","val":"NA"},{"label":"New Caledonia","val":"NC"},{"label":"Niger","val":"NE"},{"label":"Norfolk Island","val":"NF"},{"label":"Nigeria","val":"NG"},{"label":"Nicaragua","val":"NI"},{"label":"Netherlands","val":"NL"},{"label":"Norway","val":"NO"},{"label":"Nepal","val":"NP"},{"label":"Nauru","val":"NR"},{"label":"Niue","val":"NU"},{"label":"New Zealand","val":"NZ"},{"label":"Oman","val":"OM"},{"label":"Panama","val":"PA"},{"label":"Peru","val":"PE"},{"label":"French Polynesia","val":"PF"},{"label":"Papua New Guinea","val":"PG"},{"label":"Philippines","val":"PH"},{"label":"Pakistan","val":"PK"},{"label":"Poland","val":"PL"},{"label":"Saint Pierre and Miquelon","val":"PM"},{"label":"Pitcairn","val":"PN"},{"label":"Puerto Rico","val":"PR"},{"label":"Palestinian Territory","val":"PS"},{"label":"Portugal","val":"PT"},{"label":"Palau","val":"PW"},{"label":"Paraguay","val":"PY"},{"label":"Qatar","val":"QA"},{"label":"Reunion ﻿Réunion","val":"RE"},{"label":"Romania","val":"RO"},{"label":"Serbia","val":"RS"},{"label":"Russian Federation","val":"RU"},{"label":"Rwanda","val":"RW"},{"label":"Saudi Arabia","val":"SA"},{"label":"Solomon Islands","val":"SB"},{"label":"Seychelles","val":"SC"},{"label":"Sudan","val":"SD"},{"label":"Sweden","val":"SE"},{"label":"Singapore","val":"SG"},{"label":"Saint Helena","val":"SH"},{"label":"Slovenia","val":"SI"},{"label":"Svalbard and Jan Mayen","val":"SJ"},{"label":"Slovakia","val":"SK"},{"label":"Sierra Leone","val":"SL"},{"label":"San Marino","val":"SM"},{"label":"Senegal","val":"SN"},{"label":"Somalia","val":"SO"},{"label":"Suriname","val":"SR"},{"label":"Sao Tome and Principe","val":"ST"},{"label":"El Salvador","val":"SV"},{"label":"Syrian Arab Republic","val":"SY"},{"label":"Swaziland","val":"SZ"},{"label":"Turks and Caicos Islands","val":"TC"},{"label":"Chad","val":"TD"},{"label":"French Southern Territories","val":"TF"},{"label":"Togo","val":"TG"},{"label":"Thailand","val":"TH"},{"label":"Tajikistan","val":"TJ"},{"label":"Tokelau","val":"TK"},{"label":"Timor-Leste","val":"TL"},{"label":"Turkmenistan","val":"TM"},{"label":"Tunisia","val":"TN"},{"label":"Tonga","val":"TO"},{"label":"Turkey","val":"TR"},{"label":"Trinidad and Tobago","val":"TT"},{"label":"Tuvalu","val":"TV"},{"label":"Taiwan","val":"TW"},{"label":"Tanzania","val":"TZ"},{"label":"Ukraine","val":"UA"},{"label":"Uganda","val":"UG"},{"label":"United States Minor Outlying Islands","val":"UM"},{"label":"United States","val":"US"},{"label":"Uruguay","val":"UY"},{"label":"Uzbekistan","val":"UZ"},{"label":"Holy See (Vatican City State)","val":"VA"},{"label":"Saint Vincent and the Grenadines","val":"VC"},{"label":"Venezuela","val":"VE"},{"label":"Virgin Islands","val":"VG"},{"label":"Virgin Islands","val":"VI"},{"label":"Viet Nam","val":"VN"},{"label":"Vanuatu","val":"VU"},{"label":"Wallis and Futuna","val":"WF"},{"label":"Samoa","val":"WS"},{"label":"Yemen","val":"YE"},{"label":"Mayotte","val":"YT"},{"label":"South Africa","val":"ZA"},{"label":"Zambia","val":"ZM"},{"label":"Zimbabwe","val":"ZW"}];
		this.fields['dc.language.iso'] = [{"label":"Abkhaz","val":"ab"},{"label":"Afar","val":"aa"},{"label":"Afrikaans","val":"af"},{"label":"Akan","val":"ak"},{"label":"Albanian","val":"sq"},{"label":"Amharic","val":"am"},{"label":"Arabic","val":"ar"},{"label":"Aragonese","val":"an"},{"label":"Armenian","val":"hy"},{"label":"Assamese","val":"as"},{"label":"Avaric","val":"av"},{"label":"Avestan","val":"ae"},{"label":"Aymara","val":"ay"},{"label":"Azerbaijani","val":"az"},{"label":"Bambara","val":"bm"},{"label":"Bashkir","val":"ba"},{"label":"Basque","val":"eu"},{"label":"Belarusian","val":"be"},{"label":"Bengali; Bangla","val":"bn"},{"label":"Bihari","val":"bh"},{"label":"Bislama","val":"bi"},{"label":"Bosnian","val":"bs"},{"label":"Breton","val":"br"},{"label":"Bulgarian","val":"bg"},{"label":"Burmese","val":"my"},{"label":"Catalan; Valencian","val":"ca"},{"label":"Chamorro","val":"ch"},{"label":"Chechen","val":"ce"},{"label":"Chichewa; Chewa; Nyanja","val":"ny"},{"label":"Chinese","val":"zh"},{"label":"Chuvash","val":"cv"},{"label":"Cornish","val":"kw"},{"label":"Corsican","val":"co"},{"label":"Cree","val":"cr"},{"label":"Croatian","val":"hr"},{"label":"Czech","val":"cs"},{"label":"Danish","val":"da"},{"label":"Divehi; Dhivehi; Maldivian;","val":"dv"},{"label":"Dutch","val":"nl"},{"label":"Dzongkha","val":"dz"},{"label":"English","val":"en"},{"label":"Esperanto","val":"eo"},{"label":"Estonian","val":"et"},{"label":"Ewe","val":"ee"},{"label":"Faroese","val":"fo"},{"label":"Fijian","val":"fj"},{"label":"Finnish","val":"fi"},{"label":"French","val":"fr"},{"label":"Fula; Fulah; Pulaar; Pular","val":"ff"},{"label":"Galician","val":"gl"},{"label":"Georgian","val":"ka"},{"label":"German","val":"de"},{"label":"Greek, Modern","val":"el"},{"label":"GuaranÃ­","val":"gn"},{"label":"Gujarati","val":"gu"},{"label":"Haitian; Haitian Creole","val":"ht"},{"label":"Hausa","val":"ha"},{"label":"Hebrew (modern)","val":"he"},{"label":"Herero","val":"hz"},{"label":"Hindi","val":"hi"},{"label":"Hiri Motu","val":"ho"},{"label":"Hungarian","val":"hu"},{"label":"Interlingua","val":"ia"},{"label":"Indonesian","val":"id"},{"label":"Interlingue","val":"ie"},{"label":"Irish","val":"ga"},{"label":"Igbo","val":"ig"},{"label":"Inupiaq","val":"ik"},{"label":"Ido","val":"io"},{"label":"Icelandic","val":"is"},{"label":"Italian","val":"it"},{"label":"Inuktitut","val":"iu"},{"label":"Japanese","val":"ja"},{"label":"Javanese","val":"jv"},{"label":"Kalaallisut, Greenlandic","val":"kl"},{"label":"Kannada","val":"kn"},{"label":"Kanuri","val":"kr"},{"label":"Kashmiri","val":"ks"},{"label":"Kazakh","val":"kk"},{"label":"Khmer","val":"km"},{"label":"Kikuyu, Gikuyu","val":"ki"},{"label":"Kinyarwanda","val":"rw"},{"label":"Kyrgyz","val":"ky"},{"label":"Komi","val":"kv"},{"label":"Kongo","val":"kg"},{"label":"Korean","val":"ko"},{"label":"Kurdish","val":"ku"},{"label":"Kwanyama, Kuanyama","val":"kj"},{"label":"Latin","val":"la"},{"label":"Luxembourgish, Letzeburgesch","val":"lb"},{"label":"Ganda","val":"lg"},{"label":"Limburgish, Limburgan, Limburger","val":"li"},{"label":"Lingala","val":"ln"},{"label":"Lao","val":"lo"},{"label":"Lithuanian","val":"lt"},{"label":"Luba-Katanga","val":"lu"},{"label":"Latvian","val":"lv"},{"label":"Manx","val":"gv"},{"label":"Macedonian","val":"mk"},{"label":"Malagasy","val":"mg"},{"label":"Malay","val":"ms"},{"label":"Malayalam","val":"ml"},{"label":"Maltese","val":"mt"},{"label":"MÄori","val":"mi"},{"label":"Marathi (MarÄá¹­hÄ«)","val":"mr"},{"label":"Marshallese","val":"mh"},{"label":"Mongolian","val":"mn"},{"label":"Nauru","val":"na"},{"label":"Navajo, Navaho","val":"nv"},{"label":"Norwegian BokmÃ¥l","val":"nb"},{"label":"North Ndebele","val":"nd"},{"label":"Nepali","val":"ne"},{"label":"Ndonga","val":"ng"},{"label":"Norwegian Nynorsk","val":"nn"},{"label":"Norwegian","val":"no"},{"label":"Nuosu","val":"ii"},{"label":"South Ndebele","val":"nr"},{"label":"Occitan","val":"oc"},{"label":"Ojibwe, Ojibwa","val":"oj"},{"label":"Old Church Slavonic, Church Slavic, Church Slavonic, Old Bulgarian, Old Slavonic","val":"cu"},{"label":"Oromo","val":"om"},{"label":"Oriya","val":"or"},{"label":"Ossetian, Ossetic","val":"os"},{"label":"Panjabi, Punjabi","val":"pa"},{"label":"PÄli","val":"pi"},{"label":"Persian (Farsi)","val":"fa"},{"label":"Polish","val":"pl"},{"label":"Pashto, Pushto","val":"ps"},{"label":"Portuguese","val":"pt"},{"label":"Quechua","val":"qu"},{"label":"Romansh","val":"rm"},{"label":"Kirundi","val":"rn"},{"label":"Romanian, [])","val":"ro"},{"label":"Russian","val":"ru"},{"label":"Sanskrit (Saá¹ská¹›ta)","val":"sa"},{"label":"Sardinian","val":"sc"},{"label":"Sindhi","val":"sd"},{"label":"Northern Sami","val":"se"},{"label":"Samoan","val":"sm"},{"label":"Sango","val":"sg"},{"label":"Serbian","val":"sr"},{"label":"Scottish Gaelic; Gaelic","val":"gd"},{"label":"Shona","val":"sn"},{"label":"Sinhala, Sinhalese","val":"si"},{"label":"Slovak","val":"sk"},{"label":"Slovene","val":"sl"},{"label":"Somali","val":"so"},{"label":"Southern Sotho","val":"st"},{"label":"South Azerbaijani","val":"az"},{"label":"Spanish; Castilian","val":"es"},{"label":"Sundanese","val":"su"},{"label":"Swahili","val":"sw"},{"label":"Swati","val":"ss"},{"label":"Swedish","val":"sv"},{"label":"Tamil","val":"ta"},{"label":"Telugu","val":"te"},{"label":"Tajik","val":"tg"},{"label":"Thai","val":"th"},{"label":"Tigrinya","val":"ti"},{"label":"Tibetan Standard, Tibetan, Central","val":"bo"},{"label":"Turkmen","val":"tk"},{"label":"Tagalog","val":"tl"},{"label":"Tswana","val":"tn"},{"label":"Tonga (Tonga Islands)","val":"to"},{"label":"Turkish","val":"tr"},{"label":"Tsonga","val":"ts"},{"label":"Tatar","val":"tt"},{"label":"Twi","val":"tw"},{"label":"Tahitian","val":"ty"},{"label":"Uyghur, Uighur","val":"ug"},{"label":"Ukrainian","val":"uk"},{"label":"Urdu","val":"ur"},{"label":"Uzbek","val":"uz"},{"label":"Venda","val":"ve"},{"label":"Vietnamese","val":"vi"},{"label":"VolapÃ¼k","val":"vo"},{"label":"Walloon","val":"wa"},{"label":"Welsh","val":"cy"},{"label":"Wolof","val":"wo"},{"label":"Western Frisian","val":"fy"},{"label":"Xhosa","val":"xh"},{"label":"Yiddish","val":"yi"},{"label":"Yoruba","val":"yo"},{"label":"Zhuang, Chuang","val":"za"},{"label":"Zulu","val":"zu"}];
		this.fields['dc.type'] = [{"label":"Corpus","val":"corpus"}, {"label":"Lexical conceptual","val":"lexicalConceptualResource"}, {"label":"Language description","val":"languageDescription"}, {"label":"Technology/ Tool/ Service","val":"toolService"}];


		var i, self = this;
		for(var key in self.fields ){
			if(self.fields.hasOwnProperty(key)){
				var selectHandle = $('[name="'+ key +'"]');
				for(i=0; i < self.fields[key].length; i++){
					selectHandle.append($('<option>', {
						text: self.fields[key][i]['label'],
						value: self.fields[key][i]['val']
					}));
				}
			}
		}
	};

	DSpaceConnector.prototype.showNoFilesSelectedErrorMsg = function(showOrHide){
		this.noFilesSelectedError.attr('hidden', !showOrHide);
	};
	DSpaceConnector.prototype.getRegularFormsData = function(){
		var self = this;
		var valid = true;

		var formData = [], form;
		self.regularForms.map(function(idx, it){
			form = $(it);
			formData = formData.concat(form.serializeArray());
			if (!form.valid()){
				valid = false;
			}
		});

		if(valid){
			return formData;
		}
		return null;
	};

	DSpaceConnector.prototype.multipleChoiceFormsData = function(){
		var self = this;
		var keyMapping = {
			'keywords-list': 'dc.subject',
			'contact-list': 'contact.person',
			'size-list': 'local.size.info',
			'creators-list': 'dc.contributor.author'
		};
		var returnData = [];
		for(var key in self.lists) {
			if(self.lists.hasOwnProperty(key)) {
				var data = self.lists[key].get();
				if(key === 'keywords-list' && data === null){
					if(data === null){
						$('#keywords-error-label')
							.css('display', 'block')
							.text('This field is required. Add at least one keyword using the button on the right.');
						return null;
					}
					for(var i = 0; i < data.length; i++){
						returnData.push({name: 'dc.subject', value: data[i]});
					}
				}
				else{
					for(var i = 0; i < data.length; i++){
						returnData.push({name: keyMapping[key], value: data[i]});
					}
				}
			}
		}
		return returnData;
	};

	DSpaceConnector.prototype.getAllFormsData = function(){
		var self = this;

		var regularFormsData = self.getRegularFormsData();
		var multipleChoiceFormsData = self.multipleChoiceFormsData();

		if(regularFormsData === null || multipleChoiceFormsData === null)
			return null;

		return regularFormsData.concat(multipleChoiceFormsData);
	};

	DSpaceConnector.prototype.submit = function(){
		var self = this;

		var formData = self.getAllFormsData();
		if(formData === null)
			return;

		formData = formData.filter(function(it){
			return it.value !== '';
		});

		var selectedFiles = [];
		$('#filesTable tbody tr td input').map(function(idx, el){
			if($(el).is(":checked")){
				selectedFiles.push(self.dSpacePossibleFiles[idx]);
			}
		});
		if(selectedFiles.length === 0){
			console.log('no files selected');
			this.showNoFilesSelectedErrorMsg(true);
		} else{
			var zipSuccess = function(response){
				console.log('success');
				console.log(response);
				alert('Export successful.\nYou will be now redirected to main site.');
				window.location.href = window.location.host;
			};
			var zipFail = function(error){
				console.log(error);
			};
			self.zipFiles(selectedFiles, formData,zipSuccess, zipFail)
		}
	};

	DSpaceConnector.prototype.zipFiles = function(files, formData,callbackSuccess, callbackFail){

		var zipFileName = formData.find(function(it){
			return it.name === "dc.title";
		})['value'];

		$.ajax({
			type: 'POST',
			url:  OC.generateUrl('/apps/clarin/zip-dspace'),
			data: jQuery.param({data: {files:JSON.stringify(files), name: zipFileName, formFields:formData}}),
			dataType: 'json',
			success: function(res) {
				callbackSuccess(res);
			},
			error: function(res){
				callbackFail(res);
			}
		});
	};

	DSpaceConnector.prototype.initExpandableLists = function(){
		var self = this;
		var lists = $('.expandable-list');
		self.lists = {};
		for(var i = 0; i < lists.length; i++){
			var closureFcn = function(){
				var list  = $(lists[i]);
				var form = list.closest('form');
				self.lists[list.attr('id')] =  new ExpandableList(list, form, self);
			}();
		}
	};

	function ExpandableList(listHandle, formHandle, parent){
		this.parent = parent;

		this.list = listHandle;
		this.form = formHandle;
		this.userAdded = [];
		this.init();
	}



	ExpandableList.prototype.init = function(){
		var self = this;
		this.validator = this.form.validate({
			submitHandler: self.addOption.bind(self)
		});


		self.list.on('click', '.close' ,function(){
			self.userAdded.splice($(this).parent().attr('data-idx'),1);
			self.updateUserAdded();
		});
	};

	ExpandableList.prototype.addOption = function(form){
		var self = this;
		event.preventDefault();
		if(self.form.valid()){
			var formValues = this.form.serializeArray();
			self.userAdded.push({
				str: formValues
					.map(function(it){ return it.value;	})
					.join(', '),
				arr: formValues
			});
			self.validator.resetForm();
			self.updateUserAdded();
		}
	};

	ExpandableList.prototype.updateUserAdded = function(){
		var self = this;
		self.list.html('');
		for(var i = 0; i < self.userAdded.length; i++) {
			self.list.append('<li data-idx="'+ i +'"><span>' + self.userAdded[i].str + '</span><span class="close">×</span></li>');
		}
		self.form.trigger('reset');
	};

	ExpandableList.prototype.get = function() {
		var self = this;

		var data = self.userAdded.map(
			function(it){
				return it.arr.map(function(it){return it.value}).join('@@');
			});

		var id = self.list.attr('id');
		if(id === 'keywords-list'){
			if(data.length === 0) return null;
		}
		return data;
	};

	var dSpaceConnector = new DSpaceConnector();
}, this);