
var request = require('request');

var host = 'localhost',
  	port = 7474,
	httpUrlForTransaction = 'http://' + host + ':' + port + '/db/data/transaction/commit';

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

// runCypherQuery(
// 	  'START node=node:location('withinDistance:[48.2,16.3,100.0]') return node', properties, 
// 	  function (err, resp) {
// 	    if (err) {
// 	      console.log('Error : ' + err);
// 	    } else{


// // create an event node
// function createEvent (properties, callback) {	
// 	runCypherQuery(
// 	  'CREATE (n:event { points: {points}, tags: {tags}, title: {title}, location: {location},\
// 	  					time: {time}, creator: {creator}, description: {description}, lat : {lat}, lon : {lon} }) RETURN ID(n)', properties, 
// 	  function (err, resp) {
// 	    if (err) {
// 	      console.log('Error : ' + err);
// 	    } else {
// 	    	// here be dragons. 
// 	      console.log('New event created response : ' + resp.results[0].data[0].row);
// 			// add the node to the spatial layer
// 			request.post({
// 				uri: "http://localhost:7474/db/data/ext/SpatialPlugin/graphdb/addNodeToLayer",
// 				json: {
// 					  "layer" : "location",
// 					  "node" : "http://localhost:7474/db/data/node/" + String(resp.results[0].data[0].row)
// 					}
// 				}, function (err, res, body) {
// 					console.log("event node added to spatial layer resp : " + res);
// 					// return event id
// 					// callback(resp.results[0].data[0].row);
// 			});
// 	    }
// 	  }
// 	);
// }


// // get all events, nearest to a volunteer's geolocation
// // json having volunteerId
// function getAllEvents (properties, callback) {	
// 	runCypherQuery(
// 	  'match (n:event) where id(n)={volunteerId} return n.lat, n.lon, n.level', properties, 
// 	  function (err, resp) {
// 	    if (err) {
// 	      console.log('Error : ' + err);
// 	    } else{
	    	
// 	    	// extract lat,long and level to use for spatial query
// 	    	console.log('lat' + resp.results[0].data[0].row[0])	
// 	    	console.log('lon' + resp.results[0].data[0].row[1])
// 	    	console.log('level' + resp.results[0].data[0].row[2])

// 			request.post({
// 				uri: "http://localhost:7474/db/data/ext/SpatialPlugin/graphdb/findGeometriesWithinDistance",
// 				json: {
// 				  "layer" : "location",
// 				  "pointX" : parseInt(resp.results[0].data[0].row[1]),
// 				  "pointY" : parseInt(resp.results[0].data[0].row[0]),
// 				  // "distanceInKm" : resp.results[0].data[0].row[2]*1000
// 				  "distanceInKm" : 1000
// 					}
// 				}, function (err, res, body) {
// 					console.log("nodes within reach of the volunteer : " + res.body[20].data.lat);
// 					// return event details
// 					callback(res.body);
// 			});   	
// 	    }
// 	  }
// 	);
// }


// update points of all volunteers when organizer marks an event complete.
// json of eventId
function updateVolunteersOfEvent (properties) {	
	runCypherQuery(
	  'MATCH (e:event) where id(e)={eventId} return id(e), e.points', properties, 
	  function (err, resp) {
	    if (err) {
	      console.log('Error : ' + err);
	    } else {
	    	console.log('points to add to each profile : ' + resp.results[0].data[0].row[0])
	    	runCypherQuery(
			  'MATCH (b)-[:VOLUNTEERING_IN]->(e) where id(e)={eventId} WITH collect (b) as volunteers foreach (r in volunteers | set r.points = r.points + {sum})', 
			  {eventId: parseInt(resp.results[0].data[0].row[0]), sum : parseInt(resp.results[0].data[0].row[1]) }, 
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

// createEvent({ points: "", tags: "", title : "", description :"", location : "", time : "", creator: "", lat : 18.5298413, lon : 73.8455817});
// createEvent({ points: "", tags: "", title : "", description :"", location : "", time : "", creator: "", lat : 18.5228534, lon : 73.8369194});
// createEvent({ points: "", tags: "", title : "", description :"", location : "", time : "", creator: "", lat : 18.5051081, lon : 73.8446987});

// getAllEvents({volunteerId : 11});

updateVolunteersOfEvent({eventId : 12});