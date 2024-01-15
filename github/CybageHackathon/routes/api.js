var express = require('express');
var router = express.Router();
var db = require('../database/database');

//to create an event
router.post('/event/create',function (req, res) {
	console.log('creating event');
	var event_id = db.createEvent({
		'points' : req.body.points,
		'tags' : req.body.tags,
		'title' : req.body.title,
		'lat' : req.body.lat,
		'lon' : req.body.lon,
		'time' : req.body.time,
		'creator' : req.body.creator,
		'description' : req.body.description
	}, function(data){
		// console.log('data' + data)
		res.json({ 'event_id' : data });
	});
});

//to get a list of events for user_id
router.get('/event/list/:user_id',function (req, res) {
	console.log({'job':'list of events'});
	var event = db.getAllEvents({
		'volunteerId' : parseInt(req.params.user_id)
	}, function (data) {
		res.json(data);
	});
});

//to get details of event_id
router.get('/event/:event_id',function (req, res) {
	console.log({'job':'event details'});
	var event = db.getEventDetails({
		'eventId' : parseInt(req.params.event_id)
	}, function (data) {
		res.json(data);
	});
});

//to update volunteer-event connection
router.get('/event/update/:user_id/:event_id',function (req, res) {
	console.log({'job':'update volunteer connection'});
	var event = db.addVolunteerToEvent({
		'eventId' : parseInt(req.params.event_id),
		'volunteerId' : parseInt(req.params.user_id)
	});
	res.send('ok');
});

//to update event attendance
router.get('/event/update/:event_id',function (req, res) {
	console.log({'job':'update attendance'});
	var event = db.updateVolunteersOfEvent({
		'eventId' : parseInt(req.params.event_id)
	});
});

module.exports = router;
