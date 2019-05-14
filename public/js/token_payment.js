function execPurchase(response) {
  if (response.resultCode != "000") {
    window.alert("購入処理中にエラーが発生しました");
  } else {
    document.getElementById("number").value = "";
    document.getElementById("expire_year").value = "";
    document.getElementById("expire_month").value = "";
    document.getElementById("security_code").value = "";
    document.getElementById("tokennumber").value = "";
    document.getElementById("token").value = response.tokenObject.token;
    document.getElementById("purchaseForm").submit();
  }
}

function doPurchase() {
  // processがregisteredの場合は処理をスキップする
  var radios = document.getElementsByName("process");
  var checkValue = "";
  for(var i=0; i<radios.length; i++){
    if (radios[i].checked) {
      checkValue = radios[i].value;
    }
  }

  if (checkValue == "registered") {
    document.getElementById("purchaseForm").submit();
  } else {
    var cardno, expire, securitycode, holdername;
    var cardno = document.getElementById("number").value;
    var expire = document.getElementById("expire_year").value + document.getElementById("expire_month").value;

    var securitycode = document.getElementById("security_code").value;
    var holdername = document.getElementById("holder_name").value;
    var tokennumber = document.getElementById("tokennumber").value;
    Multipayment.init(PGCARD_SHOP_ID);
    Multipayment.getToken({
      cardno : cardno,
      expire : expire,
      securitycode : securitycode,
      holdername : holdername,
      tokennumber : tokennumber
    }, execPurchase);
  }
}
