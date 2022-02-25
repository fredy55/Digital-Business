//create session storage for cart items
if (sessionStorage.getItem("items") === null) {
   sessionStorage.setItem("items", JSON.stringify([]));
}
else {
   //sessionStorage.removeItem("items");
}

//Ensure that page has loaded well
if (document.readyState == "loading") {
  document.addEventListener("DOMContentLoaded", ready);
} else {
  ready();
}

function ready() {
  
  //Load cart items
  loadCartItems();
  
  //Click to remove cart item let 
  removeCartItem = document.getElementsByClassName("remove-item");
  //console.log(removeCartItem);
  for (let i = 0; i < removeCartItem.length; i++) {
    let button = removeCartItem[i];
    button.addEventListener("click", removeCartItems);
  }
  
  
}

//save item to session storage
function saveItemToSession(id, code, name, price, qty, total, invenQty) {
  let savedItems = JSON.parse(sessionStorage.getItem("items"));
  
  let cartItem = {
     itemId: id,
	 code: code,
	 name: name,
     price: price,
     quantity: qty,
     total:total,
     inventoryQty:parseInt(invenQty)+parseInt(qty)
  } 
  
  //Avoid repeatation
  for (let i = 0; i < savedItems.length; i++) { 
    if (savedItems[i].name === cartItem.name) {
      alert("Item is aready added to list!");
      return;
    }
  }

  savedItems.push(cartItem); //add item to array 
  //console.log(savedItems);
  console.log(cartItem);
  
  //save item to session storage
  sessionStorage.setItem("items", JSON.stringify(savedItems)); 
  
  //update cart
  loadCartItems();
  
}

//Load cart item
function loadCartItems() {
  let cartItem = JSON.parse(sessionStorage.getItem("items"));
  let cartRow = "";
  //let cartRow = document.createElement('div');
  //let addItem = document.getElementsByClassName("cart-items-frame")[0];

  if (cartItem !== null) {
    for (let i = 0; i < cartItem.length; i++) {
      //cartRow.innerHTML = 
      let rowItem = 
			`<div class="row cart-items">
				<div class="col-xs-3 col-sm-3 col-md-3 item-title">${cartItem[i].name}</div>
				<div class="col-xs-2 col-sm-2 col-md-2 item-price">&#8358;${formatNum(cartItem[i].price)}</div>
				<div class="col-xs-2 col-sm-2 col-md-2 item-qty">${cartItem[i].quantity}</div>
				<div class="col-xs-2 col-sm-2 col-md-2 item-total">&#8358;${formatNum(cartItem[i].total)}</div>
				<div class="col-xs-2 col-sm-2 col-md-1">
				   <input type="hidden" name="inventory[]" value="${cartItem[i].name}" class="form-control" required />
				   <input type="hidden" name="code[]" value="${cartItem[i].code}" class="form-control" required />
				   <input type="hidden" name="cost[]" value="${cartItem[i].price}" class="form-control" required />
				   <input type="hidden" name="quantity[]" value="${cartItem[i].quantity}" class="form-control" required />
				   <input type="hidden" name="total[]" value="${cartItem[i].total}" class="form-control" required />
				   <input type="hidden" name="itemId[]" value="${cartItem[i].itemId}" class="form-control" required />
				   <input type="hidden" name="invenQty[]" value="${cartItem[i].inventoryQty}" class="form-control" required />
				</div>
				<div class="col-xs-2 col-sm-2 col-md-1">
				   <button class="remove-item">X</button>
				</div>
				
			</div>`;

      cartRow = cartRow + rowItem;
	  //addItem.append(cartRow);
	  
    }
	
	 let addItem = document.getElementsByClassName("cart-items-frame")[0];
     addItem.innerHTML = cartRow;
     //cartRow.getElementsByClassName("remove-item")[0].addEventListener("click", removeCartItems);
      
	  removeCartItem = document.getElementsByClassName("remove-item");
	  //console.log(removeCartItem);
	  for (let i = 0; i < removeCartItem.length; i++) {
		let button = removeCartItem[i];
		button.addEventListener("click", removeCartItems);
	  }
     
	 //update cart total
     updateCartTotal();
  }
  
}

//Remove item from cart
function removeCartItems(event) {
  let cartRowItems = JSON.parse(sessionStorage.getItem("items"));
  
  
  let clickedBtn = event.target;
  let mainItem = clickedBtn.parentElement.parentElement; //remove cart element
  console.log(clickedBtn);
  console.log(cartRowItems);
  
  let itemTitle = mainItem.getElementsByClassName("item-title")[0].innerText;
  console.log(itemTitle);
  
  for (let x = 0; x < cartRowItems.length; x++) {
	if (cartRowItems[x].name === itemTitle) {
	  //console.log(cartRowItems[x].name);
	  cartRowItems.splice(x, 1);
	  
	}
  }

  mainItem.remove(); //remove cart element
  
  //console.log(cartRowItems);
  updateCartItems(cartRowItems);
  
  //update cart total
  updateCartTotal();
  
  //Load cart items
  loadCartItems();
  
  
  
}

//Restrict Amount paid
function checkAmtPaid(){
   let x = document.getElementsByClassName("amt-paid")[0];
   let y =document.getElementsByClassName("grand-total")[0];
   let paid = parseInt(x.value);
   let itemsTot = parseInt(trimValue(y.innerText));
   
   console.log(itemsTot);
   console.log(paid);
   
   if(isNaN(paid) || paid>itemsTot){
	   alert('Invalid amount!');
	   document.getElementsByClassName("amt-paid")[0].value=0.0;
   }
}    

//Update cart total price
function updateCartTotal() {
  let cartItems = JSON.parse(sessionStorage.getItem("items"));
  

  if (cartItems !== null) {
	let itemTotal = 0;
	
    for (let x = 0; x < cartItems.length; x++) {
      let unitTotal = cartItems[x].total;

      itemTotal = itemTotal + unitTotal;
    }
	
	//console.log("GRAND TOTAL",itemTotal);
    document.getElementById("grand-total").value =formatNum(itemTotal);
     
  }
}

//Add default item qty
function getItemQty(){
	let x = document.getElementById("quantity");
	x.value = 1;
}

//Add default item qty
function limitItemQty(){
	let input = document.getElementById("quantity");
	
	if (isNaN(input.value) || input.value < 1) {
	  input.value = 1;
	}
}

//Update session storage
function updateCartItems(cartItems) {
  //save item to session storage
  sessionStorage.setItem("items", JSON.stringify(cartItems));
}

//Remove commas and currency symbols
function trimValue(money) {
  let price = money;

  if (isNaN(money[0])) {
    price = money.replace(money[0], "");
  }

  if (money.indexOf(",")) {
    price = price.replace(",", "");
  }

  return price;
}

//change to currency format
function formatNum(num) {
  return Math.round(num * 100) / 100; //Round to 2dp
}

//Clear cart items
function clearCartItems() {
  sessionStorage.setItem('items', JSON.stringify([]));
}
