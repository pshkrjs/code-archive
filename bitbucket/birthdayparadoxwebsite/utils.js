var peopleData = require('./birthdayData').peopleData;
var randomArraySubset = require('random-array-subset');
var exports = module.exports = {};

/*Number of pairs = numberOfPeople * (numberOfPeople -1)/2)
Chance of a unique pair =364/365
Chance of total unique pairs  (numberOfPeople * (numberOfPeople -1)/2)^(364/365)
Chance of some match is the return value */
getProbability = function (numberOfPeople){
  return 1 - Math.pow((364/365),(numberOfPeople * (numberOfPeople -1)/2));
}


getRandomInteger = function (min, max) {
  return Math.floor(Math.random() * (max - min + 1)) + min;
}

runFor = function (people){
	var assigned = [];
	var dataSetMin = getRandomInteger(1,2000 - people);

	for(var i = 1; i < 366;i++)
		assigned[i] = 0;

  var birthday;
  for(i=0;i<people;i++){
    var randomIndex = i + dataSetMin
		birthday = peopleData[randomIndex].birthdayCode;
		if (assigned[birthday] == 1)
			return 1;
		assigned[birthday] = 1;
	}
	return 0;
}

perfExpt = function (people,tries){
	var success = 0;
  var resultArray = [];
	for(var i=0;i<tries;i++) {
    success += runFor(people);
  }


	return success/tries;
}

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


// month : Integer
// day : Integer
convertBirthdayToDayCode = function(day, month) {
  return convertMonthToDayCode(month) + day;
}

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
exports.perfExpt = perfExpt;
