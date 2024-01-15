module.exports = function(app) {
	app.get('/:file',function(req,res){
		res.sendFile('../dist/'+req.params.file);
	});
};