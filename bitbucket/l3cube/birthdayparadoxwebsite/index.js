var express = require('express');
var request = require("request");
var app = new express();
var utils = require('./utils');


app.set("views", "views/")
app.set('view engine','ejs');

app.use('/scripts', express.static(__dirname + '/node_modules/'));

app.get('/',function(req,res) {
  res.render('main',{

  });
})


app.get('/paradox',function(req,res) {
  var results = [],labels = [], data = [], expectedData = [];

  //run the experiment for 0-367 people in the room
  for (var i = 0; i < 368; i++) {
    var result = new Object();
    var experimentalProbabilty = utils.performExperiment(i,2000).toFixed(4);
    var expectedProbability = utils.getProbability(i).toFixed(4);
    result.numberOfPeople = (i.toString());
    result.experimentalProbabilty = experimentalProbabilty;
    result.expectedProbability = expectedProbability
    results.push(result);
    data.push(experimentalProbabilty);
    expectedData.push(expectedProbability);
    labels.push(i.toString() + " people");
  }

  res.render('result',{
    results: results,
    labels: labels,
    data: data,
    expectedData: expectedData
  });
});

app.get('/paradoxFor/:numberOfPeople/:numberOfTries',function(req,res) {
    var output = [];
    var day, month, dayCode;
    var labels = [], data = [];

    var result = {
        'numberOfPeople':req.params.numberOfPeople,
        'numberOfTries' : req.params.numberOfTries,
        'Expected_Prob': utils.getProbability(req.params.numberOfPeople),
        'Calculated_Prob': utils.performExperiment(req.params.numberOfPeople,req.params.numberOfTries)
      };


    res.render('singleResult',{
      result: result
    });

});


app.get('/chart',function(req,res) {
  res.render('chartview',{

  });
})

app.get('/offline',function(req,res) {
  var results = [],labels = [], data = [], expectedData = [];

  //run the experiment for 0-367 people in the room
  for (var i = 0; i < 368; i++) {
    var result = new Object();
    var experimentalProbabilty = utils.performExperiment(i,2000).toFixed(4);
    var expectedProbability = utils.getProbability(i).toFixed(4);
    result.numberOfPeople = (i.toString());
    result.experimentalProbabilty = experimentalProbabilty;
    result.expectedProbability = expectedProbability
    results.push(result);
    data.push(experimentalProbabilty);
    expectedData.push(expectedProbability);
    labels.push(i.toString() + " people");
  }

  res.send({
    results: results  
  });
})



app.listen(process.env.PORT || 8002);
console.log('Listening on port');
