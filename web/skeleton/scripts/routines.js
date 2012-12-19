// JavaScript Document

$(document).ready(function(){
						   
	Shadowbox.init({
		animate: "false",
		continuous: "true",
		counterType: "skip",
		enableKeys: "false",
		overlayColor: "#000000",
		slideshowDelay:"4",
		overlayOpacity: 0.9,
		players: ["img", "swf" , "html" , "php"],
		flashParams: { bgcolor: '#ffffff' }
	});
	
// Paragraphe-On-Off

	$(".paragrapheOnOff").addClass("close");
	$(".close").next().hide();
	
	$(".paragrapheOnOff").each(function(){
		$(this).click(function(){
			
			if ($(this).hasClass("close")){			
				$(this).removeClass("close").addClass("open");
				$(".paragrapheOnOff").not(this).removeClass("open").addClass("close");
			}
			else{
				$(this).removeClass("open").addClass("close");
			}
			
			$(".close").next().hide("slow");
			$(".open").next().show("slow");
			
		});	
	});	
						   
	$("#menu-references").each(function(){
		$(this).click(function(e){
			e.preventDefault();
			window.open('references.php','_self');
		});	
	});

	$("#menu-prestations").each(function(){
		$(this).click(function(e){
			e.preventDefault();
			window.open('prestations.php','_self');
		});	
	});

	$("#menu-galerie").each(function(){
		$(this).click(function(e){
			e.preventDefault();
			window.open('galerie.php','_self');
		});	
	});

	$("#menu-presse").each(function(){
		$(this).click(function(e){
			e.preventDefault();
			window.open('presse.php','_self');
		});	
	});
	
	$("#menu-contacts").each(function(){
		$(this).click(function(e){
			e.preventDefault();
			window.open('contacts.php','_self');
		});	
	});

	$("#module-contacts").each(function(){
		$(this).click(function(e){
			e.preventDefault();
			window.open('contacts.php','_self');
		});	
	});

	$("#module-tarifs").each(function(){
		$(this).click(function(e){
			e.preventDefault();
			window.open('tarifs.php','_self');
		});	
	});

	$("#module-livre-or").each(function(){
		$(this).click(function(e){
			e.preventDefault();
			window.open('livre-or.php','_self');
		});	
	});

	$("#module-actualites").each(function(){
		$(this).click(function(e){
			e.preventDefault();
			window.open('actualites.php','_self');
		});	
	});

	$("#facebook").each(function(){
		$(this).click(function(e){
			e.preventDefault();
			window.open('http://www.facebook.com/people/John-Valente/100002880938164','_blank');
		});	
	});

	$("#menu-mentions").each(function(){
		$(this).click(function(e){
			e.preventDefault();
			window.open('mentions.php','_self');
		});	
	});

	$(".diaporama").each(function(){
		$(this).click(function(e){
			e.preventDefault();
			window.open('references.php','_self');
		});	
	});

	$("#logo").each(function(){
		$(this).click(function(e){
			e.preventDefault();
			window.open('index.php','_self');
		});	
	});


}); //ready

