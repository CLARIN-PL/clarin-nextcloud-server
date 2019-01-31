/**
 * Created by wrauk on 16.11.17.
 */

OCA.Clarin = {};
$(document).ready(function() {

	if(typeof(ClarinModule) === 'undefined')
		return;

	OCA.Clarin.bar = new ClarinModule({
		offset:{
			'top': 0,
			'right': null,
			'bottom': null,
			'left': 0
		},
		arrow:{
			'initial-orientation': "right",// 'up' || 'down' || 'right' || 'left'
			'rotation-hover': -180
		},
		themeColor: '#337ab7',
		horizontal: false // false || true
	});
	OCA.Clarin.bar.setFullHeightMode();

	$('#content-wrapper').css({'padding-left': '55px'});
	$('#header').css({'margin-left': '55px'});

	function WsTaskObserver(){
		this.localStorageName = 'Clarin-ws-active-tasks';
		this.clarinModule = OCA.Clarin.bar;
		this.minutesToShow = 60 * 48; // full 48h
		this.init();

	}
	WsTaskObserver.prototype.init = function(){
		var self = this;
		self.tasks = JSON.parse(localStorage.getItem(self.localStorageName));

		if(!self.tasks){
			self.tasks = [];
		}
		// starting to observe
		self.initClarinModuleList()
	};

	WsTaskObserver.prototype.initClarinModuleList = function(){
		var self = this;
		self.clarinModule.addMenu('active_tasks', "Twoje zadania", "Your tasks");

		// going through array backwards to delete old tasks
		for(var i = self.tasks.length-1; i >= 0 ; i--){
			(function(task){
				if(((new Date() - task.dateAdd) / 1000 / 60) > self.minutesToShow){
					self.tasks.splice(i,1);
				}
			})(self.tasks[i]);
		}

		// displaying tasks in separate loop to preserve order
		for (var i = 0; i < self.tasks.length; i++){
			(function(task){
				var callbackIsReady = null;
				if (task.status !== 'DONE')
					callbackIsReady = function(){
						return self.checkTaskStatus(task.id);
					};
				self.clarinModule.addMenuElement('active_tasks', 'check-square-o', task.name,
					task.name, self.getClickFunction(task), callbackIsReady);
			})(self.tasks[i]);
		}
		self.clarinModule.changeLanguage(self.clarinModule.language);
	};

	WsTaskObserver.prototype.checkTaskStatus = function(taskId){
		var self = this;

		// var ajaxBase = "http://ws.clarin-pl.eu/";
		var ajaxBase = "/ws-clarin/";

		var response = $.ajax({
			type:"GET",
			url: ajaxBase + "nlprest2/base/getStatus/"+taskId,
			cache: false,
			crossDomain: true,
			processData: false,
			contentType: false,
			async:false
		}).responseText;

		response = JSON.parse(response);

		var isReady = response.status === 'DONE';
		if (isReady){
			var task = self.tasks.find(function(t){return t.id === taskId});
			task.response = response;
			task.status = 'DONE';

			$.ajax({
				type: 'POST',
				url: OC.generateUrl('/apps/clarin/watchfile'),
				data: $.param(task.params),
				dataType: 'json',
				success: function(res) {
					task.filename = res.fileName;
					task.name = task.taskName + " <b>" + res.fileName + "</b>";

					if (task.type === "ccl-convert"
						|| task.type === "dspace-export"
						|| task.type === "speech-recognition"
					){
						OCA.Files.App.fileList.addAndFetchFileInfo(task.filename, task.folder);
						if (task.type === "ccl-convert" || task.type === "dspace-export"){
							setTimeout(function(){
								OCA.Files.App.fileList.highlightFiles([task.filename]);
							}, 100);
						}
					}
					self.updateTasks();
				},
				error: function(err, res){
					console.log(err, res);
				}
			});


			return true;
		}
		return false;
	};

	WsTaskObserver.prototype.updateTasks = function(){
		var self = this;
		localStorage.setItem(self.localStorageName, JSON.stringify(self.tasks));
	};

	WsTaskObserver.prototype.addNewTask = function(task){
		var self = this;
		task.dateAdd = + new Date();
		self.tasks.push(task);
		self.updateTasks();

		var temp = function(task){
			var callbackIsReady = null;
			if (task.status !== 'DONE')
				callbackIsReady = function(){
					return self.checkTaskStatus(task.id);
				};
			self.clarinModule.addMenuElement('active_tasks', 'check-square-o', task.name,
				task.name, self.getClickFunction(task), callbackIsReady);
		}(task);
	};

	WsTaskObserver.prototype.getClickFunction = function(task){
		var self = this;

		if (task.type === "ccl-convert" || task.type === "dspace-export" || task.type === "speech-recognition" ){
			return  function(){
				if(OCA.Files.App.fileList.getCurrentDirectory() === task.folder){
					OCA.Files.App.fileList.highlightFiles([task.filename]);
					OCA.Files.App.fileList.showDetailsView(task.filename);
				}
				else{
					OCA.Files.App.fileList.changeDirectory(task.folder);
					setTimeout(function(){
						OCA.Files.App.fileList.highlightFiles([task.filename]);
						OCA.Files.App.fileList.showDetailsView(task.filename);
					},200);
				}
				OCA.Clarin.bar.shrink()
			};
		}
		else if(task.type === "wosedon-export"){
			return function(){
				var form = $('<form  target="_blank" action="' +  task.form.action + '" method="post">' +
					'<input type="text" name="token" value="' + task.form.token + '" />' +
					'</form>');
				$('body').append(form);
				form.submit();
			}
		}
		else return function(){
			self.openInNewTab(task.url);
		};
	};

	WsTaskObserver.prototype.openInNewTab = function (url) {
		var win = window.open(url, '_blank');
		win.focus();
	};

	OCA.Clarin.wsTaskObserver = new WsTaskObserver();
});