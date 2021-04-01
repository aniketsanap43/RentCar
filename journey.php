<!DOCTYPE HTML>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width initial-scale=1">

<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://kit.fontawesome.com/a8442dd671.js" crossorigin="anonymous"></script>
  <!--Google Font Poppins-->
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap" rel="stylesheet">
  <link href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet">
  <!--Font Awesome-->
  	<!-- My CSS -->
	<link rel="stylesheet" href="assets/css/style.css" type="text/css">
	<link rel="stylesheet" href="assets/css/journey.css" type="text/css">
	<link rel="stylesheet" href="assets/css/all.min.css">

	<title>RentCar</title>
</head>
<body scroll="no">
<div class="journey-info">
	<div class="pickup-location">
    <h1>Tell us your Starting Point</h1>
			<ul class="pickup-list">
				<li>
          <select name="country" id="country" class="list-form-control">
						<option value="">Select Country</option>
          </select>
        </li>
				<li>
          <select name="state" id ="state" class="list-form-control">
						<option value="">Select State</option>
          </select>
        </li>	
				<li>
          <select name="city" id="city" class="list-form-control" onclick="enable_next_button()">
            <option value="">Select City</option>
          </select>
        </li>
      </ul>
      <button class="next-btn" id="button_add1" disabled>Next</button>
  </div>
  
  <div class="pickup-time">
    <h1>From When do you need a Zoomcar?</h1>
    <h4>Book Your Date</h4>
    <div class="date-picker">
      <label for="check-in">Pickup Date</label> <!-- <input type="textfield" class="form-control" id="check-in" placeholder="12.20.2014"> -->
      <input type="text" id="start_date" name="start_date" placeholder="mm/dd/yyyy">
      <label for="check-out">Drop Off Date</label> <!-- <input type="textfield" class="form-control" id="check-out" placeholder="12.27.2014"> -->
      <input type="text" id="end_date" name="end_date"placeholder="mm/dd/yyyy">
    </div>
    <button class="next-btn" id="button_add2" disabled>Next</button>
  </div>
  <p id="hj"></p>
</div>
  
<!-- Always use this jQuery link just above of closing tag of body -->
<!-- Scripts --> 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="//code.jquery.com/jquery-1.12.0.min.js"></script>

  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

  <!-- Popper JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</body>
</html>

<script>

//when page is open,it will load location data
$(document).ready(function(){
  $('.pickup-time').hide();
  load_json_data('country');
  function load_json_data(id, parent_id){
    var html_code = '';
    $.getJSON('country_state_city.json', function(data){
      html_code += '<option value="">Select '+id+'</option>';
      $.each(data, function(key, value){
        if(id == 'country')
        {
          if(value.parent_id == '0')
          {
          html_code += '<option value="'+value.id+'">'+value.name+'</option>';
          }
        }
        else
        {
        if(value.parent_id == parent_id){
          html_code += '<option value="'+value.id+'">'+value.name+'</option>';
        }
        }
      });
      $('#'+id).html(html_code);
    });
  }
  //selecting state on change country
  $(document).on('change', '#country', function(){
    var country_id = $(this).val();
    if(country_id != '')
    {
    load_json_data('state', country_id);
    }
    else
    {
    $('#state').html('<option value="">Select state</option>');
    $('#city').html('<option value="">Select city</option>');
    }
  });
  //selecting cities on change state
  $(document).on('change', '#state', function(){
    var state_id = $(this).val();
    if(state_id != '')
    {
    load_json_data('city', state_id);
    }
    else
    {
    $('#city').html('<option value="">Select city</option>'); 
    }
  });
});

//below fn used for to enable the button_add1
$(document).ready(function () {
  $('#city').change(function () {
    selectVal = $('#city').val();
   
    if (selectVal == "Select City") {
       $('#button_add1').prop("disabled", true);
    }
    else {
      $('#button_add1').prop("disabled", false);
    }
  })
});

//on clicking button location div is hide and pickup_time will be visible
$('#button_add1').click(function(){
    $('.pickup-location').hide();
    $('.pickup-time').show();
});

//booking date using jquery datepicker function
$( document ).ready(function() {
  $( function() {
    var dateToday = new Date();
    var dates = $("#start_date, #end_date").datepicker({
      defaultDate: "+2d",
      changeMonth: true,
      numberOfMonths: 1,
      minDate: dateToday,
      onSelect: function(selectedDate) {
          var option = this.id == "start_date" ? "minDate" : "maxDate",
          instance = $(this).data("datepicker"),
          date = $.datepicker.parseDate(instance.settings.dateFormat || $.datepicker._defaults.dateFormat, selectedDate, instance.settings);
          dates.not(this).datepicker("option", option, date);
      }
    });
  });
});

// enabling button_add2 by selection date value
$('#end_date').datepicker({
    onSelect: function(dateText){
        var date2 = $('#end_date').val();
            var curDate = new Date(); 
            if(date2 < curDate){ //comparing new date to end date
              $("#button_add2").attr("disabled", true);
            }else{
              $("#button_add2").attr("disabled", false);
            }
        }
});

//to send location and pickup dates through url to book_car.php file
$(function () {
    $("#button_add2").bind("click", function () {
      //by clicking button we send location data in type of JSON
      //also we are sending user dates to book_car.php file
      //this data are visible in URL section
      //for this function I have required 4 days
        var url = "includes/book_car.php?country_val=" + encodeURIComponent($("#country").val()) 
        + "&state_val=" + encodeURIComponent($("#state").val())
        + "&city_val=" + encodeURIComponent($("#city").val())
        + "&start_date_val=" + encodeURIComponent($("#start_date").val())
        + "&end_date_val=" + encodeURIComponent($("#end_date").val());
        window.location.href = url;
    });
});

</script>