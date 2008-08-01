// apply to all png images 
//$('img[@src$=.png]').ifixpng(); 
 
// apply to all png images and to div#logo 
//$('img[@src$=.png], div#logo').ifixpng(); 
 
// apply to div#logo, undo fix, then apply the fix again 
$(function(){
	$('img[@src$=.png], #addyourcomment, #search').ifixpng();
	//$("#sform").css("float", "right");
	//alert($('img[@src$=.png], #right-menu-bottom').size());
}); 
 
// apply to div#logo2, modify css property and add click event 
//$('div#logo2').ifixpng().css({cursor:'pointer'}).click(function(){ alert('ifixpng is cool!'); });; 





//#numeros a.num
//#numeros a.num:hover, #numeros a.selected
//right-menu-top
//right-menu-middle
//right-menu-bottom
//