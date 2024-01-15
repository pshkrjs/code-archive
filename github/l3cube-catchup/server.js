var express = require('express');
var parseServer = require('./routes/parse-server');
var parseDashboard = require('./routes/parse-dashboard');
var catchup = require('./routes/catchup');
var app = express();

// Serve the Parse API on the /parse URL
app.use('/parse', parseServer);
// Serve the Parse Dashboard available at /dashboard
app.use('/dashboard', parseDashboard);
// Serve custom catchup APIs available on /
app.use('/', catchup);

app.listen(8080, function() {
  console.log('App running on port 8080.');
});