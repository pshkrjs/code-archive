var express = require('express');
var app = express();
var api = require('./routes/api');
var ui = require('./routes/ui');
var bodyParser = require('body-parser');

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));

app.engine('html',require('ejs').renderFile);
app.set('view engine','ejs');
app.use('/static',express.static('public'));

app.use('/api',api);
app.use('/',ui);

app.listen(8080,function () {
	console.log('Starting app on 8080')
});
