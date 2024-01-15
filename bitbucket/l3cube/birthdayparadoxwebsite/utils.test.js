var expect = require('chai').expect;
//var expect = require('chai').equal;
var utils = require('./utils');

describe('utils', function() {
  describe('convertMonthToDays',function() {
    it('should return number of days in a month', function() {
      expect(utils.convertMonthToDays(1)).to.equal(31);
      expect(utils.convertMonthToDays(2)).to.equal(28);
      expect(utils.convertMonthToDays(3)).to.equal(31);
      expect(utils.convertMonthToDays(4)).to.equal(30);
      expect(utils.convertMonthToDays(5)).to.equal(31);
      expect(utils.convertMonthToDays(6)).to.equal(30);
      expect(utils.convertMonthToDays(7)).to.equal(31);
      expect(utils.convertMonthToDays(8)).to.equal(31);
      expect(utils.convertMonthToDays(9)).to.equal(30);
      expect(utils.convertMonthToDays(10)).to.equal(31);
      expect(utils.convertMonthToDays(11)).to.equal(30);
      expect(utils.convertMonthToDays(12)).to.equal(31);
    });
  });

  describe('convertMonthToDayCode', function() {
    it('should return number of days passed till the start of a month', function() {
      expect(utils.convertMonthToDayCode(1)).to.equal(0);
      expect(utils.convertMonthToDayCode(2)).to.equal(31);
      expect(utils.convertMonthToDayCode(3)).to.equal(59);
      expect(utils.convertMonthToDayCode(4)).to.equal(90);
      expect(utils.convertMonthToDayCode(5)).to.equal(120);
      expect(utils.convertMonthToDayCode(6)).to.equal(151);
      expect(utils.convertMonthToDayCode(7)).to.equal(181);
      expect(utils.convertMonthToDayCode(8)).to.equal(212);
      expect(utils.convertMonthToDayCode(9)).to.equal(243);
      expect(utils.convertMonthToDayCode(10)).to.equal(273);
      expect(utils.convertMonthToDayCode(11)).to.equal(304);
      expect(utils.convertMonthToDayCode(12)).to.equal(334);
    });
  })

  describe('convertBirthdayToDayCode', function() {
    it('should return the birthdayCode for given day and month',function() {
      expect(utils.convertBirthdayToDayCode(2,2)).to.equal(33);
      expect(utils.convertBirthdayToDayCode(2,1)).to.equal(2);
      expect(utils.convertBirthdayToDayCode(2,3)).to.equal(61);
      expect(utils.convertBirthdayToDayCode(15,5)).to.equal(135);
      expect(utils.convertBirthdayToDayCode(27,7)).to.equal(208);
      expect(utils.convertBirthdayToDayCode(1,1)).to.equal(1);
      expect(utils.convertBirthdayToDayCode(31,12)).to.equal(365);
    })
  })

});
