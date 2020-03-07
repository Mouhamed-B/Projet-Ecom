// hover-active

	$('.hover-active').hover(
       function(){ 
       	$(this).addClass('active') 
       	if ($(this).attr('id')=='signout') {
       		$(this).css("background-color","red")
       		$(this).css("border-color","red")
       	}
       },
       function(){
       	if ($(this).attr('id')=='signout') {
       		$(this).css("background-color","")
       		$(this).css("border-color","")
       	} 
        $(this).removeClass('active')
    }
	)

// Deconnexion

	$('a#signout').click(function (event) {
		event.stopPropagation();
		$('button#signout').trigger('click');
	})


// Formulaire responsive 

	function responsiveForm() {
		let appendContent = document.getElementById("responsive-search-btn");
		let prependContent = document.getElementById("responsive-option");
		prependContent.innerHTML =((screen.width<768)?"Tout":"Toute Categorie");
		appendContent.innerHTML = ((screen.width<768)?"<i class=\"fas fa-search\"></i>":"Rechercher");
		$(window).resize(function(){
			responsiveForm();
		});
	}
	responsiveForm();