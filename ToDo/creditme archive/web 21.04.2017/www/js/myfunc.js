    function myFunction() {
        var x = document.getElementById("mySelect").value;
        document.getElementById("demo").innerHTML = "You selected: " + x;
    }

function loadDoc() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("conditions").innerHTML =
      this.responseText;
    }
  };
  var x = document.getElementById("mySelect").value;
  xhttp.open("GET", "/filterselect/"+x, true);
  xhttp.send();
}
