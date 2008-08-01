
// Basic, basic style switcher

function toggle(stylesheetId){
	if (document.getElementById && document.getElementById('customstyles')){
		document.getElementById('customstyles').href = '/stylesheets/theme/' + stylesheetId + '.css';
	}
}