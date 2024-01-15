var peopleData = require('./birthdayData').peopleData;
var randomArraySubset = require('random-array-subset');
var exports = module.exports = {};


/*
Used to calculate the expected Probability using the formula

Number of pairs = numberOfPeople * (numberOfPeople -1)/2)
Chance of a unique pair =364/365
Chance of total unique pairs  (numberOfPeople * (numberOfPeople -1)/2)^(364/365)
Chance of some match is the return value */
getProbability = function (numberOfPeople){
  return 1 - Math.pow((364/365),(numberOfPeople * (numberOfPeople -1)/2));
}


// returns a random integer between <min> and <max> ( excluding zero )
getRandomInteger = function (min, max) {
  return Math.floor(Math.random() * (max - min + 1)) + min;
}

// runs the experiment for <numberOfPeople> and returns 1 if match is found, else 0
// <numberOfPeople> people are selected randomly from 2000 people
runExperimentFor = function (numberOfPeople){
	var assigned = [], birthday;

  // used to generate random dataset
  var dataSetMin = getRandomInteger(1,2000 - numberOfPeople);

  // initialise assigned array
	for(var i = 1; i < 367;i++) {
		assigned[i] = 0;
  }

  for(i=0;i<numberOfPeople;i++){
    var randomIndex = i + dataSetMin
		birthday = peopleData[randomIndex].birthdayCode;

		if (assigned[birthday] == 1) {
      // Match found. returns 1
			return 1;
    }

		assigned[birthday] = 1;
	}

  // No match found. Returns 0
	return 0;
}

// returns experimental Probability for <numberOfPeople> people in a room with <tries> trials
// performs the experiment with <numberOfPeople> people in the room.
// The experiment is performed <tries> number of times.
performExperiment = function (numberOfPeople,tries){
	var success = 0; //use to store the number of times the experiment was successful

	for(var i=0;i<tries;i++) {
    success += runExperimentFor(numberOfPeople);
  }

	return success/tries;
}

//Not used anymore.
convertMonthToDays = function (monthNumber) {
  switch (monthNumber) {
    case 1:
      return 31;

    case 2:
      return 28;

    case 3:
        return 31;

    case 4:
      return 30;

    case 5:
      return 31;

    case 6:
      return 30;

    case 7:
      return 31;

    case 8:
      return 31;

    case 9:
      return 30;

    case 10:
      return 31;

    case 11:
      return 30;

    case 12:
      return 31;

    default:
      return 0;
  }
}

// not used anymore
// <month> : Integer
// <day> : Integer
convertBirthdayToDayCode = function(day, month) {
  return convertMonthToDayCode(month) + day;
}

// Not used anymore
// Returns the number of days that have passed so far in the year till this month.
// example: for March, it will be Jan(31) + Feb(28) = 59 days
// month : Integer
convertMonthToDayCode = function(month) {
  var count = 0;
  for (var i = 1; i < month; i++) {
    count += convertMonthToDays(i);
  }
  return count;
}

exports.convertBirthdayToDayCode = convertBirthdayToDayCode;
exports.convertMonthToDays = convertMonthToDays;
exports.convertMonthToDayCode = convertMonthToDayCode;
exports.getProbability = getProbability;
exports.getRandomInteger = getRandomInteger;
exports.performExperiment = performExperiment;
