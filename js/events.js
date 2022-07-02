
	
//		for( let el of document.querySelectorAll ('.list_messege')){
//			el.addEventListener('click', ()=>{
////				console.log(el)
//			
//				let id_mail = document.getElementById('mail_id').getAttribute('mail');
//				window.location.href = `https://linemail.sytes.net/testmail/mail.php?mail=${id_mail}`;
//				
//			})
//		}


console.log("event");


document.addEventListener('click',e => {
  
   //ajax
   if (e.target.className === 'form-control liga') {
       console.log(e.target.className);
       console.log("456");
       console.log(e.target);
       console.log(e.target.className);
       let liga = document.getElementById("id_form_liga").value;
       console.log(liga);
           
           
       $.ajax({
           /* адрес файла-обработчика запроса */
           url: 'liga.php',
           /* метод отправки данных */
           method: 'POST',
           /* данные, которые мы передаем в файл-обработчик */
           data: {"liga" : liga
           },
           /* что нужно сделать до отправки запрса */
           beforeSend: function() {
           
           //inProgress = true;
          }
           /* что нужно сделать по факту выполнения запроса */
          }).done(function(data){

           /* Преобразуем результат, пришедший от обработчика - преобразуем json-строку обратно в массив */
           
           //let data = 1;
           //$.each(data, function(index,data) {
                
                //if (data.length > 0) {
                    //console.log('массив не пустой ' + data);

                // data.forEach(function(elem) {
                //     console.log(elem + '<br>');
                // });
                    // data.forEach(element => {
                    //     $("#team").html("<div><label><input type='checkbox' name='teams[]' value='8'>" + element + "</label>" + "</div>" );
                    // });
                    //console.log(typeof(data));
                    //data = Array.from(data);
                    //console.log(typeof(data));
                    var arr = JSON.parse( data );
                    // console.log(Array.isArray(data));
                    // console.log(data);
                    console.log(arr);
                    for (index = 1; index < arr.length; ++index) {
                        console.log(arr[index]);
                        $("#team").append("<div class='checkselect' ><label><input type='checkbox' name='teams[]' value='" + arr[index] +"'>" + arr[index] + "</label>" + "</div>" );
                    }
                    // arr.forEach(element => {
                    //     $("#team").html("<div><label><input type='checkbox' name='teams[]' value='8'>" + element + "</label>" + "</div>" );
                    // });
                //}
           

            //});

           	
           
        });
       
   
    }
});

//pag next round l