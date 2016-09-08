(function($){
	var sns_con = { setTitle: "", setUrl: "", 
		getLink: function(d){
			var url ="";
			switch(d){
				case "twitter":
					url = "http://twitter.com/share?url=" + this.setUrl + "&text=" + this.setTitle; break;
				case "google":
					url = "https://plus.google.com/share?url=" + this.setUrl;break;
				case "linkedin":
					url = "http://www.linkedin.com/shareArticle?mini=true&url=" + this.setUrl + "&title=" + this.setTitle;break;
				default:
					alert("error");
					return false;
			};
			if(url != ""){
				window.open(encodeURI(url));
			}
		}
	};

	$(document).on("click", ".share-facebook", function(){
		var title = '',url = '',image = '',description = '';
		var winWidth = 520, winHeight = 350;
		title = $(this).data("title");
		url = $(this).data("url");
		image = $(this).data("image");
		if($("#detail").length > 0){
			description = $("#detail").text();
		}
		var winTop = (screen.height / 2) - (winHeight / 2);
        var winLeft = (screen.width / 2) - (winWidth / 2);
        window.open(encodeURI('http://www.facebook.com/sharer.php?u=' + url + '&title=' + title + '&caption='+ title +'&description='+ description + '&picture='+image), 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
		return false;
	});

	$(document).on("click", ".share-google", function(){
		var url = '';
		var winWidth = 520, winHeight = 350;
		url = $(this).data("url");
		var winTop = (screen.height / 2) - (winHeight / 2);
        var winLeft = (screen.width / 2) - (winWidth / 2);
        window.open(encodeURI("https://plus.google.com/share?url=" + url), 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
		return false;
	});

	$(document).on("click", ".share-twitter", function(){
		sns_con.setTitle = $(this).data("title");
		sns_con.setUrl = $(this).data("url");
		sns_con.getLink("twitter");
		return false;
	});

	/*$(document).on("click", ".share-google", function(){
		sns_con.setTitle = $(this).data("title");
		sns_con.setUrl = $(this).data("url");
		sns_con.getLink("google");
		return false;
	});*/

	$(document).on("click", ".share-linkedin", function(){
		sns_con.setTitle = $(this).data("title");
		sns_con.setUrl = $(this).data("url");
		sns_con.getLink("linkedin");
		return false;
	});

	$(document).on("click", ".share-pinterest", function(){
		var image = $(this).data("url");
		window.open('http://pinterest.com/pin/create/button/?url=' + image, 'sharer', 'top=' + winTop + ',left=' + winLeft + ',toolbar=0,status=0,width=' + winWidth + ',height=' + winHeight);
		return false;
	});

})(jQuery);