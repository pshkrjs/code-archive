var express = require('express');
var router = express.Router();
var request = require('request');

//create new event
router.get('/event/new',function (req, res) {
	res.render('new_event.html',{
		title : 'Add new event'
	});
});

//event details
router.get('/event/:event_id',function (req, res) {
	request.get({ url: 'http://localhost:8080/api/event/' + req.params.event_id },function (err, resp, body) {
		if (!err && resp.statusCode == 200) {
			body = JSON.parse(body);
			res.render('event.html',{
				title : body.title,
				time : body.time,
				description : body.description,
				points: body.points
			});
		}
	});
});

//user dashboard
router.get('/dashboard/:user_id',function (req, res) {
	request.get({ url: 'http://localhost:8080/api/event/list/' + req.params.user_id },function (err, resp, body) {
		if (!err && resp.statusCode == 200) {
			body = JSON.parse(body);
			res.render('dashboard.html',{
				title : body
			});
		}
	});
});

//user dashboard
router.get('/ngo',function (req, res) {
			res.render('ngo.html',{
				title : 'update'
			});
});

//user dashboard
router.get('/main',function (req, res) {
			res.render('main.html',{
				title : 'Main Page'
			});
});

module.exports = router;
