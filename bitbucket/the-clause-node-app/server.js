require('newrelic');
var medium = require('medium-sdk')
var express = require('express');

var app = express();

app.set('view engine', 'ejs');


var mongoose = require('mongoose');                     // mongoose for mongodb
    var morgan = require('morgan');             // log requests to the console (express4)
    var bodyParser = require('body-parser');    // pull information from HTML POST (express4)
    var methodOverride = require('method-override'); // simulate DELETE and PUT (express4)

    app.use( bodyParser.json() );       // to support JSON-encoded bodies
    app.use(bodyParser.urlencoded({     // to support URL-encoded bodies
      extended: true
    }));

    app.use(express.static(__dirname + '/public'));

var client = new medium.MediumClient({
  clientId: 'f9ac9c750c0a',
  clientSecret: '92b6bd6f149866abe1872ef77da25c0f70ea4955'
})

var mediumPostContent;
var postTitle,visibility,postLicense,userName,imageUrl,postUrl,userUrl,isDraft,postTags;

var local = "localhost";
var amazon = "ec2-52-23-242-131.compute-1.amazonaws.com";
var clause = "ec2-54-86-128-95.compute-1.amazonaws.com";
var host = clause;

//routes

// route for home page
  app.get('/', function(req, res) {
      console.log("yolo");
      res.sendfile('./public/index.html');
  });

  app.get('/landing',function(req,res){
    res.redirect('https://xprs.imcreator.com/free/adityashirole/the-clause-2');
  });

  app.get('/clause/new',function(req,res) {
    console.log('REQUESTING /CLAUSE/NEW : ' +  req);
      res.sendfile('./public/new.html');
  });

  app.post('/',function(req,res){
    console.log("POST REQ to root: " + req);
    //console.log("CONTENT : " + req.body.content);
    mediumPostContent = req.body.content;
      //res.sendfile('./public/index.html');
      res.redirect('https://medium.com/m/oauth/authorize?client_id=f9ac9c750c0a&scope=basicProfile,publishPost&state=yolo&response_type=code&redirect_uri=http://' + host + ':8080/auth/callback');

  });

  app.get('/auth/medium',function(req,res) {
      res.redirect('https://medium.com/m/oauth/authorize?client_id=f9ac9c750c0a&scope=basicProfile,publishPost&state=yolo&response_type=code&redirect_uri=http://' + host + ':8080/auth/callback');
  });

  app.get('/auth/callback',function(req,res) {
      console.log("code is : " + req.query.code);
      var code = req.query.code;
      client.exchangeAuthorizationCode(code, 'http://' + host + ':8080/auth/callback',function(err,token) {
          if (!err) {
            client.getUser(function(err,user){
              console.log("USER INFO :" + JSON.stringify(user.data.imageUrl));
              console.log("POST CONTENT IS : " + mediumPostContent);

              userName = user.data.name;
              imageUrl = user.data.imageUrl;
              userUrl = user.data.url;

              client.createPost({
                userId: user.data.id,
                title: postTitle,
                contentFormat: medium.PostContentFormat.HTML,
                content: mediumPostContent,
                publishStatus: medium.PostPublishStatus.DRAFT,
                license : postLicense,
                publishStatus : visibility,
                tags : splitString
              }, function (err, post) {
                console.log(token, user, post)
                //res.redirect('/auth/done');

                //this is also stable
                //res.sendfile('./public/wait.html');
                //console.log("check this : \n\n\n" + post.data);

                if (visibility === 'draft') {
                  isDraft = 1;
                } else {
                  isDraft = 0;
                }

                if (post != null) {
                    postUrl = post.data.url;
                    //but use this
                    //res.send(JSON.stringify(user) + "," + JSON.stringify(post));
                    res.render('done',{
                      username : userName,
                      posttitle : postTitle,
                      imageUrl : imageUrl,
                      postUrl : postUrl,
                      userUrl : userUrl,
                      isDraft :  isDraft,
                      tags : splitString
                    });
                } else {
                  res.send("Sorry, An error occured");

                }
              })
            });

          } else {console.log(token + " error : " + err);
          }
      })

  });

  app.get('/auth/done',function(req,res){
    console.log("Done : " + req);
    res.sendfile('./public/welcome.html');

  })

  app.post('/medium/post',function(req,res){
      console.log("POST REQ : " + req);
      console.log("CONTENT : " + req.body.content);
      mediumPostContent = req.body.content;
      postTitle= req.body.title ;
      visibility = req.body.visibility;
      postLicense = req.body.license;
      var tagString;
      tagString = req.body.postTags;
      //tagString = tagString.substring(0,tagString.length-2);
      console.log("tagString is : " + tagString);
      splitString = tagString.split(",");
      console.log("After splitting : " + splitString[0]);

      postTags = [];
      for (var i = 0; i < splitString.length; i++) {
        postTags.push(splitString[i]);
      }

      // postTags = "[";
      // if ( (splitString.length-1) == 1) {
      //   postTags += '"' + splitString[0] + '"]';
      // } else if ((splitString.length-1) == 2) {
      //   postTags += '"' + splitString[0] + '",' + '"' + splitString[1] + '"]';
      // } else if ((splitString.length-1) == 3) {
      //   postTags += '"' + splitString[0] + '",' + '"' + splitString[1] + '",' + '"' + splitString[2] + '"]';
      // }



      //console.log("Final string is : " + postTags);

      //res.redirect('https://medium.com/m/oauth/authorize?client_id=f9ac9c750c0a&scope=basicProfile,publishPost&state=yolo&response_type=code&redirect_uri=http://' + host + ':8080/auth/callback');
      res.send('Okay');

  });



// listen (start app with node server.js) ======================================
    app.listen(8080);
    console.log("App listening on port 8080");


var url = client.getAuthorizationUrl('yolo', 'https://google.com', [
  medium.Scope.BASIC_PROFILE, medium.Scope.PUBLISH_POST
])
