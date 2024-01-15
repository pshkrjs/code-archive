var request = require('request');

var host = 'localhost',
  	port = 7474,
	httpUrlForTransaction = 'http://' + host + ':' + port + '/db/data/transaction/commit';

// add SimplePointLayer and SpatialRoot index node for spatial data
request.post({
	uri: "http://localhost:7474/db/data/ext/SpatialPlugin/graphdb/addSimplePointLayer",
	json: {
			"layer" : "location",
			"lat" : "lat",
			"lon" : "lon"
		}
	}, function (err, res, body) {

	request.post({
	uri: "http://localhost:7474/db/data/index/node/",
	json: {
		"name" : "location",
		"config" : {
			"provider" : "spatial",
			"geometry_type" : "point",
			"lat" : "lat",
			"lon" : "lon"
			}
		}
	}, function (err, res, body) {
		console.log("Spatial setup resp : " + res);
	});	
});	


// uses REST API of neo4j for cypher queries
function runCypherQuery(query, params, callback) {
  request.post({
      uri: httpUrlForTransaction,
      json: {statements: [{statement: query, parameters: params}]}
    },
    function (err, res, body) {
      callback(err, body);
    })
}


// create an event node
function createEvent (properties, callback) {	
	runCypherQuery(
	  'CREATE (n:event { points: {points}, tags: {tags}, title: {title}, time: {time}, creator: {creator}, description: {description}, lat : {lat}, lon : {lon} }) RETURN ID(n)', properties, 
	  function (err, resp) {
	    if (err) {
	      console.log('Error : ' + err);
	    } else {
	    	// here be dragons. 
	      console.log('New event created response : ' + resp.results[0].data[0].row);
	      callback(resp.results[0].data[0].row);

			// add the node to the spatial layer
			request.post({
				uri: "http://localhost:7474/db/data/ext/SpatialPlugin/graphdb/addNodeToLayer",
				json: {
					  "layer" : "location",
					  "node" : "http://localhost:7474/db/data/node/" + String(resp.results[0].data[0].row)
					}
				}, function (err, res, body) {
					console.log("event node added to spatial layer resp : " + res);
					// return event id

			});
	    }
	  }
	);
	
}


// create a volunteer node
function createVolunteer (properties, callback) {	
	runCypherQuery(
	  'CREATE (n:volunteer { name: {name}, email: {email}, points: {points}, lat : {lat}, lon : {lon} }) RETURN ID(n)', properties, 
	  function (err, resp) {
	    if (err) {
	      console.log('Error : ' + err);
	    } else {
	      console.log('New volunteer created response : ' + resp);
			// add the node to the spatial layer
			request.post({
				uri: "http://localhost:7474/db/data/ext/SpatialPlugin/graphdb/addNodeToLayer",
				json: {
					  "layer" : "location",
					  "node" : "http://localhost:7474/db/data/node/" + String(resp.results[0].data[0].row)
					}
				}, function (err, res, body) {
					console.log("event node added to spatial layer resp : " + res);
					// return volunteer id
					callback(resp.results[0].data[0].row);
			});
	    }
	  }
	);
}

// volunteer agrees to participate in an event
// accepts json of volunteerId, eventId
function addVolunteerToEvent (properties) {	
	runCypherQuery(
	  'MATCH (n:volunteer) WHERE ID(n)={volunteerId} MATCH (e:event) WHERE ID(e)={eventId} CREATE (n)-[:VOLUNTEERING_IN]->(e)', properties, 
	  function (err, resp) {
	    if (err) {
	      console.log('Error : ' + err);
	    } 
	  }
	);
}




// get all events, nearest to a volunteer's geolocation
// json having volunteerId
function getAllEvents (properties, callback) {	
	runCypherQuery(
	  'match (n:volunteer) where id(n)={volunteerId} return n.lat, n.lon', properties,
	  function (err, resp) {
	    if (err) {
	      console.log('Error : ' + err);
	    } else{
	    	// extract lat,long and level to use for spatial query
	    	console.log('lat' + resp.results[0].data[0].row[0])	
	    	console.log('lon' + resp.results[0].data[0].row[1])
	    	// console.log('level' + resp.results[0].data[0].row[2])

			request.post({
				uri: "http://localhost:7474/db/data/ext/SpatialPlugin/graphdb/findGeometriesWithinDistance",
				json: {
				  "layer" : "location",
				  "pointX" : parseInt(resp.results[0].data[0].row[1]),
				  "pointY" : parseInt(resp.results[0].data[0].row[0]),
				  // "distanceInKm" : resp.results[0].data[0].row[2]*1000
				  "distanceInKm" : 10000
					}
				}, function (err, res, body) {
					console.log("nodes within reach of the volunteer : " + res.body[0].data);
					// return event details
					callback(res.body);
				});
	    }
	  }
	);
}


// get all events a user has volunteered_in
// json of volunteerId
function allEventsOfVolunteer (properties, callback) {	
	runCypherQuery(
	  'MATCH (n:volunteer) WHERE ID(n)={volunteerId} MATCH (n)-[:VOLUNTEERING_IN]->(events) RETURN events', properties, 
	  function (err, resp) {
	    if (err) {
	      console.log('Error : ' + err);
	    } else{
	    	console.log('Events participated in : ' + resp)
	    	callback(resp);
	    }
	  }
	);
}


// update points of all volunteers when organizer marks an event complete.
// json of eventId
function updateVolunteersOfEvent (properties) {	
	runCypherQuery(
	  'MATCH (e:eventId) where id(e)={eventId} return id(e),e.points', properties, 
	  function (err, resp) {
	    if (err) {
	      console.log('Error : ' + err);
	    } else {
	    	console.log('points to add to each profile : ' + resp.results[0].data[0].row)
	    	runCypherQuery(
			  'MATCH (b)-[:VOLUNTEERING_IN]->(e) where id(e)={eventId} WITH collect (b) as volunteers foreach (r IN volunteers | set r.points=r.points + {sum})', 
			  {eventId: esp.results[0].data[0].row[0], sum : resp.results[0].data[0].row[1] }, 
			  function (err, resp) {
			    if (err) {
			      console.log('Error : ' + err);
			    } 
			  }
			);
	    }
	  }
	);
}

// try if above fails
// MATCH ()-[:KNOWS]->(b)
// WITH distinct b
// SET b:MyLabel

// OR
// MATCH ()-[:KNOWS]->(b)
// WITH collect (distinct b) as bb
// FOREACH (b IN bb | SET b:MyLabel)



// return event details
// json of eventId
function getEventDetails (properties, callback) {	
	runCypherQuery(
	  'MATCH (e:event) WHERE ID(e)={eventId} return e', properties, 
	  function (err, resp) {
	    if (err) {
	      console.log('Error : ' + err);
	    } else {
	    	callback(resp.results[0].data[0].row[0]);
	    }
	  }
	);
}


module.exports = {
	createEvent : createEvent,
	createVolunteer : createVolunteer,
	addVolunteerToEvent : addVolunteerToEvent,
	getAllEvents : getAllEvents,
	allEventsOfVolunteer : allEventsOfVolunteer,
	updateVolunteersOfEvent : updateVolunteersOfEvent,
	getEventDetails : getEventDetails
}
