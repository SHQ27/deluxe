function filebrowser(field_name, url, type, win) {
		
	fileBrowserURL = "/backend/pdw_file_browser/index.php?filter=" + type;
			
	tinyMCE.activeEditor.windowManager.open({
		title: "PDW File Browser",
		url: fileBrowserURL,
		width: 950,
		height: 650,
		inline: 0,
		maximizable: 1,
		close_previous: 0
	},{
		window : win,
		input : field_name
	});		
}
