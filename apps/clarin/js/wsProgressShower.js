/**
 * Created by wrauk on 16.11.17.
 */

OCA.Clarin = {};
$(document).ready(function() {
	OCA.Clarin.bar = new ClarinModule({
		offset:{
			'top': 0,
			'right': null,
			// 'bottom': '200px',
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

	function wsTaskObserver(){
		this.localStorageName = 'Clarin-ws-active-tasks';
		this.clarinModule = OCA.Clarin.bar;
		this.init();

	}
	wsTaskObserver.prototype.init = function(){
		var self = this;
		self.tasks = JSON.parse(localStorage.getItem(self.localStorageName));

		if(!self.tasks){
			self.tasks = [];
		}
		// starting to observe
		self.initClarinModuleList()
	};

	wsTaskObserver.prototype.initClarinModuleList = function(){
		var self = this;
		self.clarinModule.addMenu('active_tasks', "Twoje zadania", "Your tasks");
		console.log(self.tasks);
		for(var i = 0; i < self.tasks.length; i++){
			var temp = function(task){
				var callbackIsReady = null;
				if (task.status !== 'DONE')
					callbackIsReady = function(){
						return self.checkTaskStatus(task.id);
					};
				self.clarinModule.addMenuElement('active_tasks', 'check-square-o', task.name, task.name,
					function(){
						window.location = OC.webroot + '/index.php/apps/files/?dir=' + encodeURIComponent(task.folder);
					},
					callbackIsReady
				);
			}(self.tasks[i]);
		}
		self.clarinModule.changeLanguage(self.clarinModule.language);
	};

	wsTaskObserver.prototype.checkTaskStatus = function(taskId){
		var self = this;
		return true; // todo
		var response = $.ajax({
			type:"GET",
			url:"http://ws.clarin-pl.eu/nlprest2/base/getStatus/"+taskId,
			cache: false,
			crossDomain: true,
			processData: false,
			contentType: false,
			async:false
		}).responseText;

		response = JSON.parse(response);
		console.log(response);
		return true;
		var isReady = response.status === 'DONE';
		if (isReady){
			var task = self.tasks.find(function(t){return t.id === taskId});
			task.response = response;
			task.status = 'DONE';
			self.updateTasks();
			return true;
		}
		return false;
	};

	wsTaskObserver.prototype.updateTasks = function(){
		var self = this;
		localStorage.setItem(self.localStorageName, JSON.stringify(self.tasks));
	};

	wsTaskObserver.prototype.addNewTask = function(task){
		var self = this;
		task.dataAdd = + new Date();
		self.tasks.push(task);
		self.updateTasks();

		var temp = function(task){
			var callbackIsReady = null;
			if (task.status !== 'DONE')
				callbackIsReady = function(){
					return self.checkTaskStatus(task.id);
				};
			self.clarinModule.addMenuElement('active_tasks', 'check-square-o', task.name, task.name,
				function(){
					window.location = OC.webroot + '/index.php/apps/files/?dir=' + encodeURIComponent(task.folder);
				},
				callbackIsReady
			);
		}(task);
	};

	OCA.Clarin.wsTaskObserver = new wsTaskObserver();
});