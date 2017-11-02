/**
 * Created by ktagowski on 24.08.17.
 */

$(document).ready(function() {
	addRows(files);
	JSONtoDataList('/dev/apps/clarin/json/resourceclass.json','resourceClass-datalist','resourceClass');
	JSONtoDataList('/dev/apps/clarin/json/mimetype.json','mimeType-DLU-datalist','MimeType');
	JSONtoDataList('/dev/apps/clarin/json/modalities.json','modalityInfo-datalist','Modalities');
	JSONtoDataList('/dev/apps/clarin/json/countries.json','countries-datalist','Countries');


}, this);

function addRow(data) {
	console.log('Adding row');
	var filename = data.path.split('/');
	console.log(data.filename);
	if(filename[-1]==="" && filename.length > 1){
		data.filename = filename[filename.length - 2];
	} else{
		data.filename = filename[filename.length - 1];
	}
	// data.icon = "/dev/index.php/apps/theming/img/core/filetypes/file.svg?v=0";
	// data.path = "/test/";
	// data.url = 'http://sharedUrl.test';
	console.log(data);
	$('#filesTable').find('tbody:last').append(
		'<tr>' +
			'<td><input id="select-1" type="checkbox" checked></td>' +
			'<td class="filename"><img src="'+ data.icon + '"class="icon">' + data.filename +'</td>' +
			'<td>'+ data.path +'</td>' +
			'<td><a>'+ data.url +'</a></td>' +
		'</tr>'
	);
}

function addRows(files){
	for(var i=0;i<files.length;++i){
		addRow(files[i]);
	}
}


function JSONtoDataList(file,id,arrayId) {
	var dataList = document.getElementById(id);
	var request = new XMLHttpRequest();
	request.onreadystatechange = function (response) {
		if (request.readyState === 4) {
			if (request.status === 200) {
				// Parse the JSON
				var jsonOptions = JSON.parse(request.responseText);
				// Loop over the JSON array.
				jsonOptions[arrayId].forEach(function (item) {
					// Create a new <option> element.
					var option = document.createElement('option');
					// Set the value using the item in the JSON array.
					option.value = item;
					// Add the <option> element to the <datalist>.
					dataList.appendChild(option);
				});
			}
		}
	};

	request.open('GET', file, true);
	request.send();

}

function handleExport(event){
	event.preventDefault();
	alert('handled');
	serial = $('#export-form').serialize();
	console.log(serial);
}