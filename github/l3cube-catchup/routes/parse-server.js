var ParseServer = require('parse-server').ParseServer;

module.exports = new ParseServer({
  databaseURI: 'mongodb://pass:PASStheword@ds013414.mlab.com:13414/catchup', // Connection string for your MongoDB database
  //cloud: '/home/myApp/cloud/main.js', // Absolute path to your Cloud Code
  appId: 'a5ffb6374b9b25d0d43d247b153ff03d',//catchup-app
  masterKey: '3d3982a74cda3b9167416350dd3de68c', //catchup-master
  //fileKey: 'optionalFileKey',
  serverURL: 'http://localhost:8080/parse' // Don't forget to change to https if needed
});