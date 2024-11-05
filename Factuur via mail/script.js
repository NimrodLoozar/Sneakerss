document.getElementById("factuurForm").onsubmit = function() {
    const naam = document.getElementById("naam").value;
    const email = document.getElementById("email").value;
    const bedrag = document.getElementById("bedrag").value;
  
    if (naam === "" || email === "" || bedrag <= 0) {
      alert("Vul alle velden correct in.");
      return false;
    }
    return true;
  };
  