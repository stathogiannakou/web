var setTimeoutValue = 10000;

    function updateData(id){
      var tbl = "";
      console.log("Update");
      $.getJSON("update_new.php?id=" + id, null, function( json )
      {
        console.info("All JSON : " + JSON.stringify(json));
        // console.info("json len : " + json.length());
        
		var count = Object.keys(json).length;  
		 // console.info("json : " + json);
		 // console.info("count : " + count);
		if(count > 0) 
		{
			// Create table caption

			tbl = ('<table> \
			<tr><th>Στοιχεία παραλαβής</th></tr> \
			<tr><td><span class="color2">test</span></td></tr> \
			<tr><td>Όνομα καταστήματος: <span class="color">' + json.onoma_katastimatos + '</span></td></tr> \
			<tr><td>Διεύθυνση: <span class="color">' + json.dieuthunsi_katastimatos + '</span></td></tr> \
			</table> \
			<br><br> \
			<table> \
			<tr><th>Στοιχεία παράδοσης</th></tr> \
			<tr><td><span class="color2">test</span></td></tr> \
			<tr><td>Επώνυμο: <span class="color">' + json.epwnumo_pelati + '</span></td></tr> \
			<tr><td>Διεύθυνση: <span class="color">' + json.odos + '</span></td></tr> \
			<tr><td>Όροφος: <span class="color">' + json.orofos + 'ος</span></td></tr> \
			<tr><td>Τηλέφωνο: <span class="color">' + json.tilefwno_pelati + '</span></td></tr> \
			<tr><td>Συνολικό ποσό: <span class="color">' + json.sunoliko_poso + '&euro;</span></td></tr> \
			</table>');
      // gmap(json['lat'], json['lon']);
      // gmap();
      
      
      // testMap('38.24684', '21.73545');
      gMap(json['lat'], json['lon']);
      
      $("#but_complete").html('<form action="" method="post"> \
          <button class="button">Παραδόθηκε</button> \
          <input type="hidden" name ="order" value="complete"></input> \
        </form>');         
		}		
		else
		{
				tbl = ('<span class="msg"><p>Δεν εκκρεμμεί παραγγελία.</p></span>');
        setTimeout(function(){updateData(id);}, setTimeoutValue);
		}
          
        $("#deliveras").html(tbl);         
        
      });
    };


function gMap(Lat,Lon){
    $("#myMap").googleMap({
      zoom: 16, // Initial zoom level (optional)
      type: "ROADMAP", // Map type (optional)      
    });
    
    $("#myMap").addMarker({
      coords: [Lat,Lon], // Map center (optional)
    });

}
   
$(document).ready(function() {
  console.info(JSON.stringify(JSession));
  updateData(JSession['id_dianomea']);
  // updateData(JSession);
  // gMap('38.24684', '21.73545');
  console.info("Document ready");
});
