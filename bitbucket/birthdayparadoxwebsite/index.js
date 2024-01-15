var express = require('express');
var request = require("request");
var app = new express();
var utils = require('./utils');


app.set("views", "views/")
app.set('view engine','ejs');

app.get('/chart',function(req,res) {
  res.render('chartview',{

  });
})

app.get('/',function(req,res) {
  res.render('main',{

  });
})


app.get('/paradox',function(req,res) {
  var results = [],labels = [], data = [], expectedData = [];
  for (var i = 0; i < 368; i++) {
    var result = new Object();
    var experimentalProbabilty = utils.perfExpt(i,2000).toFixed(4);
    var expectedProbability = utils.getProbability(i).toFixed(4);
    result.numberOfPeople = (i.toString());
    result.experimentalProbabilty = experimentalProbabilty;
    result.expectedProbability = expectedProbability
    results.push(result);
    data.push(experimentalProbabilty);
    expectedData.push(expectedProbability);
    labels.push(i.toString() + " people");
  }

  // res.send(output);

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
/*
    for (var i = 0; i < peopleData.length; i++) {
        day = parseInt(peopleData[i].birthday.substring(0,2));
        month = parseInt(peopleData[i].birthday.substring(3,5));
        var birthdayCode = utils.convertBirthdayToDayCode(day,month)
        peopleData[i].birthdayCode = birthdayCode;
    }
*/
		//for (var i = 0; i < 23; i++) {
    //  var tries = 1000;
    //  var numberOfPeople = i;
      var result = {'numberOfPeople':req.params.numberOfPeople,'numberOfTries' : req.params.numberOfTries,'Expected_Prob':utils.getProbability(req.params.numberOfPeople),'Calculated_Prob':utils.perfExpt(req.params.numberOfPeople,req.params.numberOfTries)};
      output.push(result)
      //labels.push(i.toString());

    //}


    console.log(output);
    //res.send(result);

    res.render('singleResult',{
      result: result
    });



});

app.get('/random',function(req,res) {
  var array = [1,2,3,4,5,6,7];
  var randomArraySubset = require('random-array-subset');
  var newArray = randomArraySubset(array,4);
  res.send(newArray);
})


app.listen(process.env.PORT || 8002);
console.log('Listening on port');
