var express = require('express');
var router = express.Router();
var bodyParser = require('body-parser');

// for parsing application/json
router.use(bodyParser.json());

// Return catchup with :id
router.get('/catchup/:id', function(req, res){
    res.json({'todo':'Return catchup with ' + req.params.id});
});

// update catchup with :id
router.post('/catchup/:id', function(req, res){
    console.log(req.body);
    res.json({'todo':req.body});
});

// Create catchup
router.post('/catchup', function(req, res){
    console.log(req.body);
    res.json({'todo':req.body});
});

module.exports = router;
