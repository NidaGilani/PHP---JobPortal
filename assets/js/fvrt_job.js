var $add = $("#addFavourite");
var $remove = $("#removeFavourite");

$add.on("click", function() {
  $add.hide();
  $remove.show();
  
  var itemId = $add.data("item-id");
  alert("adding item " + itemId);

  // do your AJAX stuff to add the favourite here
  
});

$remove.on("click", function() {
  $add.show();
  $remove.hide();
  
  var itemId = $add.data("item-id");
  alert("removing item " + itemId);

  // do your AJAX stuff to remove the favourite here
  
});
var $add = $("#addFavourite");
var $remove = $("#removeFavourite");

$add.on("click", function() {
  $add.hide();
  $remove.show();
  
  var itemId = $add.data("item-id");
  alert("adding item " + itemId);

  // do your AJAX stuff to add the favourite here
  
});

$remove.on("click", function() {
  $add.show();
  $remove.hide();
  
  var itemId = $add.data("item-id");
  alert("removing item " + itemId);

  // do your AJAX stuff to remove the favourite here
  
});
// #removeFavourite {
//   display: none;
// }