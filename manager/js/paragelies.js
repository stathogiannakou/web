var setTimeoutValue = 10000;

    function updateData(id){
      var tbl = "";
      console.log("Update");
      $.getJSON("update_new.php?id=" + id, null, function( json )
      {
        console.info(JSON.stringify(json.ParageliesData));
        console.info("json len : " + json.ParageliesData.length);
        
		var count = Object.keys(json.ParageliesData).length;  
		if(count > 0) 
		{
			// Create table caption
			tbl = ('<table class="ordertbl"> \
			<tr> \
			  <th width="7%">Αρ. Παρ.</th> \
			  <th width="7%">Ώρα</th> \
			  <th width="15%">Επώνυμο</th> \
			  <th width="10%">Τηλέφωνο</th> \
			  <th width="15%">Διεύθυνση</th> \
			  <th width="45%">Προϊόντα</th> \
			  <th width="5%">Ποσό</th> \
			</tr>');


			for (j =0; j < json.ParageliesData.length; j++){

			  tbl += ('<tr> \
				  <td>' + json.ParageliesData[j].id + '</td> \
				  <td>' + json.ParageliesData[j].time + '</td> \
				  <td>' + json.ParageliesData[j].epwnumo + '</td> \
				  <td>' + json.ParageliesData[j].tilefwno + '</td> \
				  <td>' + json.ParageliesData[j].odos + '</td> \
				  <td>' + json.ParageliesData[j].proionta + '</td> \
				  <td>' + json.ParageliesData[j].poso + '</td> \
				  </tr>');
			}
			
			tbl += ('</table>');
		}		
		else
		{
				tbl = "Δεν εκκρεμμούν παραγγελίες";
		}
          
        $("#orders").html(tbl);         
        
        setTimeout(function(){updateData(id);}, setTimeoutValue);
      });
    };
    
$(document).ready(function() {
  console.info(JSON.stringify(JSession));
  updateData(JSession['id_kat']);
  console.info("Document ready");
});
