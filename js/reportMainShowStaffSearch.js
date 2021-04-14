$("#sendStaffBut").on("click", function () {
   let surname = $("#surname").val();
   let name = $("#name").val();
   let middlename = $("#middlename").val();

   let errors_div = document.getElementById("errors_div");



   let arr;

   $.ajax({
      url: 'controllers/ajax/reportShowStaffSearchController.php',
      type: 'POST',
      cache: false,
      data: {
         'surname': surname,
         'name': name,
         'middlename': middlename},
      dataType: 'html',
      success: function (respond) {
         if (respond)
         {
            while (errors_div.firstChild) {
               errors_div.removeChild(errors_div.firstChild);
            }

            let newRespond = JSON.parse(respond);
            newRespond.forEach(function (element)
            {
               let myDiv = document.createElement("div");
               myDiv.className = "alert alert-danger mb-1 p-2 text-center";
               myDiv.role = "alert";
               myDiv.innerHTML = element;
               errors_div.appendChild(myDiv);
            });
         }
      }
   })
});