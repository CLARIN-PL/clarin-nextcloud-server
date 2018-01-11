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
		this.fields['dc.language.iso'] = [{"label":"Afar","val":"aar"},{"label":"Abkhazian","val":"abk"},{"label":"Achinese","val":"ace"},{"label":"Acoli","val":"ach"},{"label":"Adangme","val":"ada"},{"label":"Adyghe; Adygei","val":"ady"},{"label":"Afro-Asiatic languages","val":"afa"},{"label":"Afrihili","val":"afh"},{"label":"Afrikaans","val":"afr"},{"label":"Ainu","val":"ain"},{"label":"Akan","val":"aka"},{"label":"Akkadian","val":"akk"},{"label":"Albanian","val":"alb"},{"label":"Aleut","val":"ale"},{"label":"Algonquian languages","val":"alg"},{"label":"Southern Altai","val":"alt"},{"label":"Amharic","val":"amh"},{"label":"English, Old (ca.450-1100)","val":"ang"},{"label":"Angika","val":"anp"},{"label":"Apache languages","val":"apa"},{"label":"Arabic","val":"ara"},{"label":"Official Aramaic (700-300 BCE); Imperial Aramaic (700-300 BCE)","val":"arc"},{"label":"Aragonese","val":"arg"},{"label":"Armenian","val":"arm"},{"label":"Mapudungun; Mapuche","val":"arn"},{"label":"Arapaho","val":"arp"},{"label":"Artificial languages","val":"art"},{"label":"Arawak","val":"arw"},{"label":"Assamese","val":"asm"},{"label":"Asturian; Bable; Leonese; Asturleonese","val":"ast"},{"label":"Athapascan languages","val":"ath"},{"label":"Australian languages","val":"aus"},{"label":"Avaric","val":"ava"},{"label":"Avestan","val":"ave"},{"label":"Awadhi","val":"awa"},{"label":"Aymara","val":"aym"},{"label":"Azerbaijani","val":"aze"},{"label":"Banda languages","val":"bad"},{"label":"Bamileke languages","val":"bai"},{"label":"Bashkir","val":"bak"},{"label":"Baluchi","val":"bal"},{"label":"Bambara","val":"bam"},{"label":"Balinese","val":"ban"},{"label":"Basque","val":"baq"},{"label":"Basa","val":"bas"},{"label":"Baltic languages","val":"bat"},{"label":"Beja; Bedawiyet","val":"bej"},{"label":"Belarusian","val":"bel"},{"label":"Bemba","val":"bem"},{"label":"Bengali","val":"ben"},{"label":"Berber languages","val":"ber"},{"label":"Bhojpuri","val":"bho"},{"label":"Bihari languages","val":"bih"},{"label":"Bikol","val":"bik"},{"label":"Bini; Edo","val":"bin"},{"label":"Bislama","val":"bis"},{"label":"Siksika","val":"bla"},{"label":"Bantu (Other)","val":"bnt"},{"label":"Bosnian","val":"bos"},{"label":"Braj","val":"bra"},{"label":"Breton","val":"bre"},{"label":"Batak languages","val":"btk"},{"label":"Buriat","val":"bua"},{"label":"Buginese","val":"bug"},{"label":"Bulgarian","val":"bul"},{"label":"Burmese","val":"bur"},{"label":"Blin; Bilin","val":"byn"},{"label":"Caddo","val":"cad"},{"label":"Central American Indian languages","val":"cai"},{"label":"Galibi Carib","val":"car"},{"label":"Catalan; Valencian","val":"cat"},{"label":"Caucasian languages","val":"cau"},{"label":"Cebuano","val":"ceb"},{"label":"Celtic languages","val":"cel"},{"label":"Chamorro","val":"cha"},{"label":"Chibcha","val":"chb"},{"label":"Chechen","val":"che"},{"label":"Chagatai","val":"chg"},{"label":"Chinese","val":"chi"},{"label":"Chuukese","val":"chk"},{"label":"Mari","val":"chm"},{"label":"Chinook jargon","val":"chn"},{"label":"Choctaw","val":"cho"},{"label":"Chipewyan; Dene Suline","val":"chp"},{"label":"Cherokee","val":"chr"},{"label":"Church Slavic; Old Slavonic; Church Slavonic; Old Bulgarian; Old Church Slavonic","val":"chu"},{"label":"Chuvash","val":"chv"},{"label":"Cheyenne","val":"chy"},{"label":"Chamic languages","val":"cmc"},{"label":"Coptic","val":"cop"},{"label":"Cornish","val":"cor"},{"label":"Corsican","val":"cos"},{"label":"Creoles and pidgins, English based","val":"cpe"},{"label":"Creoles and pidgins, French-based ","val":"cpf"},{"label":"Creoles and pidgins, Portuguese-based ","val":"cpp"},{"label":"Cree","val":"cre"},{"label":"Crimean Tatar; Crimean Turkish","val":"crh"},{"label":"Creoles and pidgins ","val":"crp"},{"label":"Kashubian","val":"csb"},{"label":"Cushitic languages","val":"cus"},{"label":"Czech","val":"cze"},{"label":"Dakota","val":"dak"},{"label":"Danish","val":"dan"},{"label":"Dargwa","val":"dar"},{"label":"Land Dayak languages","val":"day"},{"label":"Delaware","val":"del"},{"label":"Slave (Athapascan)","val":"den"},{"label":"Dogrib","val":"dgr"},{"label":"Dinka","val":"din"},{"label":"Divehi; Dhivehi; Maldivian","val":"div"},{"label":"Dogri","val":"doi"},{"label":"Dravidian languages","val":"dra"},{"label":"Lower Sorbian","val":"dsb"},{"label":"Duala","val":"dua"},{"label":"Dutch, Middle (ca.1050-1350)","val":"dum"},{"label":"Dutch; Flemish","val":"dut"},{"label":"Dyula","val":"dyu"},{"label":"Dzongkha","val":"dzo"},{"label":"Efik","val":"efi"},{"label":"Egyptian (Ancient)","val":"egy"},{"label":"Ekajuk","val":"eka"},{"label":"Elamite","val":"elx"},{"label":"English","val":"eng"},{"label":"English, Middle (1100-1500)","val":"enm"},{"label":"Esperanto","val":"epo"},{"label":"Estonian","val":"est"},{"label":"Ewe","val":"ewe"},{"label":"Ewondo","val":"ewo"},{"label":"Fang","val":"fan"},{"label":"Faroese","val":"fao"},{"label":"Fanti","val":"fat"},{"label":"Fijian","val":"fij"},{"label":"Filipino; Pilipino","val":"fil"},{"label":"Finnish","val":"fin"},{"label":"Finno-Ugrian languages","val":"fiu"},{"label":"Fon","val":"fon"},{"label":"French","val":"fre"},{"label":"French, Middle (ca.1400-1600)","val":"frm"},{"label":"French, Old (842-ca.1400)","val":"fro"},{"label":"Northern Frisian","val":"frr"},{"label":"Eastern Frisian","val":"frs"},{"label":"Western Frisian","val":"fry"},{"label":"Fulah","val":"ful"},{"label":"Friulian","val":"fur"},{"label":"Ga","val":"gaa"},{"label":"Gayo","val":"gay"},{"label":"Gbaya","val":"gba"},{"label":"Germanic languages","val":"gem"},{"label":"Georgian","val":"geo"},{"label":"German","val":"ger"},{"label":"Geez","val":"gez"},{"label":"Gilbertese","val":"gil"},{"label":"Gaelic; Scottish Gaelic","val":"gla"},{"label":"Irish","val":"gle"},{"label":"Galician","val":"glg"},{"label":"Manx","val":"glv"},{"label":"German, Middle High (ca.1050-1500)","val":"gmh"},{"label":"German, Old High (ca.750-1050)","val":"goh"},{"label":"Gondi","val":"gon"},{"label":"Gorontalo","val":"gor"},{"label":"Gothic","val":"got"},{"label":"Grebo","val":"grb"},{"label":"Greek, Ancient (to 1453)","val":"grc"},{"label":"Greek, Modern (1453-)","val":"gre"},{"label":"Guarani","val":"grn"},{"label":"Swiss German; Alemannic; Alsatian","val":"gsw"},{"label":"Gujarati","val":"guj"},{"label":"Gwich'in","val":"gwi"},{"label":"Haida","val":"hai"},{"label":"Haitian; Haitian Creole","val":"hat"},{"label":"Hausa","val":"hau"},{"label":"Hawaiian","val":"haw"},{"label":"Hebrew","val":"heb"},{"label":"Herero","val":"her"},{"label":"Hiligaynon","val":"hil"},{"label":"Himachali languages; Western Pahari languages","val":"him"},{"label":"Hindi","val":"hin"},{"label":"Hittite","val":"hit"},{"label":"Hmong; Mong","val":"hmn"},{"label":"Hiri Motu","val":"hmo"},{"label":"Croatian","val":"hrv"},{"label":"Upper Sorbian","val":"hsb"},{"label":"Hungarian","val":"hun"},{"label":"Hupa","val":"hup"},{"label":"Iban","val":"iba"},{"label":"Igbo","val":"ibo"},{"label":"Icelandic","val":"ice"},{"label":"Ido","val":"ido"},{"label":"Sichuan Yi; Nuosu","val":"iii"},{"label":"Ijo languages","val":"ijo"},{"label":"Inuktitut","val":"iku"},{"label":"Interlingue; Occidental","val":"ile"},{"label":"Iloko","val":"ilo"},{"label":"Interlingua (International Auxiliary Language Association)","val":"ina"},{"label":"Indic languages","val":"inc"},{"label":"Indonesian","val":"ind"},{"label":"Indo-European languages","val":"ine"},{"label":"Ingush","val":"inh"},{"label":"Inupiaq","val":"ipk"},{"label":"Iranian languages","val":"ira"},{"label":"Iroquoian languages","val":"iro"},{"label":"Italian","val":"ita"},{"label":"Javanese","val":"jav"},{"label":"Lojban","val":"jbo"},{"label":"Japanese","val":"jpn"},{"label":"Judeo-Persian","val":"jpr"},{"label":"Judeo-Arabic","val":"jrb"},{"label":"Kara-Kalpak","val":"kaa"},{"label":"Kabyle","val":"kab"},{"label":"Kachin; Jingpho","val":"kac"},{"label":"Kalaallisut; Greenlandic","val":"kal"},{"label":"Kamba","val":"kam"},{"label":"Kannada","val":"kan"},{"label":"Karen languages","val":"kar"},{"label":"Kashmiri","val":"kas"},{"label":"Kanuri","val":"kau"},{"label":"Kawi","val":"kaw"},{"label":"Kazakh","val":"kaz"},{"label":"Kabardian","val":"kbd"},{"label":"Khasi","val":"kha"},{"label":"Khoisan languages","val":"khi"},{"label":"Central Khmer","val":"khm"},{"label":"Khotanese; Sakan","val":"kho"},{"label":"Kikuyu; Gikuyu","val":"kik"},{"label":"Kinyarwanda","val":"kin"},{"label":"Kirghiz; Kyrgyz","val":"kir"},{"label":"Kimbundu","val":"kmb"},{"label":"Konkani","val":"kok"},{"label":"Komi","val":"kom"},{"label":"Kongo","val":"kon"},{"label":"Korean","val":"kor"},{"label":"Kosraean","val":"kos"},{"label":"Kpelle","val":"kpe"},{"label":"Karachay-Balkar","val":"krc"},{"label":"Karelian","val":"krl"},{"label":"Kru languages","val":"kro"},{"label":"Kurukh","val":"kru"},{"label":"Kuanyama; Kwanyama","val":"kua"},{"label":"Kumyk","val":"kum"},{"label":"Kurdish","val":"kur"},{"label":"Kutenai","val":"kut"},{"label":"Ladino","val":"lad"},{"label":"Lahnda","val":"lah"},{"label":"Lamba","val":"lam"},{"label":"Lao","val":"lao"},{"label":"Latin","val":"lat"},{"label":"Latvian","val":"lav"},{"label":"Lezghian","val":"lez"},{"label":"Limburgan; Limburger; Limburgish","val":"lim"},{"label":"Lingala","val":"lin"},{"label":"Lithuanian","val":"lit"},{"label":"Mongo","val":"lol"},{"label":"Lozi","val":"loz"},{"label":"Luxembourgish; Letzeburgesch","val":"ltz"},{"label":"Luba-Lulua","val":"lua"},{"label":"Luba-Katanga","val":"lub"},{"label":"Ganda","val":"lug"},{"label":"Luiseno","val":"lui"},{"label":"Lunda","val":"lun"},{"label":"Luo (Kenya and Tanzania)","val":"luo"},{"label":"Lushai","val":"lus"},{"label":"Macedonian","val":"mac"},{"label":"Madurese","val":"mad"},{"label":"Magahi","val":"mag"},{"label":"Marshallese","val":"mah"},{"label":"Maithili","val":"mai"},{"label":"Makasar","val":"mak"},{"label":"Malayalam","val":"mal"},{"label":"Mandingo","val":"man"},{"label":"Maori","val":"mao"},{"label":"Austronesian languages","val":"map"},{"label":"Marathi","val":"mar"},{"label":"Masai","val":"mas"},{"label":"Malay","val":"may"},{"label":"Moksha","val":"mdf"},{"label":"Mandar","val":"mdr"},{"label":"Mende","val":"men"},{"label":"Irish, Middle (900-1200)","val":"mga"},{"label":"Mi'kmaq; Micmac","val":"mic"},{"label":"Minangkabau","val":"min"},{"label":"Uncoded languages","val":"mis"},{"label":"Mon-Khmer languages","val":"mkh"},{"label":"Malagasy","val":"mlg"},{"label":"Maltese","val":"mlt"},{"label":"Manchu","val":"mnc"},{"label":"Manipuri","val":"mni"},{"label":"Manobo languages","val":"mno"},{"label":"Mohawk","val":"moh"},{"label":"Mongolian","val":"mon"},{"label":"Mossi","val":"mos"},{"label":"Multiple languages","val":"mul"},{"label":"Munda languages","val":"mun"},{"label":"Creek","val":"mus"},{"label":"Mirandese","val":"mwl"},{"label":"Marwari","val":"mwr"},{"label":"Mayan languages","val":"myn"},{"label":"Erzya","val":"myv"},{"label":"Nahuatl languages","val":"nah"},{"label":"North American Indian languages","val":"nai"},{"label":"Neapolitan","val":"nap"},{"label":"Nauru","val":"nau"},{"label":"Navajo; Navaho","val":"nav"},{"label":"Ndebele, South; South Ndebele","val":"nbl"},{"label":"Ndebele, North; North Ndebele","val":"nde"},{"label":"Ndonga","val":"ndo"},{"label":"Low German; Low Saxon; German, Low; Saxon, Low","val":"nds"},{"label":"Nepali","val":"nep"},{"label":"Nepal Bhasa; Newari","val":"new"},{"label":"Nias","val":"nia"},{"label":"Niger-Kordofanian languages","val":"nic"},{"label":"Niuean","val":"niu"},{"label":"Norwegian Nynorsk; Nynorsk, Norwegian","val":"nno"},{"label":"Bokmål, Norwegian; Norwegian Bokmål","val":"nob"},{"label":"Nogai","val":"nog"},{"label":"Norse, Old","val":"non"},{"label":"Norwegian","val":"nor"},{"label":"N'Ko","val":"nqo"},{"label":"Pedi; Sepedi; Northern Sotho","val":"nso"},{"label":"Nubian languages","val":"nub"},{"label":"Classical Newari; Old Newari; Classical Nepal Bhasa","val":"nwc"},{"label":"Chichewa; Chewa; Nyanja","val":"nya"},{"label":"Nyamwezi","val":"nym"},{"label":"Nyankole","val":"nyn"},{"label":"Nyoro","val":"nyo"},{"label":"Nzima","val":"nzi"},{"label":"Occitan (post 1500); Provençal","val":"oci"},{"label":"Ojibwa","val":"oji"},{"label":"Oriya","val":"ori"},{"label":"Oromo","val":"orm"},{"label":"Osage","val":"osa"},{"label":"Ossetian; Ossetic","val":"oss"},{"label":"Turkish, Ottoman (1500-1928)","val":"ota"},{"label":"Otomian languages","val":"oto"},{"label":"Papuan languages","val":"paa"},{"label":"Pangasinan","val":"pag"},{"label":"Pahlavi","val":"pal"},{"label":"Pampanga; Kapampangan","val":"pam"},{"label":"Panjabi; Punjabi","val":"pan"},{"label":"Papiamento","val":"pap"},{"label":"Palauan","val":"pau"},{"label":"Persian, Old (ca.600-400 B.C.)","val":"peo"},{"label":"Persian","val":"per"},{"label":"Philippine languages","val":"phi"},{"label":"Phoenician","val":"phn"},{"label":"Pali","val":"pli"},{"label":"Polish","val":"pol"},{"label":"Pohnpeian","val":"pon"},{"label":"Portuguese","val":"por"},{"label":"Prakrit languages","val":"pra"},{"label":"Provençal, Old (to 1500)","val":"pro"},{"label":"Pushto; Pashto","val":"pus"},{"label":"Reserved for local use","val":"qaa-qtz"},{"label":"Quechua","val":"que"},{"label":"Rajasthani","val":"raj"},{"label":"Rapanui","val":"rap"},{"label":"Rarotongan; Cook Islands Maori","val":"rar"},{"label":"Romance languages","val":"roa"},{"label":"Romansh","val":"roh"},{"label":"Romany","val":"rom"},{"label":"Romanian; Moldavian; Moldovan","val":"rum"},{"label":"Rundi","val":"run"},{"label":"Aromanian; Arumanian; Macedo-Romanian","val":"rup"},{"label":"Russian","val":"rus"},{"label":"Sandawe","val":"sad"},{"label":"Sango","val":"sag"},{"label":"Yakut","val":"sah"},{"label":"South American Indian (Other)","val":"sai"},{"label":"Salishan languages","val":"sal"},{"label":"Samaritan Aramaic","val":"sam"},{"label":"Sanskrit","val":"san"},{"label":"Sasak","val":"sas"},{"label":"Santali","val":"sat"},{"label":"Sicilian","val":"scn"},{"label":"Scots","val":"sco"},{"label":"Selkup","val":"sel"},{"label":"Semitic languages","val":"sem"},{"label":"Irish, Old (to 900)","val":"sga"},{"label":"Sign Languages","val":"sgn"},{"label":"Shan","val":"shn"},{"label":"Sidamo","val":"sid"},{"label":"Sinhala; Sinhalese","val":"sin"},{"label":"Siouan languages","val":"sio"},{"label":"Sino-Tibetan languages","val":"sit"},{"label":"Slavic languages","val":"sla"},{"label":"Slovak","val":"slo"},{"label":"Slovenian","val":"slv"},{"label":"Southern Sami","val":"sma"},{"label":"Northern Sami","val":"sme"},{"label":"Sami languages","val":"smi"},{"label":"Lule Sami","val":"smj"},{"label":"Inari Sami","val":"smn"},{"label":"Samoan","val":"smo"},{"label":"Skolt Sami","val":"sms"},{"label":"Shona","val":"sna"},{"label":"Sindhi","val":"snd"},{"label":"Soninke","val":"snk"},{"label":"Sogdian","val":"sog"},{"label":"Somali","val":"som"},{"label":"Songhai languages","val":"son"},{"label":"Sotho, Southern","val":"sot"},{"label":"Spanish; Castilian","val":"spa"},{"label":"Sardinian","val":"srd"},{"label":"Sranan Tongo","val":"srn"},{"label":"Serbian","val":"srp"},{"label":"Serer","val":"srr"},{"label":"Nilo-Saharan languages","val":"ssa"},{"label":"Swati","val":"ssw"},{"label":"Sukuma","val":"suk"},{"label":"Sundanese","val":"sun"},{"label":"Susu","val":"sus"},{"label":"Sumerian","val":"sux"},{"label":"Swahili","val":"swa"},{"label":"Swedish","val":"swe"},{"label":"Classical Syriac","val":"syc"},{"label":"Syriac","val":"syr"},{"label":"Tahitian","val":"tah"},{"label":"Tai languages","val":"tai"},{"label":"Tamil","val":"tam"},{"label":"Tatar","val":"tat"},{"label":"Telugu","val":"tel"},{"label":"Timne","val":"tem"},{"label":"Tereno","val":"ter"},{"label":"Tetum","val":"tet"},{"label":"Tajik","val":"tgk"},{"label":"Tagalog","val":"tgl"},{"label":"Thai","val":"tha"},{"label":"Tibetan","val":"tib"},{"label":"Tigre","val":"tig"},{"label":"Tigrinya","val":"tir"},{"label":"Tiv","val":"tiv"},{"label":"Tokelau","val":"tkl"},{"label":"Klingon; tlhIngan-Hol","val":"tlh"},{"label":"Tlingit","val":"tli"},{"label":"Tamashek","val":"tmh"},{"label":"Tonga (Nyasa)","val":"tog"},{"label":"Tonga (Tonga Islands)","val":"ton"},{"label":"Tok Pisin","val":"tpi"},{"label":"Tsimshian","val":"tsi"},{"label":"Tswana","val":"tsn"},{"label":"Tsonga","val":"tso"},{"label":"Turkmen","val":"tuk"},{"label":"Tumbuka","val":"tum"},{"label":"Tupi languages","val":"tup"},{"label":"Turkish","val":"tur"},{"label":"Altaic languages","val":"tut"},{"label":"Tuvalu","val":"tvl"},{"label":"Twi","val":"twi"},{"label":"Tuvinian","val":"tyv"},{"label":"Udmurt","val":"udm"},{"label":"Ugaritic","val":"uga"},{"label":"Uighur; Uyghur","val":"uig"},{"label":"Ukrainian","val":"ukr"},{"label":"Umbundu","val":"umb"},{"label":"Undetermined","val":"und"},{"label":"Urdu","val":"urd"},{"label":"Uzbek","val":"uzb"},{"label":"Vai","val":"vai"},{"label":"Venda","val":"ven"},{"label":"Vietnamese","val":"vie"},{"label":"Volapük","val":"vol"},{"label":"Votic","val":"vot"},{"label":"Wakashan languages","val":"wak"},{"label":"Walamo","val":"wal"},{"label":"Waray","val":"war"},{"label":"Washo","val":"was"},{"label":"Welsh","val":"wel"},{"label":"Sorbian languages","val":"wen"},{"label":"Walloon","val":"wln"},{"label":"Wolof","val":"wol"},{"label":"Kalmyk; Oirat","val":"xal"},{"label":"Xhosa","val":"xho"},{"label":"Yao","val":"yao"},{"label":"Yapese","val":"yap"},{"label":"Yiddish","val":"yid"},{"label":"Yoruba","val":"yor"},{"label":"Yupik languages","val":"ypk"},{"label":"Zapotec","val":"zap"},{"label":"Blissymbols; Blissymbolics; Bliss","val":"zbl"},{"label":"Zenaga","val":"zen"},{"label":"Standard Moroccan Tamazight","val":"zgh"},{"label":"Zhuang; Chuang","val":"zha"},{"label":"Zande languages","val":"znd"},{"label":"Zulu","val":"zul"},{"label":"Zuni","val":"zun"},{"label":"No linguistic content; Not applicable","val":"zxx"},{"label":"Zaza; Dimili; Dimli; Kirdki; Kirmanjki; Zazaki","val":"zza"}];
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

		this.initPossibleLicenses();
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
			'contact-list': 'local.contact.person',
			'size-list': 'local.size.info',
			'creators-list': 'dc.contributor.author'
		};
		var returnData = [];
		for(var key in self.lists) {
			if(self.lists.hasOwnProperty(key)) {
				var data;
				if (key === 'creators-list')
					data = self.lists[key].get(', ');
				else
					data = self.lists[key].get('@@');

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

	DSpaceConnector.prototype.getAdditionalFormFields = function(choosenLic){
		var self = this;
		console.log(choosenLic);
		console.log(self.possibleLicenses);
		return [];
	};

	DSpaceConnector.prototype.getAllFormsData = function(){
		var self = this;

		var regularFormsData = self.getRegularFormsData();
		var multipleChoiceFormsData = self.multipleChoiceFormsData();

		if(regularFormsData === null || multipleChoiceFormsData === null)
			return null;


		var licElementIdx = regularFormsData.findIndex(function(it){ return it.name === 'dc.rights';});
		var licIdx = parseInt(regularFormsData[licElementIdx]['value']);
		regularFormsData.splice(licElementIdx, 1);


		var licensesFields = [
			{ name: 'dc.rights', value: self.possibleLicenses[licIdx]['rights']},
			{ name: 'dc.rights.uri', value: self.possibleLicenses[licIdx]['uri']},
			{ name: 'dc.rights.label', value: self.possibleLicenses[licIdx]['label']}
		];

		return regularFormsData
			.concat(multipleChoiceFormsData)
			.concat(licensesFields);

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
				// window.location.href = window.location.host;
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

	DSpaceConnector.prototype.initPossibleLicenses = function(){
		var self = this;
		var updateView = function(data){
			var selectName = 'dc.rights';
			self.possibleLicenses = data;
			var fields = {
				'dc.rights.label': data.map(function(obj){return obj.label}),
				'dc.rights.uri': data.map(function(obj){return obj.uri}),
				'dc.rights': data.map(function(obj){return obj.rights})
			};

			var i;
			var selectHandle = $('[name="'+ selectName +'"]');
			for(i=0; i < fields['dc.rights'].length; i++){
				selectHandle.append('<option ' +
					'data-content="'+fields['dc.rights'][i]
					+' <br>\'' + fields['dc.rights.label'][i] + '\' - '
					+ '<i>' + fields['dc.rights.uri'][i] + '</i>"'
					+ ' value= '+ i +'>'

					+ '</option>');
			}
			$('.selectpicker').selectpicker();
		};
		var dspaceUrlLic = 'https://clarin-pl.eu/rest/licenses';
		$.ajax({
			type: 'GET',
			url:  dspaceUrlLic,
			success: function(data, res) {
				updateView(data);
			},
			error: function(res){
				console.log(res);
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

	ExpandableList.prototype.get = function(separator) {
		var self = this;
		separator = separator || "@@";
		var data = self.userAdded.map(
			function(it){
				return it.arr.map(function(it){return it.value}).join(separator);
			});

		var id = self.list.attr('id');
		if(id === 'keywords-list'){
			if(data.length === 0) return null;
		}
		return data;
	};

	var dSpaceConnector = new DSpaceConnector();
}, this);