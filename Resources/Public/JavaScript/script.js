//0 -> disabled; 1 -> enabled;
var popupStatus = 0;

//Current Frame for flashPlayer
var cFrame = 0;


function loadPopup(){
  if(popupStatus==0){
    $("#tx-atolcmis-more-background").css({
      "opacity": "0.0"
    });

   // $("#tx-atolcmis-more-background").fadeIn("fast");
    $("#tx-atolcmis-more").fadeIn("fast");

    popupStatus = 1;
  }
}


function disablePopup(){
  if(popupStatus==1){
    //$("#tx-atolcmis-more-background").fadeOut("fast");
    $("#tx-atolcmis-more").fadeOut("fast");
    popupStatus = 0;
  }
}


function centerPopup(X,Y){

  $("#tx-atolcmis-more").css({
  "position": "absolute",
  "top": Y+25,//$("#tx-atolcmis-more").height(),
  "left": X+25
  });
}

$(document).ready(function(){
  //---------------------- Pop Up --------------------------//
  jQuery('.tx-atolcmis-list-show > h1').click(
    function(e){
      if(popupStatus == 0){
        centerPopup(e.pageX,e.pageY);
        loadPopup();
      }
      else{
        disablePopup();
      }
    }
  );
  
  //Close the pop with a click
  $("#tx-atolcmis-more").click(function(){
    disablePopup();
  });
  //Click On background
  $("#tx-atolcmis-more-background").click(function(){
    disablePopup();
  });
  //Press Escape
  $(document).keypress(function(e){
    if(e.keyCode==27 && popupStatus==1){
      disablePopup();
    }
  });
});