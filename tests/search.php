<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script type="text/javascript">

    $(document).ready(function() {


      // FILTERS DIVS IN LIST BY SEARCH BAR INPUT
      $("#search_bar").on("keyup click input", function () {
        var searchText = $(this).val().toLowerCase();
        if (searchText.length) {
            $(".list_item_container").hide().filter(function () {
              var itemText = $('h5, p',this).text().toLowerCase();
                return itemText.indexOf(searchText) != -1;
            }).show();
        } else {
            $(".list_item_container").show();
        };
      });




    });

    </script>

  </head>
  <body>



    <div class="search_bar_container">
      <input id="search_bar" type="text" class="search_bar" placeholder="Search">
    </div>











     <div class="list">

        <div class="list_item_container" data-convo="10" style="">
          <h5>Speedster</h5>
          <p>StarLabs</p>
        </div>
        <div class="list_item_container" data-convo="11" style="">
          <h5>iPhone tester</h5>
          <p>Apple</p>
        </div>
        <div class="list_item_container" data-convo="12" style="">
          <h5>Gadget maker</h5>
          <p>StarLabs</p>
        </div>
        <div class="list_item_container" data-convo="16" style="">
          <h5>CEO</h5>
          <p>WayneEnterprises</p>
        </div>
        <div class="list_item_container" data-convo="17" style="">
          <h5>test123456</h5>
          <p>StarLabs</p>
        </div>

      </div>


     </div>
  </body>
</html>
