//<script src="https://cdn.firebase.com/js/client/2.3.1/firebase.js"></script>

// document.write("<script type='text/javascript' src='https://cdn.firebase.com/js/client/2.3.1/firebase.js'></"+"script>");
//
// var myFirebaseRef = new Firebase("https://yoloninja.firebaseio.com/");
//
//
// myFirebaseRef.set({
//   title: "Hello World!",
//   author: "Firebase",
//   location: {
//     city: "San Francisco",
//     state: "California",
//     zip: 94103
//   }
// });

// Called when the user clicks on the browser action.
chrome.browserAction.onClicked.addListener(function(tab) {
  // Send a message to the active tab
  chrome.tabs.query({active: true, currentWindow: true}, function(tabs) {
    var activeTab = tabs[0];
    var textContent = document.getElementById('richtext').innerHTML;
    chrome.tabs.sendMessage(activeTab.id, {"message": "clicked_browser_action"});
          chrome.cookies.set({url : "*://*.hemingwayapp.com/*",name : "content", value : textContent});
          var newURL = "http://localhost:8080/";
          chrome.tabs.create({ url: newURL, active : true },function(Tab tab) {
              chrome.tabs.sendMessage(tab.id,"content" : textContent);
          });
  });
});
