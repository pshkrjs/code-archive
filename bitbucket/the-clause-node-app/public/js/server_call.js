
$(document).ready(function() {

	var local = "localhost";
	var amazon = "ec2-52-23-242-131.compute-1.amazonaws.com";
	var clause = "www.theclause.tk";
	var host = clause;
	var tag_values;



var license_desc = [
	"You waive all your copyright and related rights in this work, worldwide.",
	"This work is already in the public domain and free of copyright restrictions.",
	"Others can distribute, remix, and build upon your work as long as they credit you.",
	"Others can distribute your work as long as they credit you.<br>Others can only distribute non-derivative copies of your work.",
	"Others can distribute, remix, and build upon your work as long as they credit you.<br>Others must distribute derivatives of your work under the same license.",
	"Others can distribute, remix, and build upon your work as long as they credit you.<br>Others can use your work for non-commercial purposes only.",
	"Others can distribute your work as long as they credit you.<br>Others can use your work for non-commercial purposes only.<br>Others can only distribute non-derivative copies of your work.",
	"Others can distribute, remix, and build upon your work as long as they credit you.<br>Others can use your work for non-commercial purposes only.<br>Others must distribute derivatives of your work under the same license.",
	"Others cannot copy, distribute, or perform your work without your permission (or as permitted by fair use)."];
var license_val = [
	"cc-40-zero",
	"public-domain",
	"cc-40-by",
	"cc-40-by-nd",
	"cc-40-by-sa",
	"cc-40-by-nc",
	"cc-40-by-nc-nd",
	"cc-40-by-nc-sa",
	"all-rights-reserved"];
var visibility_desc = [
	"The story will only be visible to you.",
	"The story will be public. Your followers will be notified when you publish for the first time.",
	"The story will only be visible to those with the link. It won’t be listed on Medium’s public pages (your profile, homepage)."];
var visibility_val = [
	"draft",
	"public",
	"unlisted"];
    $('ul.tabs').tabs();


		$("#publish_btn").attr("disabled","disabled");

	$("#post_title").focusout(function(){
		$("#publish_btn").attr("disabled","disabled");
		var str = ($("#post_title").val()).trim().length;
		if(!str){
			Materialize.toast('Please Enter a Title!',4000);
			$("#post_title").focus();
		}else{
			$("#publish_btn").removeAttr("disabled");
		}
	});


	var selected = $(".group_license:checked");
	var selectedVal = selected.val();
	console.log(license_desc[selectedVal]);
	$("#license_desc").html(license_desc[selectedVal]);
	var selected1 = $(".group_visibility:checked");
	var selectedVal1 = selected1.val();
	console.log(visibility_desc[selectedVal1]);
	$("#visibility_desc").html(visibility_desc[selectedVal1]);

    $("#post_tag_input").keypress(function(){
    	var keycode = (event.keyCode ? event.keyCode : event.which);
	    //var chip_length = document.getElementById("post_tag_input").value();
	    //console.log(chip_length);
		if(keycode == '13'){
			var tag_count = document.getElementsByClassName("chip").length;
		var flag = 0;
		if(tag_count != 3){
			var tag_text = ($("#post_tag_input").val()).trim();
			var tag_length = tag_text.length;
			tag_values = document.getElementsByClassName("tag_val");
			if (tag_values != null) {
			for (var i = tag_values.length - 1; i >= 0; i--) {
				if($(tag_values[i]).attr("value")==tag_text){
					Materialize.toast('Tags cannot be similar!');
					flag = 1;
				}
			};
			}
			if(!flag){
				if(tag_length > 0 && tag_length < 25){
					var tag_div = document.createElement("DIV");
					tag_div.setAttribute("value",tag_text);
					var tag_close = document.createElement("I");
					$("#post_tag_input").val("");
					var tag = document.createTextNode(tag_text);
					var close = document.createTextNode("close");
					$(tag_div).attr("class","chip tag_val");
					$(tag_close).attr("class","material-icons");
					tag_close.appendChild(close);
					tag_div.appendChild(tag_close);
					tag_div.appendChild(tag);
					document.getElementById("post_tags").appendChild(tag_div);
				}else{
					Materialize.toast('Tag should be 0-25 characters long!', 4000);
				}
			}
		}else{
			Materialize.toast('Only 3 tags are allowed!', 4000);
		}
		}
    });
    $(".group_license").change(function(){
    	selected = $(".group_license:checked");
			selectedVal = selected.val();
			console.log(license_desc[selectedVal]);
			$("#license_desc").html(license_desc[selectedVal]);
    });
    $(".group_visibility").change(function(){
    	selected1 = $(".group_visibility:checked");
		selectedVal1 = selected1.val();
		console.log(visibility_desc[selectedVal1]);
		$("#visibility_desc").html(visibility_desc[selectedVal1]);
    });
	$('#publish_btn').click(function(){
		var isValid = true;
		var textContent = document.getElementById("post_body").innerHTML;
		var textTitle = document.getElementById("post_title").value.trim();
		var selectedLicense = license_val[selectedVal];
		var selectedVisibility = visibility_val[selectedVal1];
		var postTags = "";
/*
		if (document.getElementById("tag0") != null) {
			postTags += document.getElementById("tag0").value.trim();
		}

		if (document.getElementById("tag1") != null) {
			postTags += "," + document.getElementById("tag1").value.trim();
		}

		if (document.getElementById("tag2") != null) {
			postTags += "," + document.getElementById("tag2").value.trim();
		}
*/
		if (tag_values != null) {
			for (var i = tag_values.length - 1; i >= 0; i--) {
				//console.log($(tag_values[i]).attr("value"));
				if (i == 0) {
					postTags += ($(tag_values[i]).attr("value"))+"";
				} else {
					postTags += ($(tag_values[i]).attr("value"))+",";
				}
				//alert(postTags);
			};
		}

			//alert("Yolo : " + textContent);
			//alert("content : " + textContent + "\n title : " + textTitle + "\n license : " + selectedLicense + " \n visibility : " + selectedVisibility);

			if (isValid) {

				$.ajax({
					type : "POST",
					url : "http://" + host + ":8080/medium/post",
					data : {content : textContent, title : textTitle, license : selectedLicense, visibility : selectedVisibility, postTags : postTags },
					success : function() {
					//	console.log("AWESOME. successfully sent ajax");
						window.location="http://medium.com/m/oauth/authorize?client_id=f9ac9c750c0a&scope=basicProfile,publishPost&state=yolo&response_type=code&redirect_uri=http://" + host + ":8080/auth/callback";
					},
					error : function() {
						console.log("Error. while sending ajax");
					}
				});
			}

	});
});
